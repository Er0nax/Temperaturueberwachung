<?php

namespace src\components;

use src\Config;
use src\helpers\CacheHelper;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
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
        // get url parts
        $this->setUrlParts();

        // define global
        define('URL_PARTS', $this->urlParts);

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
            ResultHelper::render('Controller not found.', 400);
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
            ResultHelper::render('Action not found.', 400);
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
        $baseUrl = getenv('API_BASE_URL');
        $fullUrl = $this->getFullURL();

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
        $this->urlParts['action'] = 'action' . ucfirst($parts[0]);
        array_shift($parts);

        // parts empty?
        if (empty($parts)) {
            return;
        }

        // set additional parts as params
        $this->urlParts['params'] = $this->getParams($parts);
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

    /**
     * Returns the full url from browser
     * @return string
     * @author Tim Zapfe
     */
    private function getFullURL(): string
    {
        // Get the protocol (http or https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // Get the hostname (e.g., www.example.com)
        $host = $_SERVER['HTTP_HOST'];

        // Get the request URI (e.g., /folder/page.php)
        $requestURI = $_SERVER['REQUEST_URI'];

        // Combine all parts to get the full URL
        return $protocol . $host . $requestURI;
    }
}