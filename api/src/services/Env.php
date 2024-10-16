<?php

namespace src\services;

use src\Config;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 */
class Env extends BaseService
{
    /**
     * Sets all safe .env variables to php's env
     * @author Tim Zapfe
     */
    public function __construct()
    {
        // check if .env file exists
        if (!FileHelper::exist('.env')) {
            ResultHelper::render([
                'message' => 'Could not locate .env file!'
            ], 500, ['translate' => true]);
        }

        // get variables
        $allVariables = $this->getSafeVariables(parse_ini_file(FileHelper::get('.env')));

        // put all env variables inside php's env
        foreach ($allVariables as $name => $value) {
            putenv("{$name}={$value}");
        }

        // check for environment
        $environment = getenv('ENVIRONMENT');
        if ($environment != 'production' && $environment != 'dev') {
            ResultHelper::render([
                'message' => 'Missing or invalid "ENVIRONMENT" in .env file!'
            ], 500);
        }

        $this->setErrorHandling();
    }

    /**
     * Returns all safe variables.
     * @param $allVariables
     * @return mixed
     * @author Tim Zapfe
     */
    private function getSafeVariables($allVariables): mixed
    {
        $unsafeVariables = Config::getUnsafeEnvVariables() ?? [];

        foreach ($unsafeVariables as $name) {
            if (isset($allVariables[$name])) {
                unset($allVariables[$name]);
            }
        }

        return $allVariables;
    }

    /**
     * @return void
     * @author Tim Zapfe
     */
    private function setErrorHandling(): void
    {
        $stage = getenv('ENVIRONMENT') ?? 'production';

        if ($stage === 'production') {
            ini_set('display_errors', 'off');
        }
    }
}