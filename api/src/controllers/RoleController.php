<?php

namespace src\controllers;

use src\components\Entry;
use src\helpers\ResultHelper;
use src\helpers\UserHelper;

/**
 * @author Tim Zapfe
 */
class RoleController extends BaseController
{
    /**
     * Returns all roles
     * @return array|bool|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 17.10.2024
     */
    public function actionAll(): bool|array|string
    {
        $this->entry->reset();

        // get all roles
        return $this->entry->columns(['roles' => ['*']])->tables('roles')->where(['roles' => [['active', true]]])->all();
    }
}