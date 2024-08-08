<?php

namespace src\api\controllers;

use src\Config;
use src\helpers\CacheHelper;

/**
 * Main API Controller
 * @author Tim Zapfe
 */
class BaseController
{
    protected array $params = [];

    /**
     * Echos given data as json.
     * @param mixed $data
     * @param string|int|bool $status
     * @param array $config
     * @return void
     * @author Tim Zapfe
     */
    public function render(mixed $data, string|int|bool $status = 200, array $config = []): void
    {
        $this->setHeader();
        $config = array_merge(Config::getConfig('api', []), $config);
        $error = !($status === 200 || $status === true || $status === 'success' || $status === 'OK');

        // check if data is string
        if (is_string($data) && $config['translate']) {
            // translate string
            $data = $this->t($data);
        }

        // check if is object?
        if (is_object($data)) {
            // convert to array
            $data = (array)$data;
        }

        // should be cached?
        if ($config['cache'] && !$error) {
            // save in cache
            $hash = CacheHelper::generateHash($this->params);
            CacheHelper::setCache($data, $hash, $config['duration']);
        }

        // return as json encode
        echo json_encode([
            'error' => $error,
            'cached' => $config['cached'] ?? false,
            'response' => $data,
        ]);

        exit();
    }

    /**
     * Returns the translated value.
     * @param string|null $string $string
     * @param array|string $variables
     * @param string $category
     * @return string
     * @author Tim Zapfe
     */
    public function t(string|null $string, array|string $variables = [], string $category = 'site'): string
    {
        return Translation->getTranslation($string, $variables, $category);
    }

    /**
     * sets the header as json format.
     * @return void
     * @author Tim Zapfe
     */
    private function setHeader(): void
    {
        header('Content-Type: application/json');
    }
}