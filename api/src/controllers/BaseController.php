<?php

namespace src\controllers;

use src\components\Entry;
use src\helpers\BaseHelper;
use src\helpers\ResultHelper;

/**
 * Default Controller
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class BaseController
{
    protected Entry $entry;
    protected array $params = [];
    protected int $userId = 0;
    protected array $defaultConfig = [
        'translate' => true
    ];

    /**
     * Constructor
     * @param array $params
     * @author Tim Zapfe
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->entry = new Entry();

        if (!empty($this->params['token'])) {
            $tokenInfo = $this->checkToken($this->params['token']);

            // set language from settings
            if (!empty($tokenInfo['user'])) {
                $GLOBALS['API_LANGUAGE'] = $tokenInfo['user']['language'] ?? 'en';
            }
        }
    }

    /**
     * This is the default index action.
     * @return void
     * @author Tim Zapfe
     */
    public function actionIndex(): void
    {
        // get all functions
        $allFunctions = get_class_methods($this);
        $functions = [];
        $url = BaseHelper::getUrl(true);

        // loop through all functions
        foreach ($allFunctions as $function) {
            // starts with action?
            if (str_starts_with($function, 'action') && $function != 'actionIndex') {
                $functionName = str_replace('action', '', $function);

                $functions[] = [
                    'function' => $functionName,
                    'link' => $url . strtolower($functionName) . (!empty($_SESSION['token']) ? '?token=' . $_SESSION['token'] : '')
                ];
            }
        }

        // no functions found?
        if (empty($functions)) {
            // get all files
            $allFiles = array_diff(scandir(__DIR__), ['.', '..']);
            $controllers = [];

            // loop through all files
            foreach ($allFiles as $file) {

                // is BaseController?
                if ($file == 'BaseController.php') {
                    continue;
                }

                // remove "Controller.php"
                $controllerName = str_replace('Controller.php', '', $file);
                $controllers[] = [
                    'controller' => $controllerName,
                    'link' => $url . strtolower($controllerName)
                ];
            }

            ResultHelper::render([
                'message' => 'This is the default action. Please provide a valid controller with a valid action. If you do not know any available actions, just call the controller and it will display all.',
                'controllers' => $controllers
            ]);
        }

        ResultHelper::render([
            'message' => 'You can call the following functions. Some functions may need an personal access token. You can get this by logging into your account. Once you are loggedin, we will add the token for you.',
            'functions' => $functions
        ]);
    }

    /**
     * Returns the value of a param with default variable
     * @param int $index
     * @param string|null $name
     * @param mixed|null $default
     * @param bool $mustBeName
     * @return mixed|null
     * @author Tim Zapfe
     */
    protected function getParam(int $index, string $name = null, mixed $default = null, bool $mustBeName = false): mixed
    {
        $param = $default;

        // check if index is set / and it can use the index
        if (isset($this->params[$index]) && !$mustBeName) {
            $param = $this->params[$index];
        }

        // check if is given by name and its set
        if (!empty($name) && isset($this->params[$name])) {
            $param = $this->params[$name];
        }

        // check if the param is given and not empty
        if (empty($param) && !is_bool($param) && !is_numeric($param)) {
            $param = $default;
        }

        return (is_bool($param)) ? $param : urldecode($param);
    }

    /**
     * Returns array with status if the token is valid or not. If valid, it also returns the userId in relation to the token.
     * @param string|null $token
     * @return array|false[]
     */
    protected function checkToken(string $token = null): array
    {
        // token not provided?
        if (empty($token)) {
            return ['status' => false];
        }

        // build query
        $entry = new Entry();
        $entry->columns(['api_tokens' => ['user_id', 'uses']])
            ->tables('api_tokens')
            ->where(['api_tokens' => [['token', $token], ['active', true]]]);

        // get info
        $info = $entry->one();

        // info empty?
        if (empty($info)) {
            return ['status' => false];
        }

        // update uses
        $entry->update('api_tokens', ['uses' => ($info['uses'] + 1)], ['token' => $token]);

        // get user info
        $user = $entry->columns(['users' => ['*'], 'user_settings' => ['language', 'imperial_system', 'darkmode']])
            ->tables(['users', ['user_settings', 'users.id', 'user_settings.user_id', 'LEFT']])
            ->where(['users' => [['id', $info['user_id']]]])
            ->one();

        // return true as token is valid
        return ['status' => true, 'user' => $user];
    }

    /**
     * Checks if a user is logged in with either user token or session.
     * Also returns the user id by token.
     * @return int|bool
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 16.10.2024
     */
    protected function requireUser(): int|bool
    {
        // get token only by named param
        $token = $this->getParam(999, 'token', null, true);

        // update token from session if exists.
        if (empty($token) && !empty($_SESSION['token'])) {
            $token = $_SESSION['token'];
        }

        // token not provided?
        if (empty($token)) {
            ResultHelper::render([
                'message' => 'Please provide your personal access token or log in.'
            ], 403, $this->defaultConfig);
        }

        // get the token info for the given token
        $tokenInfo = $this->checkToken($token);

        // status is false?
        if (!$tokenInfo['status']) {

            // return error
            ResultHelper::render([
                'message' => 'Your provided token seems to be wrong.'
            ], 400, $this->defaultConfig);
        }

        // set user id and return it
        return $this->userId = $tokenInfo['user']['id'];
    }
}