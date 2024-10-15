<?php

namespace src\controllers;

use src\components\Entry;
use src\helpers\RecordHelper;
use src\helpers\ResultHelper;
use src\helpers\UserHelper;

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
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following information.',
                'params' => [
                    'username (index 0)' => 'The name of the user.',
                    'password (index 1)' => 'The password of the user.',
                ]
            ], 500, $this->defaultConfig);
        }

        $username = $this->getParam(0, 'username');
        $password = $this->getParam(1, 'password');

        // default config
        $config = ['translate' => true];

        // username given?
        if (empty($username)) {
            ResultHelper::render('Invalid username provided.', 500, $config);
        }

        // check if password is given
        if (empty($password)) {
            ResultHelper::render('Invalid password provided.', 500, $config);
        }

        // check if username exists
        $entry = new Entry();
        $usernameExists = $entry->columns(['users' => ['username', 'password']])
            ->tables('users')
            ->where(['users' => [['username', $username]]])
            ->exists();

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
        $user = $entry->columns(['users' => ['*']])
            ->tables(['users'])
            ->where(['users' => [['username', $username]]])
            ->one();

        // user active
        if (!$user['active']) {
            ResultHelper::render('Your account is not active.', 500, $config);
        }

        $user['password'] = $password;
        $user['token'] = UserHelper::getApiToken($user['id']);
        $_SESSION['token'] = $user['token'];

        // update last seen
        $entry->update('users', ['lastSeen' => RecordHelper::getDatesForToday()['now']], ['id' => $user['id']]);

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
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following information.',
                'params' => [
                    'username (index 0)' => 'The name of the user.',
                    'password (index 1)' => 'The password of the user.',
                    'passwordRepeat (index 2)' => 'The repeated password of the user.',
                ]
            ], 500, $this->defaultConfig);
        }

        // check if username param is given
        $username = $this->getParam(0, 'username');
        $password = $this->getParam(1, 'password');
        $passwordRepeat = $this->getParam(2, 'passwordRepeat');

        // default config
        $config = ['translate' => true];

        // check if username is given
        if (empty($username)) {
            ResultHelper::render('Invalid username provided.', 500, $config);
        }

        // check if password is given
        if (empty($password)) {
            ResultHelper::render('Invalid password provided.', 500, $config);
        }

        // check if passwordRepeat given
        if (empty($passwordRepeat)) {
            ResultHelper::render('Invalid repeated password provided.', 500, $config);
        }

        // check if username exists
        $entry = new Entry();
        $usernameExists = $entry->columns(['users' => ['username']])
            ->tables('users')
            ->where(['users' => [['username', $username]]])
            ->exists();

        // does username already exists?
        if ($usernameExists) {
            ResultHelper::render('Username already exists.', 500, $config);
        }

        // check if password and passwordRepeat not same
        if ($password !== $passwordRepeat) {
            ResultHelper::render('Passwords do not match.', 500, $config);
        }

        // insert user
        $userID = $entry->insert('users', [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'snowflake' => UserHelper::generateSnowflake($username)
        ]);

        if (!is_numeric($userID)) {
            ResultHelper::render('There was an error while creating your account.', 500, $config);
        }

        // fetch the user
        $user = $entry->columns(['users' => ['*']])
            ->tables(['users'])
            ->where(['users' => [['username', $username]]])
            ->one();

        $user['password'] = $password;
        $user['token'] = UserHelper::getApiToken($user['id']);
        $_SESSION['token'] = $user['token'];

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
    public function actionUpdate(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                    'username (optional)' => 'The new username of the user.',
                    'password (optional)' => 'The new password of the user.',
                ]
            ], 500, $this->defaultConfig);
        }

        // get user id
        $userID = $this->getUserID();

        // get updates
        $username = $this->getParam(1, 'username', null, true);
        $password = $this->getParam(2, 'password', null, true);

        $entry = new Entry();
        $updates = [];

        // username exists?
        if (!empty($username)) {

            // check if username exists
            $entry->columns(['users' => ['username']])->tables('users')->where(['users' => [['username', $username]]]);

            // username exists?
            if ($entry->exists()) {
                ResultHelper::render('Username already exists.', 500, $this->defaultConfig);
            }

            // update username
            $updates['username'] = $username;
        }

        // password exists?
        if (!empty($password)) {

            // add password
            $updates['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // no values given
        if (empty($updates)) {
            ResultHelper::render('Nothing to update.', 500, $this->defaultConfig);
        }

        // update user
        $updated = $entry->update('users', $updates, ['id' => $userID]);

        // was updated?
        if ($updated) {
            ResultHelper::render('Account updated successfully.', 200, $this->defaultConfig);
        }

        ResultHelper::render('Error while updating account.', 500, $this->defaultConfig);
    }

    /**
     * Returns the info about a user.
     * Requires "id" or "username" as first param
     * @return void
     * @author Tim Zapfe
     */
    public function actionInfo(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'id / username / snowflake (index 0)' => 'The ID/username/snowflake of the user.',
                ]
            ], 500, $this->defaultConfig);
        }

        $userID = $this->getParam(0, 'id');
        $username = $this->getParam(0, 'username');
        $snowflake = $this->getParam(0, 'snowflake');

        if (empty($userID) && empty($username)) {
            ResultHelper::render('Invalid user id or username provided.', 500, [
                'translate' => true
            ]);
        }

        $entry = new Entry();

        // fetch full user information
        $user = $entry->columns(['users' => ['*']])
            ->tables(['users'])
            ->where(['users' => [['username', $username], ['id', $userID], ['snowflake', $snowflake]]], 'OR')
            ->one();

        // user found?
        if (empty($user)) {
            ResultHelper::render('Could not find any user.', 500, [
                'translate' => true
            ]);
        }

        // unset password
        unset($user['password']);

        // return user
        ResultHelper::render($user);
    }

    /**
     * Loggs a user out. Either just the device with the token or all devices (all tokens)
     * @return void
     */
    public function actionLogout(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                    'all (index 0) (optional) (boolean)' => 'Whether you want to logout all devices or not.'
                ]
            ], 500, $this->defaultConfig);
        }

        // get user id
        $entry = new Entry();
        $userID = $this->getUserID();
        $allDevices = (bool)$this->getParam(0, 'all', false);
        $token = $this->getParam(0, 'token', null, true);

        if ($allDevices) {
            // logout all devices with the user id
            $success = $entry->update('api_tokens', ['active' => false], ['userID' => $userID]);
        } else {
            $success = $entry->update('api_tokens', ['active' => false], ['token' => $token]);
        }

        if (!$success) {
            ResultHelper::render('There was an error while logging you out.', 500, $this->defaultConfig);
        }

        $_SESSION['token'] = null;
        ResultHelper::render('Successfully logged out.', 200, $this->defaultConfig);
    }

    /**
     * Returns boolean whether a given token is still valid or not.
     * @return void
     */
    public function actionCheckToken(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                ]
            ], 500, $this->defaultConfig);
        }

        // get the token
        $token = $this->getParam(999, 'token', null, true);

        // get the token info
        $tokenInfo = $this->checkToken($token);

        // return true or false whether the token is valid or not.
        ResultHelper::render($tokenInfo['status']);
    }
}