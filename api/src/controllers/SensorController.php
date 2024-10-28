<?php

namespace src\controllers;

use src\components\Entry;
use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 17.10.2024
 */
class SensorController extends BaseController
{
    /**
     * Returns the Entry Query to get all sensors.
     * @return Entry
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 22.10.2024
     */
    private function getSensorQuery(): Entry
    {
        $this->entry->reset();

        return $this->entry->columns([
                'sensors' => ['id', 'maxTemp', 'minTemp', 'name', 'address', 'color', 'created_at', 'updated_at'],
                'manufacturers' => ["name AS 'manufacturer'"]]
        )->tables([
            'sensors',
            ['manufacturers', 'sensors.manufacturer_id', 'manufacturers.id']
        ])->where([
            'sensors' => [['active', true]],
            'manufacturers' => [['active', 'true']]
        ]);
    }

    /**
     * Returns all sensors.
     * @return array|bool|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 17.10.2024
     */
    public function actionAll(): bool|array|string
    {
        $temperaturesLimit = $this->getParam(0, 'tempLimit', 10);

        // get all sensors
        $sensors = $this->getSensorQuery()->all();

        // add last meassured temperatures
        foreach ($sensors as &$sensor) {

            // build temperature query
            $this->entry->reset();
            $temperatureQuery = $this->entry->columns(['temperatures' => ['id', 'temperature', 'updated_at', 'created_at']])
                ->tables('temperatures')
                ->where(['temperatures' => [['active', true], ['sensor_id', $sensor['id']]]])
                ->limit($temperaturesLimit)
                ->order('temperatures.created_at DESC');

            // get last temperature row
            $lastTemperature = $temperatureQuery->one();

            // does last temperature exist?
            if (!empty($lastTemperature)) {

                // add current temperature
                $sensor['currentTemperature'] = $lastTemperature['temperature'] ?? 0;
            }

            // get the highest and lowest meassured temp
            $minMaxTempEntry = new Entry();

            $minMaxTempQuery = $minMaxTempEntry->columns(['temperatures' => ['temperature']])
                ->tables('temperatures')
                ->where(['temperatures' => [['active', true], ['sensor_id', $sensor['id']]]]);

            $sensor['highestTemp'] = $minMaxTempQuery->max();
            $sensor['lowestTemp'] = $minMaxTempQuery->min();
            $sensor['avgTemp'] = $minMaxTempQuery->avg();

            // sensor good temperature
            $sensor['infoColor'] = '#23c235';

            // sensor one before to hot?
            if ($sensor['currentTemperature'] == ($sensor['maxTemp'] - 1)) {
                $sensor['infoColor'] = '#ff6721';
            }

            // sensor to hot?
            if ($sensor['currentTemperature'] > $sensor['maxTemp']) {
                $sensor['infoColor'] = '#ff2121';
            }

            // sensor one before to cold?
            if ($sensor['currentTemperature'] == ($sensor['minTemp'] + 1)) {
                $sensor['infoColor'] = '#c421ff';
            }

            // sensor to cold?
            if ($sensor['currentTemperature'] < $sensor['minTemp']) {
                $sensor['infoColor'] = '#2197ff';
            }

            // add latest temperatures
            foreach ($temperatureQuery->all() as $temp) {
                $sensor['temperatures'][] = [
                    'created_at' => date('d.m.y', strtotime($temp['created_at'])),
                    'time' => date('H:i:s', strtotime($temp['created_at'])),
                    'temperature' => $temp['temperature'],
                ];
            }
        }

        // return all sensors
        return $sensors;
    }

    /**
     * Add random temperatures foreach sensor.
     * @return void
     * @throws RandomException
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 22.10.2024
     */
    public function actionSimulate(): void
    {
        $loops = $this->getParam(0, 'loops', 10);

        // loop through total loops
        for ($i = 0; $i < $loops; $i++) {

            // get all sensors
            $sensors = $this->actionAll();

            // loop through each sensor
            foreach ($sensors as $sensor) {

                // get min, max
                $sensorId = $sensor['id'];
                $minTemp = $sensor['minTemp'];
                $maxTemp = $sensor['minTemp'];
                $currentTemp = $sensor['currentTemperature'] ?? 0;

                // random int
                $higherOrLower = rand(0, 2);

                // add or remove 1
                if ($higherOrLower === 0) {
                    $newRandomTemperature = $currentTemp - 1;
                } else {
                    $newRandomTemperature = $currentTemp + 1;
                }

                // not lower than 5 under minTemp
                if ($newRandomTemperature <= $minTemp - 5) {
                    $newRandomTemperature = $minTemp - 5;
                }

                // not higher than 5 above maxTemp
                if ($newRandomTemperature >= $maxTemp + 5) {
                    $newRandomTemperature = $maxTemp + 5;
                }

                // insert value
                $success = $this->entry->insert('temperatures', ['sensor_id' => $sensorId, 'temperature' => $newRandomTemperature], false);

                if (!$success) {
                    ResultHelper::render([
                        'message' => $_SESSION['entry']['error']
                    ], 500, ['translate' => false]);
                }

            }

            sleep(1);
        }

        ResultHelper::render([
            'message' => ResultHelper::t('Successfully inserted {loops}x temperatures for all sensors.', ['loops' => $loops])
        ], 200, ['translate' => false]);
    }

    /**
     * Updates a sensors max and min temp
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 22.10.2024
     */
    public function actionUpdate(): void
    {
        $user = $this->requireUser();
        $this->requireRole('Admin');

        $sensorId = $this->getParam(0, 'sensor_id');
        $name = $this->getParam(3, 'name', null, true);
        $color = $this->getParam(3, 'color', null, true);
        $maxTemp = $this->getParam(1, 'maxTemp', null, true);
        $minTemp = $this->getParam(2, 'minTemp', null, true);
        $address = $this->getParam(3, 'address', null, true);
        $active = $this->getParam(3, 'active', null, true);

        // get old value
        $sensor = $this->entry->columns(['sensors' => ['maxTemp', 'minTemp', 'name', 'address', 'color', 'active']])
            ->tables('sensors')
            ->where(['sensors' => [['id', $sensorId]]])
            ->one();

        if (empty($sensor)) {
            ResultHelper::render([
                'message' => 'Could not find a sensor to update.'
            ], 404, $this->defaultConfig);
        }

        $updates = [];

        // new max Temp?
        if (is_numeric($maxTemp)) {
            if ($sensor['maxTemp'] !== $maxTemp)
                $updates['maxTemp'] = $maxTemp;
        }

        // new min temp?
        if (is_numeric($minTemp)) {
            if ($sensor['minTemp'] !== $minTemp)
                $updates['minTemp'] = $minTemp;
        }

        // new name?
        if (!empty($name)) {
            if ($sensor['name'] !== $name)
                $updates['name'] = $name;
        }

        // new address?
        if (!empty($address)) {
            if ($sensor['address'] !== $address)
                $updates['address'] = $address;
        }

        // new color?
        if (!empty($color)) {
            if ($sensor['color'] !== $color)
                $updates['color'] = $color;
        }

        // new active?
        if (is_bool($active)) {
            if ($sensor['active'] !== $active)
                $updates['active'] = $active;
        }

        if (empty($updates)) {
            ResultHelper::render([
                'message' => 'Nothing to update.'
            ], 404, $this->defaultConfig);
        }

        // try to update sensor
        $updated = $this->entry->update('sensors', $updates, ['id' => $sensorId], true);

        // update successfull?
        if (!$updated) {
            ResultHelper::render([
                'message' => 'Could not update the sensor.'
            ], 500, $this->defaultConfig);
        }

        // insert into logs
        foreach ($updates as $column => $value) {
            $this->entry->insert('logs', [
                'user_id' => $user['id'],
                'action' => 'update',
                'relation' => 'sensors',
                'relation_id' => $sensorId,
                'old_value' => $sensor[$column],
                'new_value' => $value,
                'column_name' => $column
            ], false, false);
        }

        // return success
        ResultHelper::render([
            'message' => 'Successfully updated the sensor.'
        ], 200, $this->defaultConfig);
    }

    /**
     * Creates a new sensor.
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 23.10.2024
     */
    public function actionCreate(): void
    {
        $user = $this->requireUser();
        $this->requireRole('Admin');

        $name = $this->getParam(0, 'name');
        $serverId = $this->getParam(1, 'server_id');
        $manufacturerId = $this->getParam(2, 'manufacturer_id');
        $maxTemp = $this->getParam(3, 'maxTemp', 30);
        $minTemp = $this->getParam(4, 'minTemp', -30);
        $address = $this->getParam(5, 'address');
        $color = $this->getParam(6, 'color', '#ffffff');

        // name given?
        if (empty($name)) {
            ResultHelper::render([
                'message' => 'Could not find a valid name.'
            ], 404, $this->defaultConfig);
        }

        // server id given?
        if (!is_numeric($serverId)) {
            ResultHelper::render([
                'message' => 'Could not find a valid server id.'
            ], 404, $this->defaultConfig);
        }

        // manufacturer id given?
        if (!is_numeric($manufacturerId)) {
            ResultHelper::render([
                'message' => 'Could not find a valid manufacturer id.'
            ], 404, $this->defaultConfig);
        }

        // maxTemp given?
        if (!is_numeric($maxTemp)) {
            ResultHelper::render([
                'message' => 'Could not find a valid maxTemp.'
            ], 404, $this->defaultConfig);
        }

        // minTemp given?
        if (!is_numeric($minTemp)) {
            ResultHelper::render([
                'message' => 'Could not find a valid minTemp.'
            ], 404, $this->defaultConfig);
        }

        $sensorId = $this->entry->insert('sensors', [
            'name' => $name,
            'manufacturer_id' => $manufacturerId,
            'address' => $address,
            'color' => $color,
            'server_id' => $serverId,
            'minTemp' => $minTemp,
            'maxTemp' => $maxTemp,
        ]);

        if (!is_numeric($maxTemp)) {
            ResultHelper::render([
                'message' => 'Could not create the sensor.'
            ], 500, $this->defaultConfig);
        }

        // log
        $this->entry->insert('logs', [
            'user_id' => $user['id'],
            'action' => 'create',
            'relation' => 'sensors',
            'relation_id' => $sensorId,
        ]);

        ResultHelper::render([
            'message' => 'Successfully created the sensor.'
        ], 200, $this->defaultConfig);
    }
}