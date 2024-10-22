<?php

namespace src\controllers;

use Random\RandomException;
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
        $temperaturesLimit = 10;

        // get all sensors
        $sensors = $this->getSensorQuery()->all();

        // add last meassured temperatures
        foreach ($sensors as &$sensor) {

            // build temperature query
            $this->entry->reset();
            $query = $this->entry->columns(['temperatures' => ['id', 'temperature', 'updated_at', 'created_at']])
                ->tables('temperatures')
                ->where(['temperatures' => [['active', true], ['sensor_id', $sensor['id']]]])
                ->limit($temperaturesLimit)
                ->order('temperatures.created_at DESC');

            // get last temperature row
            $lastTemperature = $query->one();

            // does it exist?
            if (!empty($lastTemperature)) {
                $currentTemperature = $query->one();

                if ($currentTemperature) {
                    // add current temperature
                    $sensor['currentTemperature'] = $currentTemperature['temperature'] ?? 0;
                }
            }

            // add latest temperatures
            $sensor['temperatures'] = $query->all();
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
}