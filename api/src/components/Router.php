<?php

namespace src\components;

use src\Config;
use src\helpers\BaseHelper;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class Router extends BaseComponent
{
    private array $urlParts = [
        'lang' => 'de',
        'controller' => 'BaseController',
        'action' => 'actionIndex',
        'params' => []
    ];

    /**
     * Constructor
     * @author Tim Zapfe
     */
    public function __construct()
    {
        // set default language
        $this->urlParts['lang'] = $GLOBALS['API_LANGUAGE'];

        // get url parts
        $this->setUrlParts();

        // define globals
        define('URL_PARTS', $this->urlParts);
        $GLOBALS['API_LANGUAGE'] = $this->urlParts['lang'];

        // check controller and methods
        $this->checkController();

        // create new class
        $className = "\\src\\controllers\\" . $this->urlParts['controller'];
        $classObject = new $className($this->urlParts['params']);

        // check if action exists
        $this->checkAction($classObject);

        // call action
        $actionName = $this->urlParts['action'];
        $classObject->$actionName();

        // usually the action should have returned something so this code should not be reached.
        ResultHelper::render([
            'message' => 'Seems like nothing was returned.'
        ], 500, [
            'translate' => true
        ]);
    }

    /**
     * Checks if the controller exists. If not => display error
     * @return void
     * @author Tim Zapfe
     */
    private function checkController(): void
    {
        // check if file exists
        if (!FileHelper::exist('src/controllers/' . $this->urlParts['controller'] . '.php')) {
            ResultHelper::render([
                'message' => 'Controller not found.'
            ], 500, ['translate' => true]);
        }
    }

    /**
     * Checks if an action exists inside the controller. If not => display error
     * @param object $classObject
     * @return void
     * @author Tim Zapfe
     */
    private function checkAction(object $classObject): void
    {
        if (!method_exists($classObject, $this->urlParts['action'])) {
            ResultHelper::render([
                'message' => 'Action not found.'
            ], 500, ['translate' => true]);
        }
    }

    /**
     * get every important url part
     * @return void
     * @author Tim Zapfe
     */
    private function setUrlParts(): void
    {
        // get base url
        $baseUrl = BaseHelper::getUrl() . getenv('API_BASE_URL');
        $fullUrl = BaseHelper::getUrl(true);

        // remove base url from full url
        $partsAsString = str_replace($baseUrl, '', $fullUrl);

        // no parts found?
        if (empty($partsAsString)) {

            // return default
            return;
        }

        // remove everything after ?
        $queryParts = explode('?', $partsAsString);

        // to array
        $parts = explode('/', $queryParts[0]);

        // check if first key is given
        if (empty($parts[0])) {
            return;
        }

        // check if is valid language
        if (in_array($parts[0], Config::getConfig('langs', []))) {
            // set lang
            $this->urlParts['lang'] = $parts[0];

            // remove first key
            array_shift($parts);
        }

        // another key exist?
        if (empty($parts[0])) {
            return;
        }

        // next key is controller
        $this->urlParts['controller'] = ucfirst($parts[0]) . 'Controller';
        array_shift($parts);

        // does another key exist?
        if (empty($parts)) {
            return;
        }

        // set next key as action
        $this->urlParts['action'] = $this->createMethodName($parts[0]);
        array_shift($parts);

        // parts empty?
        if (empty($parts) && empty($_GET) && empty($_POST) && empty($_FILES)) {
            return;
        }

        // set additional parts as params
        $this->urlParts['params'] = $this->getParams($parts);
    }

    /**
     * Returns the right method name
     * @param string $string
     * @return string
     * @author Tim Zapfe
     */
    private function createMethodName(string $string): string
    {
        if (empty($string)) {
            return $this->urlParts['action'];
        }

        // Erster Teil: 'action' hinzufügen
        $output = 'action';

        // Zweiter Teil: Teile des Strings nach dem Bindestrich groß schreiben
        $parts = explode('-', $string);
        foreach ($parts as $part) {
            $output .= ucfirst($part);
        }

        return $output;
    }

    /**
     * Return all params with post, get and files
     * @param array $parts
     * @return array
     * @author Tim Zapfe
     */
    private function getParams(array $parts): array
    {
        // add post requests
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $parts[$key] = $value;
            }
        }

        // add get requests
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $parts[$key] = $value;
            }
        }

        // add files
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $value) {
                $parts['files'][$key] = $value;
            }
        }

        return $parts;
    }
}