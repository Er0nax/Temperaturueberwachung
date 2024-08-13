<?php

namespace src\controllers;

use src\components\Entry;
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
        $username = $this->getParam(0, 'username');
        $password = $this->getParam(1, 'password');

        // default config
        $config = ['translate' => true];

        // username given?
        if (empty($username)) {
            ResultHelper::render('Invalid "username" (first param) given.', 500, $config);
        }

        // check if password is given
        if (empty($password)) {
            ResultHelper::render('Invalid "password" (second param) given.', 500, $config);
        }

        // check if username exists
        $entry = new Entry();
        $usernameExists = $entry->columns(['users' => ['username', 'password']])->tables('users')->where(['users' => [['username', $username]]])->exists();

        // does username already exists?
        if (!$usernameExists) {
            ResultHelper::render('Username not found.', 500, $config);
        }

        // fetch password
        $userInfo = $entry->one();

        // verify password
        $passwordCorrect = password_verify($password, $userInfo['password']);

        // password not correct?
        if (!$passwordCorrect) {
            ResultHelper::render('Your password is not correct.', 500, $config);
        }

        // fetch full user information
        $user = $entry->columns(['users' => ['*'], 'images' => ["src AS 'avatar'"], 'roles' => ["name AS 'role_name'", "color AS 'role_color'"]])
            ->tables(['users', ['images', 'images.id', 'users.avatar_id'], ['roles', 'roles.id', 'users.role_id']])
            ->where(['users' => [['username', $username]]])
            ->one();

        // return user
        ResultHelper::render([
            'msg' => ResultHelper::t('Welcome back, {username}', ['username' => $userInfo['username']]),
            'info' => $user
        ]);
    }

    /**
     * Creates a new user.
     * Requires "username" as first, "password" as second and "repeatedPassword" as third param.
     * Returns new user id on success.
     * @return void
     * @author Tim Zapfe
     */
    public function actionRegister(): void
    {
        // check if username param is given
        $username = $this->getParam(0, 'username');
        $password = $this->getParam(1, 'password');
        $passwordRepeat = $this->getParam(2, 'passwordRepeat');

        // default config
        $config = ['translate' => true];

        // check if username is given
        if (empty($username)) {
            ResultHelper::render('Invalid "username" (first param) given.', 500, $config);
        }

        // check if password is given
        if (empty($password)) {
            ResultHelper::render('Invalid "password" (second param) given.', 500, $config);
        }

        // check if passwordRepeat given
        if (empty($passwordRepeat)) {
            ResultHelper::render('Invalid "passwordRepeat" (third param) given.', 500, $config);
        }

        // check if username exists
        $entry = new Entry();
        $usernameExists = $entry->columns(['users' => ['username']])->tables('users')->where(['users' => [['username', $username]]])->exists();

        // does username already exists?
        if ($usernameExists) {
            ResultHelper::render('Username already exists.', 500, $config);
        }

        // check if password and passwordRepeat not same
        if ($password !== $passwordRepeat) {
            ResultHelper::render('Passwords do not match.', 500, $config);
        }

        // insert new avatar
        $avatarID = $entry->insert('images', ['src' => 'default.png'], false);

        // check if avatar id is given
        if (!is_numeric($avatarID)) {
            ResultHelper::render('There was an error while create a new avatar.', 500, $config);
        }

        // insert user
        $userID = $entry->insert('users', [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'avatar_id' => $avatarID,
        ]);

        if (!is_numeric($userID)) {
            ResultHelper::render('There was an error while creating a new user', 500, $config);
        }

        // fetch the user
        $user = $entry->columns(['users' => ['*'], 'images' => ["src AS 'avatar'"], 'roles' => ["name AS 'role_name'", "color AS 'role_color'"]])
            ->tables(['users', ['images', 'images.id', 'users.avatar_id'], ['roles', 'roles.id', 'users.role_id']])
            ->where(['users' => [['username', $username]]])
            ->one();

        ResultHelper::render([
            'msg' => 'Account created successfully.',
            'info' => $user
        ], 200, $config);
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