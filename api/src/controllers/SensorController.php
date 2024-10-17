<?php

namespace src\controllers;

use src\components\Entry;

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

        return $this->entry->columns(['sensors' => ['*']])
            ->tables('sensors')
            ->where(['sensors' => [['active', true]]])
            ->all();
    }
}