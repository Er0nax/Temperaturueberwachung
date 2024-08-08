<?php

namespace src\controllers;


/**
 * Main Controller with basic functions
 * @author Tim Zapfe
 */
class BaseController
{
    /**
     * @param mixed $data
     * @return void
     * @author Tim Zapfe
     */
    protected function render(mixed $data): void
    {
        var_dump($data);
    }
}