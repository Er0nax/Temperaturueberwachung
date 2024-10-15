<?php

namespace src\controllers;

use src\components\Entry;
use src\helpers\BaseHelper;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * Default Controller
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class BaseController
{
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
                'info' => ResultHelper::t('This is the default action. Please provide a valid controller with a valid action. If you do not know any available actions, just call the controller and it will display all.'),
                'controllers' => $controllers
            ]);
        }

        ResultHelper::render([
            'info' => ResultHelper::t('You can call the following functions. Some functions may need an personal access token. You can get this by logging into your account. Once you are loggedin, we will add the token for you.'),
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

        // check if index is given / and it can use the index
        if (isset($this->params[$index]) && !$mustBeName) {
            $param = $this->params[$index];
        }

        // check if is given by name
        if (!empty($name) && isset($this->params[$name])) {
            $param = $this->params[$name];
        }

        return (is_bool($param)) ? $param : urldecode($param);
    }

    /**
     * Sets response on error and returns user id on success
     * @return int|bool
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    protected function getUserId(): int|bool
    {
        // get token only by named param
        $token = $this->getParam(999, 'token', null, true);

        // token not provided?
        if (empty($token)) {
            ResultHelper::render('Please provide your personal access token.', 500, $this->defaultConfig);
        }

        // get the token info for the given token
        $tokenInfo = $this->checkToken($token);

        // status is false?
        if (!$tokenInfo['status']) {

            // return error
            ResultHelper::render('The provided token seems to be wrong.', 500, $this->defaultConfig);
        }

        // set user id and return it
        return $this->userId = $tokenInfo['userId'];
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

        // return true as token is valid
        return ['status' => true, 'userId' => $info['user_id']];
    }
}