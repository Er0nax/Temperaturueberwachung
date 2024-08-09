<?php

namespace src\helpers;

use src\Config;

/**
 * @author Tim Zapfe
 */
class ResultHelper extends BaseHelper
{
    /**
     * Renders content with json header
     * @param mixed $data
     * @param int $status
     * @param array $config
     * @return void
     * @author Tim Zapfe
     */
    public static function render(mixed $data, int $status = 200, array $config = []): void
    {
        self::setHeader();

        $config = array_merge(Config::getConfig('api', []), $config);

        // check if data is string
        if (is_string($data) && $config['translate']) {
            // translate string
            $data = self::t($data);
        }

        // check if is object?
        if (is_object($data)) {
            // convert to array
            $data = (array)$data;
        }

        // should be cached when success?
        if ($config['cache'] && ($status >= 200 && $status <= 299)) {
            // save in cache
            $hash = CacheHelper::generateHash(constant('URL_PARTS'));
            CacheHelper::setCache($data, $hash, $config['duration']);
        }

        // return as json encode
        echo json_encode([
            'status' => $status,
            'cached' => $config['cached'] ?? false,
            'response' => $data,
        ]);

        exit();
    }

    /**
     * Translate a string
     * @param string|null $string
     * @param array|string $variables
     * @param string $category
     * @return string
     * @author Tim Zapfe
     */
    public static function t(string|null $string, array|string $variables = [], string $category = 'site'): string
    {
        return Translation->getTranslation($string, $variables, $category);
    }

    /**
     * Set the header as JSON
     * @return void
     * @author Tim Zapfe
     */
    private static function setHeader(): void
    {
        header('Content-Type: application/json');
    }
}