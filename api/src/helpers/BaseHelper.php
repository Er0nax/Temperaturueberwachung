<?php

namespace src\helpers;

/**
 * @author Tim Zapfe
 */
class BaseHelper
{
    /**
     * Returns the current full url.
     * @param bool $withRequest
     * @return string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    public static function getUrl(bool $withRequest = false): string
    {
        // Get the protocol (http or https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';

        // Get the hostname (e.g., www.example.com)
        $host = $_SERVER['HTTP_HOST'];

        // Requests
        $request = (!$withRequest) ? '' : $_SERVER['REQUEST_URI'];

        return rtrim($protocol . $host . $request, '/') . '/';
    }
}