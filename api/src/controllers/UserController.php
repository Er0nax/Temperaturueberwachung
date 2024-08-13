<?php

namespace src\controllers;

use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 */
class UserController extends BaseController
{
    /**
     * Gets two inputs (username, password) and returns user id when success or error with message
     * @return void
     * @author Tim Zapfe
     */
    public function actionLogin(): void
    {
        ResultHelper::render($this->params);
    }

    /**
     * Creates a new user.
     * Requires "username" as first, "password" as second and "repeatedPassword" as third param.
     * Returns new user id on success.
     * @return void
     * @author Tim Zapfe
     */
    public function actionRegister()
    {

    }

    /**
     * Updates a user.
     * Requires "id" as first param.
     * Optionally "username" as second param, "role_id" as third param (only for admins)
     * @return void
     * @author Tim Zapfe
     */
    public function actionUpdate()
    {

    }

    /**
     * Returns the info about a user.
     * Requires "id" or "username" as first param
     * @return void
     * @author Tim Zapfe
     */
    public function actionInfo()
    {

    }
}