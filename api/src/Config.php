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
                'DBUSER',
                'DBPASS',
                'DBHOST',
                'DBNAME',
            ],
            'rewriteRoutes' => [ // rewrite a route with: from => to
                'start' => 'index',
                'home' => 'index',
                'info' => 'about',
                'message' => 'contact',
                'call' => 'api'
            ],
            'api' => [
                'cache' => true,
                'duration' => 60,
                'translate' => false
            ],
            'langs' => [
                'de', 'en'
            ],
            'versions' => [
                'css' => '1.0.1',
                'js' => '1.0.2',
                'cjs' => '1.0.0',
                'manifest' => '1.0.3'
            ],
            'imageFolders' => [
                'icon' => 'icons',
                'background' => 'backgrounds',
                'banner' => 'banners',
                'link' => 'links',
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
        $config['isLoggedIn'] = !empty($_SESSION['user']['id']);
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
