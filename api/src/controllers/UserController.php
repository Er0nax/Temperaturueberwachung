<?php

namespace src\controllers;

use src\components\Entry;
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
                'message' => 'This function requires some parameters.',
                'params' => [
                    'username' => 'The name of the user.',
                    'password' => 'The password of the user.',
                ]
            ], 406, $this->defaultConfig);
        }

        $username = $this->getParam(0, 'username');
        $password = $this->getParam(1, 'password');

        // username given?
        if (empty($username)) {
            ResultHelper::render([
                'message' => 'Invalid username provided.'
            ], 400, $this->defaultConfig);
        }

        // check if password is given
        if (empty($password)) {
            ResultHelper::render([
                'message' => 'Invalid password provided.'
            ], 400, $this->defaultConfig);
        }

        // check if username is valid
        if (!UserHelper::isValidUsername($username)) {
            ResultHelper::render([
                'message' => 'This username is not valid! You can not use any banned words or special chars.'
            ], 400, $this->defaultConfig);
        }

        // check if username exists
        $entry = new Entry();
        $usernameExists = $entry->columns(['users' => ['username', 'password']])
            ->tables('users')
            ->where(['users' => [['username', $username]]])
            ->exists();

        // does username already exists?
        if (!$usernameExists) {
            ResultHelper::render([
                'message' => 'Username not found.'
            ], 404, $this->defaultConfig);
        }

        // fetch password
        $userInfo = $entry->one();

        // verify password
        $passwordCorrect = password_verify($password, $userInfo['password']);

        // password not correct?
        if (!$passwordCorrect) {
            ResultHelper::render([
                'message' => 'Your password is not correct.'
            ], 400, $this->defaultConfig);
        }

        // fetch full user information
        $user = UserHelper::getUserQuery()->where(['users' => [['username', $username]]])->one();

        // user found?
        if (empty($user)) {
            ResultHelper::render([
                'message' => 'Could not find your user information.'
            ], 404, $this->defaultConfig);
        }

        // user active
        if (!$user['active']) {
            ResultHelper::render([
                'message' => 'Your account is not active.'
            ], 200, $this->defaultConfig);
        }

        // set password and token
        $user['password'] = $password;
        $user['token'] = UserHelper::getApiToken($user['id']);
        $_SESSION['token'] = $user['token'];

        // update last seen
        $entry->update('users', ['last_seen' => date('Y-m-d H:i:s')], ['id' => $user['id']]);

        // log
        $this->entry->insert('logs', [
            'user_id' => $user['id'],
            'action' => 'login',
            'relation' => 'users',
            'relation_id' => $user['id']
        ], false);

        // return user
        ResultHelper::render([
            'message' => ResultHelper::t('Welcome back, {username}', ['username' => $userInfo['username']]),
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
                'message' => 'This function requires some parameters.',
                'params' => [
                    'username (index 0)' => 'The name of the user.',
                    'password (index 1)' => 'The password of the user.',
                    'passwordRepeat (index 2)' => 'The repeated password of the user.',
                ]
            ], 406, $this->defaultConfig);
        }

        // check if username param is given
        $username = $this->getParam(0, 'username');
        $password = $this->getParam(1, 'password');
        $passwordRepeat = $this->getParam(2, 'passwordRepeat');

        // check if username is given
        if (empty($username)) {
            ResultHelper::render([
                'message' => 'Invalid username provided.'
            ], 400, $this->defaultConfig);
        }

        // check if password is given
        if (empty($password)) {
            ResultHelper::render([
                'message' => 'Invalid password provided.'
            ], 400, $this->defaultConfig);
        }

        // check if passwordRepeat given
        if (empty($passwordRepeat)) {
            ResultHelper::render([
                'message' => 'Invalid repeated password provided.'
            ], 400, $this->defaultConfig);
        }

        // check if username is valid
        if (!UserHelper::isValidUsername($username)) {
            ResultHelper::render([
                'message' => 'This username is not valid! You can not use any banned words or special chars.'
            ], 400, $this->defaultConfig);
        }

        // check if username already exist
        if (UserHelper::checkIfUsernameExists($username)) {
            ResultHelper::render([
                'message' => 'Username already exists.'
            ], 400, $this->defaultConfig);
        }

        // check if password and passwordRepeat not same
        if ($password !== $passwordRepeat) {
            ResultHelper::render([
                'message' => 'Passwords do not match.'
            ], 400, $this->defaultConfig);
        }

        // insert avatar
        $avatarId = $this->entry->insert('images', ['src' => 'default.png'], false);

        // insert user
        $userId = $this->entry->insert('users', [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'snowflake' => UserHelper::generateSnowflake($username),
            'avatar_id' => $avatarId
        ]);

        // user is number? yes => success
        if (!is_numeric($userId)) {
            ResultHelper::render([
                'message' => 'There was an error while creating your account.'
            ], 500, $this->defaultConfig);
        }

        // insert user_settings
        $this->entry->insert('user_settings', ['user_id' => $userId]);

        // fetch the user
        $user = UserHelper::getUserQuery()->where(['users' => [['username', $username]]])->one();

        // set password and token
        $user['password'] = $password;
        $user['token'] = UserHelper::getApiToken($user['id']);
        $_SESSION['token'] = $user['token'];

        $this->entry->insert('logs', [
            'user_id' => $user['id'],
            'action' => 'register',
            'relation' => 'users',
            'relation_id' => $user['id']
        ]);

        ResultHelper::render([
            'message' => 'Account created successfully.',
            'info' => $user
        ], 200, $this->defaultConfig);
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
        $currentUser = $this->requireUser();

        if (empty($this->params)) {
            ResultHelper::render([
                'message' => 'This function requires some parameters.',
                'params' => [
                    'token' => 'Your personal access token.',
                    'username (optional)' => 'The new username of the user.',
                    'password (optional)' => 'The new password of the user.',
                ]
            ], 406, $this->defaultConfig);
        }

        // get updates
        $username = $this->getParam(1, 'username', null, true);
        $password = $this->getParam(2, 'password', null, true);
        $snowflake = $this->getParam(2, 'snowflake', null, true);
        $phone = $this->getParam(2, 'phone', null, true);
        $active = $this->getParam(2, 'active', null, true);

        $entry = new Entry();
        $updates = [];

        // get current user values
        $user = $entry->columns(['users' => ['username', 'snowflake', 'phone', 'password', 'active']])->tables('users')->where(['users' => [['id', $currentUser['id']]]])->one();

        // user found?
        if (empty($user)) {
            ResultHelper::render([
                'message' => 'Could not find a user to update.'
            ], 404, $this->defaultConfig);
        }

        // username exists?
        if (!empty($username) && $username !== $user['username']) {

            // check if username is valid
            if (!UserHelper::isValidUsername($username)) {
                ResultHelper::render([
                    'message' => 'This username is not valid! You can not use any banned words or special chars.'
                ], 400, $this->defaultConfig);
            }

            // check if username already exist
            if (UserHelper::checkIfUsernameExists($username)) {
                ResultHelper::render([
                    'message' => 'Username already exists.'
                ], 400, $this->defaultConfig);
            }
        }

        // password exists?
        if (!empty($password)) {

            // add password
            $updates['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // new snowflake?
        if (!empty($snowflake)) {

            // check if username exists
            $entry->columns(['users' => ['snowflake']])->tables('users')->where(['users' => [['snowflake', $snowflake]]]);

            // username exists?
            if ($entry->exists()) {
                ResultHelper::render([
                    'message' => 'Snowflake already exists.'
                ], 400, $this->defaultConfig);
            }

            // update username
            $updates['snowflake'] = $snowflake;
        }

        // new phone?
        if (!empty($phone)) {
            if ($user['phone'] !== $phone)
                $updates['phone'] = $phone;
        }

        // new active status?
        if (is_bool($active)) {
            if ($user['active'] !== $active)
                $updates['active'] = $active;
        }

        // no values given
        if (empty($updates)) {
            ResultHelper::render([
                'message' => 'Nothing to update.'
            ], 400, $this->defaultConfig);
        }

        // update user
        $updated = $entry->update('users', $updates, ['id' => $currentUser['id']]);

        // was updated?
        if (!$updated) {
            ResultHelper::render([
                'message' => 'Error while updating account.'
            ], 500, $this->defaultConfig);
        }

        // insert into logs
        foreach ($updates as $column => $value) {
            $this->entry->insert('logs', [
                'user_id' => $currentUser['id'],
                'action' => 'update',
                'relation' => 'users',
                'relation_id' => $currentUser['id'],
                'old_value' => $user[$column],
                'new_value' => $value,
                'column_name' => $column
            ], false, true);
        }

        ResultHelper::render([
            'message' => 'Account updated successfully.'
        ], 200, $this->defaultConfig);
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
                'message' => 'This function requires some parameters.',
                'params' => [
                    'id / username / snowflake (index 0)' => 'The ID/username/snowflake of the user.',
                ]
            ], 406, $this->defaultConfig);
        }

        $userId = $this->getParam(0, 'id');
        $username = $this->getParam(0, 'username');
        $snowflake = $this->getParam(0, 'snowflake');

        if (empty($userId) && empty($username)) {
            ResultHelper::render([
                'message' => 'Invalid user id or username provided.'
            ], 400, $this->defaultConfig);
        }

        $entry = new Entry();

        // fetch full user information
        $user = UserHelper::getUserQuery()
            ->where(['users' => [['username', $username], ['id', $userId], ['snowflake', $snowflake]]], 'OR')
            ->one();

        // user found?
        if (empty($user)) {
            ResultHelper::render([
                'message' => 'Could not find any user.'
            ], 404, $this->defaultConfig);
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
                'message' => 'This function requires some parameters.',
                'params' => [
                    'token' => 'Your personal access token.',
                    'all (index 0) (optional) (boolean)' => 'Whether you want to logout all devices or not.'
                ]
            ], 406, $this->defaultConfig);
        }

        // get user id
        $entry = new Entry();
        $user = $this->requireUser();
        $allDevices = (bool)$this->getParam(0, 'all', false);
        $token = $this->getParam(0, 'token', null, true);

        if ($allDevices) {
            // logout all devices with the user id
            $success = $entry->update('api_tokens', ['active' => false], ['userId' => $user['id']]);
        } else {
            $success = $entry->update('api_tokens', ['active' => false], ['token' => $token]);
        }

        if (!$success) {
            ResultHelper::render([
                'message' => 'There was an error while logging you out.'
            ], 500, $this->defaultConfig);
        }

        $_SESSION['token'] = null;
        ResultHelper::render([
            'message' => 'Successfully logged out.'
        ], 200, $this->defaultConfig);
    }

    /**
     * Returns boolean whether a given token is still valid or not.
     * @return void
     */
    public function actionCheckToken(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'message' => 'This function requires some parameters.',
                'params' => [
                    'token' => 'Your personal access token.',
                ]
            ], 406, $this->defaultConfig);
        }

        // get the token
        $token = $this->getParam(999, 'token', null, true);

        // get the token info
        $tokenInfo = $this->checkToken($token);

        // return true or false whether the token is valid or not.
        ResultHelper::render($tokenInfo['status']);
    }

    /**
     * Returns all users with their avatar and role
     * @return array|bool|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 17.10.2024
     */
    public function actionAll(): bool|array|string
    {
        $this->entry->reset();

        // get all users
        return UserHelper::getUserQuery()->where(['users' => [['active', true]]])->order('users.id ASC')->all();
    }

    public function actionUpdateAsAdmin()
    {
        $currentUser = $this->requireUser();
        $this->requireRole('Admin');

        //  get the user id
        $userId = $this->getParam(0, 'id');

        // user id given?
        if (empty($userId)) {
            ResultHelper::render([
                'message' => 'Could not find user to update.'
            ], 404, $this->defaultConfig);
        }

        // get user
        $userToUpdate = $this->entry->columns(['users' => ['username', 'snowflake', 'role_id', 'avatar_id', 'active', 'phone']])
            ->tables('users')
            ->where(['users' => [['id', $userId]]])
            ->one();

        if (empty($userToUpdate)) {
            ResultHelper::render([
                'message' => 'Could not find any user.'
            ], 404, $this->defaultConfig);
        }

        // get update values
        $username = $this->getParam(1, 'username');
        $snowflake = $this->getParam(2, 'snowflake');
        $active = $this->getParam(3, 'active');
        $role_id = $this->getParam(4, 'role_id');
        $avatar_id = $this->getParam(5, 'avatar_id');
        $phone = $this->getParam(6, 'phone');

        $updates = [];

        // update username?
        if (!empty($username) && $username !== $userToUpdate['username']) {

            // check if username is valid
            if (!UserHelper::isValidUsername($username)) {
                ResultHelper::render([
                    'message' => 'This username is not valid! You can not use any banned words or special chars.'
                ], 400, $this->defaultConfig);
            }

            // check if username already exist
            if (UserHelper::checkIfUsernameExists($username)) {
                ResultHelper::render([
                    'message' => 'Username already exists.'
                ], 400, $this->defaultConfig);
            }

            $updates['username'] = $username;
        }

        ResultHelper::render($updates);
    }
}