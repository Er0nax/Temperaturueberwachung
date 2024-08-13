<?php

namespace src\controllers;

use Random\RandomException;
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
    public function actionInsert(): void
    {
        $sensor_id = null;
        $temperature = null;

        // check if first param is given
        if (isset($this->params[0])) {
            $sensor_id = $this->params[0];
        }

        // check if sensor_id is given by name
        if (isset($this->params['sensor_id'])) {
            $sensor_id = $this->params['sensor_id'];
        }

        // check if second param is given
        if (isset($this->params[1])) {
            $temperature = (float)$this->params[1];
        }

        // check if temperature is given by name
        if (isset($this->params['temperature'])) {
            $temperature = (float)$this->params['temperature'];
        }

        // sensor id and temperature given?
        if (!is_numeric($sensor_id)) {
            ResultHelper::render('Invalid sensor_id (first param) provided.', 400, [
                'translate' => true
            ]);
        }

        // temperature given?
        if (!is_float($temperature)) {
            ResultHelper::render('Invalid temperature (second param) provided.', 400, [
                'translate' => true
            ]);
        }

        $entry = new Entry();

        // get all sensors
        $sensorExists = $entry->columns(['sensors' => ['*']])
            ->tables('sensors')
            ->where(['sensors' => [['id', $sensor_id], ['active', true]]])
            ->exists();

        // check if sensor_id is given
        if (!$sensorExists) {
            ResultHelper::render('Your provided sensor id is invalid!', 400, [
                'translate' => true
            ]);
        }

        // insert
        $result = $entry->insert('temperatures', ['sensor_id' => $sensor_id, 'temperature' => $temperature], false);

        if (is_numeric($result)) {
            ResultHelper::render('Temperature inserted.', 200, [
                'translate' => true
            ]);
        }

        ResultHelper::render('Could not insert temperature.', 500, [
            'translate' => true
        ]);
    }

    /**
     * Insert test rows for temperatures
     * @throws RandomException
     * @author Tim Zapfe
     */
    public function actionInsertTest(): void
    {
        // get how many tries should be done
        $inserts = $this->params[0] ?? 100;

        $entry = new Entry();

        // get all sensors
        $sensors = $entry->columns(['sensors' => ['*']])->tables('sensors')->where(['sensors' => [['active', true]]])->all();

        $sensorIDs = [];
        foreach ($sensors as $sensor) {
            $sensorIDs[] = $sensor['id'];
        }

        $insertedIDs = [];

        // loop through all tries
        for ($i = 0; $i < $inserts; $i++) {
            $sensor_id = $sensorIDs[random_int(0, count($sensorIDs) - 1)];
            $temperature = rand(100, 300) / 10;

            $insertedIDs[] = $entry->insert('temperatures', ['sensor_id' => $sensor_id, 'temperature' => $temperature], false);
        }

        ResultHelper::render($insertedIDs);
    }
}