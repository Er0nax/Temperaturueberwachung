<?php

namespace src;

use src\components\Router;
use src\services\Database;
use src\services\Env;
use src\services\Translation;

/**
 * @author Tim Zapfe
 */
class App
{
    /**
     * Start the Application
     * @return void
     * @author Tim Zapfe
     */
    public function run(): void
    {
        // define services
        define('Env', new Env());
        define('Database', new Database());
        define('Translation', new Translation());

        // new Router
        new Router();
    }
}