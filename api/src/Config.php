<?php

namespace src;

/**
 * Project Config
 * @author Tim Zapfe
 */
class Config
{
    public static array $config = [
        '*' => [
            'unsafeEnvVariables' => [ // these variables will be not be added with putenv()
                'DB_USER',
                'DB_PASS',
                'DB_HOST',
                'DB_NAME',
            ],
            'api' => [
                'cache' => true,
                'duration' => 60,
                'translate' => false
            ],
            'langs' => [
                'de', 'en', 'ru'
            ],
            'imageFolders' => [
                'background' => 'backgrounds',
                'general' => 'general',
                'avatar' => 'avatars',
                'temp' => 'temp'
            ]
        ],
        'dev' => [
            'debugMode' => true,
            'cacheMode' => false,
            'api' => [
                'cache' => false
            ]
        ],
        'production' => [
            'debugMode' => false,
            'cacheMode' => true,
            'api' => [
                'cache' => true
            ]
        ]
    ];

    /**
     * Builds config and returns it.
     * @param string|null $variable
     * @param mixed|null $fallback
     * @return mixed
     * @author Tim Zapfe
     */
    public static function getConfig(string $variable = null, mixed $fallback = null): mixed
    {
        // get the environment
        $environment = getenv('ENVIRONMENT') ?? 'production';

        // add global config
        $config = self::$config['*'];

        // loop through scopes
        foreach (self::$config[$environment] ?? [] as $key => $value) {
            if (is_array($value) && isset($config[$key]) && is_array($config[$key])) {
                $config[$key] = array_replace_recursive($config[$key], $value);
            } else {
                $config[$key] = $value;
            }
        }

        // add custom config variables
        $config['environment'] = $environment;
        $config['isLocal'] = (in_array($_SERVER['REMOTE_ADDR'], ['localhost', '127.0.0.1', '::1']));
        $config['lang'] = (!empty($_SESSION['lang'])) ? $_SESSION['lang'] : getenv('LANG') ?? 'en';

        // only specific key?
        if ($variable) {
            return $config[$variable] ?? $fallback;
        }

        return $config;
    }

    /**
     * Returns the unsafe env variables.
     * @return array
     * @author Tim Zapfe
     */
    public static function getUnsafeEnvVariables(): array
    {
        return self::$config['*']['unsafeEnvVariables'];
    }
}
