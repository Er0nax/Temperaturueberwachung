<?php

namespace src\controllers;

use src\components\Entry;
use src\controllers\BaseController;
use src\helpers\ResultHelper;

/**
 * Temperatur Controller
 * @author Tim Zapfe
 */
class TemperaturesController extends BaseController
{
    /**
     * Returns all Temperatures
     * @return void
     * @author Tim Zapfe
     */
    public function actionAll(): void
    {
        $entry = new Entry();

        $entry->columns(['temperatures' => ['*']])
            ->tables('temperatures')
            ->where(['temperatures' => [['active', true]]]);

        $sensors = $entry->all();

        ResultHelper::render($sensors);
    }

    /**
     * Returns the latest temperatures for each sensor
     * @return void
     * @author Tim Zapfe
     */
    public function actionLatest(): void
    {
        $entry = new Entry();

        // build entry
        $entry->columns(['temperatures' => ['*']])
            ->tables(['sensors', ['temperatures', 'sensors.id', 'temperatures.sensor_id']])
            ->where(['temperatures' => [['active', true]], 'sensors' => [['active', true]]])
            ->order('temperatures.created_at DESC, temperatures.sensor_id DESC')
            ->limit(100);

        // get all temps
        $temps = $entry->all();

        $latestTemps = [];

        // loop through all temps
        foreach ($temps as $temp) {

            $sensor_id = $temp['sensor_id'];

            // does exist?
            if (empty($latestTemps[$sensor_id])) {
                // add temperatur
                $latestTemps[$sensor_id] = $temp;
            }
        }

        // return content as json
        ResultHelper::render($latestTemps);
    }

    /**
     * Inserts a new temperature value into the database.
     * Requires sensor_id as first param and temperature (as °C) as second param.
     * @return void
     */
    public function actionCreateTemperature()
    {

    }
}