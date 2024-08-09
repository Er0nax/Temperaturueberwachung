<?php

namespace src\controllers;

use src\helpers\ResultHelper;

/**
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

        foreach ($allFunctions as $function) {
            // starts with action?
            if (str_starts_with($function, 'action') && $function != 'actionIndex') {
                $functions[] = $function;
            }
        }

        ResultHelper::render([
            'info' => 'You can call the following functions.',
            'functions' => $functions
        ]);
    }
}