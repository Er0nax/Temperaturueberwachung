<?php

namespace src\controllers;

/**
 * @author Tim Zapfe
 */
class BaseController
{
    public function render(mixed $data): void
    {
        var_dump($data);
    }
}