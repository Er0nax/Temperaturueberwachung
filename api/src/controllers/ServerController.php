<?php

namespace src\controllers;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 17.10.2024
 */
class ServerController extends BaseController
{
    public function actionAll()
    {
        $this->entry->reset();
        
        $servers = $this->entry->columns([])
    }
}