<?php

namespace src\controllers;

use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 */
class UserController extends BaseController
{
    public function actionLogin(): void
    {
        ResultHelper::render(constant('URL_PARTS'));
    }
}