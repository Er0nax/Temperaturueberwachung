<?php

namespace src\controllers;

use Random\RandomException;
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

        // user active
        if (!$user['active']) {
            ResultHelper::render('Your account is not active.', 500, $config);
        }

        $user['password'] = $password;
        $user['token'] = $this->getApiToken($user['id']);

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

        $user['password'] = $password;
        $user['token'] = $this->getApiToken($user['id']);

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
        // get username and password
        $userID = $this->getParam(0, 'id');

        // get token
        $token = $this->getParam(0, 'token', null, true);

        $config = [
            'translate' => true
        ];

        // check if user id given
        if (!is_numeric($userID) || !isset($userID)) {
            ResultHelper::render('Invalid user id given.', 500, $config);
        }

        // check if token is given
        if (empty($token)) {
            ResultHelper::render('No token provided!', 500);
        }

        // get user token
        $userToken = $this->getApiToken($userID);

        // check if provided token is same as user token
        if ($userToken !== $token) {
            ResultHelper::render('Invalid token provided!', 500, $config);
        }

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
                ResultHelper::render('Username already exists.', 500, $config);
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
            ResultHelper::render('Nothing to update.', 500, $config);
        }

        // update user
        $updated = $entry->update('users', $updates, ['id' => $userID]);

        // was updated?
        if ($updated) {
            ResultHelper::render('Account updated successfully.', 200, $config);
        }

        ResultHelper::render('Error while updating account.', 500, $config);
    }

    /**
     * Returns the info about a user.
     * Requires "id" or "username" as first param
     * @return void
     * @author Tim Zapfe
     */
    public function actionInfo(): void
    {
        $userID = $this->getParam(0, 'id');
        $username = $this->getParam(0, 'username');

        if (empty($userID) && empty($username)) {
            ResultHelper::render('Invalid "id" or "username" (first param) given.', 500, [
                'translate' => true
            ]);
        }

        $entry = new Entry();

        // fetch full user information
        $user = $entry->columns(['users' => ['*'], 'images' => ["src AS 'avatar'"], 'roles' => ["name AS 'role_name'", "color AS 'role_color'"]])
            ->tables(['users', ['images', 'images.id', 'users.avatar_id'], ['roles', 'roles.id', 'users.role_id']])
            ->where(['users' => [['username', $username], ['id', $userID]]], 'OR')
            ->one();

        // user found?
        if (empty($user)) {
            ResultHelper::render('Could not find user.', 500, [
                'translate' => true
            ]);
        }

        // return user
        ResultHelper::render($user);
    }

    /**
     * Returns the API token for a user
     */
    private function getApiToken(string|int $userID): string
    {
        $entry = new Entry();

        // check if token with user id exists
        $entry->columns(['api_tokens' => ['*']])
            ->tables('api_tokens')
            ->where(['api_tokens' => [
                ['active', true],
                ['user_id', $userID]
            ]]);

        $tokenExists = $entry->exists();

        // does exist?
        if ($tokenExists) {
            $info = $entry->one();

            return $info['token'];
        }

        $token = $this->generateApiToken();
        $ip = $_SERVER['REMOTE_ADDR'];

        // create new token
        $entry->insert('api_tokens', [
            'user_id' => $userID,
            'ip' => $ip,
            'token' => $token
        ], false);

        return $token;
    }

    /**
     * Returns a new random Api Token
     * @author Tim Zapfe
     */
    private function generateApiToken(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = [];

        for ($i = 0; $i < 20; $i++) {
            $randomIndex = mt_rand(0, $charactersLength - 1);
            $randomString[] = $characters[$randomIndex];
        }

        return implode('', $randomString);
    }
}