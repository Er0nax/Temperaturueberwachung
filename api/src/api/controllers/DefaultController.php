<?php

namespace src\api\controllers;

/**
 * Default Controller for any API Request.
 * @author Tim Zapfe
 */
class DefaultController extends BaseController
{
    /**
     * Constructor
     * @param array $params
     * @author Tim Zapfe
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * Default action
     * @return void
     * @author Tim Zapfe
     */
    public function actionIndex(): void
    {
        $this->render('index action from default controller.');
    }
}