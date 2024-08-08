<?php

namespace src;

use src\components\Database;
use src\components\Env;
use src\components\Router;
use src\services\TranslationService;

/**
 * App
 * @author Tim Zapfe
 */
class App
{
    /**
     * Start the application.
     * @return void
     * @author Tim Zapfe
     */
    public function run(): void
    {
        $this->checkExtensions();

        // create new env and database
        define('ENV', new Env());
        define('DATABASE', new Database());

        // create new services
        define('Translation', new TranslationService());

        //FileHelper::clearCachedImages();

        // Start the router
        new Router();
    }

    /**
     * Check all important extensions
     * @return void
     * @author Tim Zapfe
     */
    private function checkExtensions(): void
    {
        $extensions = [
            'pdo' => 'ext-pdo',
            'curl' => 'ext-curl',
            'gd' => 'ext-gd',
            'exif' => 'ext-exif'
        ];

        $extentionNotFound = false;
        foreach ($extensions as $ext => $name) {
            if (!extension_loaded($ext)) {
                echo 'In order to work properly, please enable the ' . $name . ' extension.';
                $extentionNotFound = true;
            }
        }

        if ($extentionNotFound) {
            die();
        }
    }
}