<?php

namespace src\helpers;

/**
 * @author Tim Zapfe
 */
class BaseHelper
{
    /**
     * Returns the current full url.
     * @return string
     */
    public static function getUrl(bool $withRequest = false): string
    {
        // Get the protocol (http or https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // Get the hostname (e.g., www.example.com)
        $host = $_SERVER['HTTP_HOST'];

        // Requests
        $request = (!$withRequest) ? '' : $_SERVER['REQUEST_URI'];

        return rtrim($protocol . $host . $request, '/') . '/';
    }
}