<?php

namespace src\controllers;

use ECSPrefix202206\Doctrine\Common\Annotations\Annotation\Required;
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

    /**
     * Creates a new sensor into the database.
     * Requires "name" as first param. Optionally "color" as second param.
     * @return void
     */
    public function actionCreate()
    {

    }

    /**
     * Updates a sensor.
     * Requires "id" as first param.
     * Optionally "color" as second param, "active" as third param.
     * @return void
     */
    public function actionUpdate()
    {

    }
}