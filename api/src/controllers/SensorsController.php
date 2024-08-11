<?php

namespace src\controllers;

use src\components\Entry;
use src\controllers\BaseController;
use src\helpers\ResultHelper;

class SensorsController extends BaseController
{
    public function actionAll(): bool|array|string
    {
        $entry = new Entry();

        $entry->columns(['sensors' => ['*']])
            ->tables('sensors');

        $sensors = $entry->all();

        ResultHelper::render($sensors);
    }
}