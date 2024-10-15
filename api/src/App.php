<?php

namespace src;

use src\components\Router;
use src\helpers\FileHelper;
use src\services\Database;
use src\services\Env;
use src\services\Translation;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class App
{
    /**
     * Start the Application
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    public function run(): void
    {
        // define services
        define('Env', new Env());
        define('Database', new Database());
        define('Translation', new Translation());

        //FileHelper::clearCachedImages();

        // new Router
        new Router();

    }
}