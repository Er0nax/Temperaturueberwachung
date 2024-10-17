<?php

namespace src\controllers;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 17.10.2024
 */
class SensorController extends BaseController
{
    /**
     * Returns all sensors.
     * @return array|bool|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 17.10.2024
     */
    public function actionAll(): bool|array|string
    {
        $this->entry->reset();
        $temperaturesLimit = 10;

        // get all sensors
        $sensors = $this->entry->columns([
                'sensors' => ['id', 'maxTemp', 'minTemp', 'name', 'address', 'color', 'created_at', 'updated_at'],
                'manufacturers' => ["name AS 'manufacturer'"]]
        )->tables([
            'sensors',
            ['manufacturers', 'sensors.manufacturer_id', 'manufacturers.id']
        ])->where([
            'sensors' => [['active', true]],
            'manufacturers' => [['active', 'true']]
        ])->all();

        // add last meassured temperatures
        foreach ($sensors as &$sensor) {

            // build temperature query
            $query = $this->entry->columns(['temperatures' => ['id', 'temperature', 'updated_at', 'created_at']])
                ->tables('temperatures')
                ->where(['temperatures' => [['active', true], ['sensor_id', $sensor['id']]]])
                ->limit($temperaturesLimit)
                ->order('temperatures.created_at DESC');

            // get last temperature row
            $lastTemperature = $query->one();

            // does it exist?
            if (!empty($lastTemperature)) {
                // add current temperature
                $sensor['currentTemperature'] = $query->one()['temperature'];
            }

            // add latest temperatures
            $sensor['temperatures'] = $query->all();
        }

        // return all sensors
        return $sensors;
    }
}