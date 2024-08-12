<?php

namespace src\controllers;

use src\components\Entry;
use src\controllers\BaseController;
use src\helpers\ResultHelper;

/**
 * Sensor Controller
 * @author Tim Zapfe
 */
class SensorsController extends BaseController
{
    /**
     * Returns all active Sensors
     * @return void
     * @author Tim Zapfe
     */
    public function actionAll(): void
    {
        $entry = new Entry();

        $entry->columns(['sensors' => ['*']])
            ->tables('sensors')
            ->where(['sensors' => [['active', true]]]);

        $sensors = $entry->all();

        ResultHelper::render($sensors);
    }
}