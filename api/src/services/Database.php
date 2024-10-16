<?php

namespace src\services;

use PDO;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class Database extends BaseService
{
    public PDO $con;
    private array|bool $envVariables;

    /**
     * Constructor
     */
    public function __construct()
    {
        // env file given?
        if (!FileHelper::exist('.env')) {
            ResultHelper::render([
                'message' => 'Could not find the .env file!'
            ], 500, ['translate' => true]);
        }

        // parse env file
        $this->envVariables = parse_ini_file(FileHelper::get('.env'));

        $host = $this->getEnvVariable('DB_HOST');
        $name = $this->getEnvVariable('DB_NAME');
        $user = $this->getEnvVariable('DB_USER');
        $pass = $this->getEnvVariable('DB_PASS');

        try {
            $this->con = new PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $pass);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->exec('set names utf8mb4');

            // unset unsafe variables
            $this->envVariables = false;
        } catch (\PDOException $e) {
            ResultHelper::render([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Returns the value or exist with error message.
     * @param string $key
     * @return mixed|void
     * @author Tim Zapfe
     */
    private function getEnvVariable(string $key)
    {
        if (isset($this->envVariables[$key])) {
            return $this->envVariables[$key];
        }

        ResultHelper::render([
            'message' => 'Environment variable ' . $key . ' not found!'
        ], 500);
    }
}