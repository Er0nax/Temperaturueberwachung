<?php

namespace src\controllers;

use src\helpers\ResultHelper;

/**
 * Default Controller
 * @author Tim Zapfe
 */
class BaseController
{
    public array $params = [];

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

        // loop through all functions
        foreach ($allFunctions as $function) {
            // starts with action?
            if (str_starts_with($function, 'action') && $function != 'actionIndex') {
                $functions[] = str_replace('action', '', $function);
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
                $controllers[] = str_replace('Controller.php', '', $file);
            }

            ResultHelper::render([
                'info' => 'This is the default action. Please provide a valid controller with a valid action. If you do not know any available actions, just call the controller and it will display all.',
                'controllers' => $controllers
            ]);
        }

        ResultHelper::render([
            'info' => 'You can call the following functions.',
            'functions' => $functions
        ]);
    }
}