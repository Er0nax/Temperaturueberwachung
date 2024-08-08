<?php

namespace src\components;

use src\api\Api;
use src\Config;
use src\helpers\ParseHelper;

/**
 * Router component
 * @author Tim Zapfe
 */
class Router
{
    private string $page = 'index';
    private array $params = [];
    private string $type = 'template';

    /**
     * Constructor
     * @author Tim Zapfe
     */
    public function __construct()
    {
        // get page, params and type
        $this->page = $this->getPage();
        $this->params = $this->getParams();
        $this->type = $this->getType();

        // start logic
        $this->callTypeLogic();
    }

    /**
     * Calls new class by type.
     * @return void
     * @author Tim Zapfe
     */
    private function callTypeLogic(): void
    {
        switch ($this->type) {
            case 'api':
                new Api($this->params);
                break;
            default:
                exit('no api detected.');
        }
    }

    /**
     * Returns the page (first request key - encoded)
     * @return string
     * @author Tim Zapfe
     */
    private function getPage(): string
    {
        // get array of requests
        $requests = $this->getUrlRequests();

        // check for rewrite routes
        $rewriteRoutes = Config::getConfig('rewriteRoutes', []);

        // get page by first key
        $page = (!empty($requests[0])) ? $requests[0] : $this->page;

        foreach ($rewriteRoutes as $from => $to) {
            // is page like any "from"?
            if ($page === $from) {
                return $to;
            }
        }

        // return the first key or default
        return $page;
    }

    /**
     * Returns an array of params (encoded)
     * @return string[]
     * @author Tim Zapfe
     */
    private function getParams(): array
    {
        // get array of requests
        $requests = $this->getUrlRequests();

        // remove first key if exists
        if (isset($requests[0])) {
            array_shift($requests);
        }

        foreach ($requests as $key => $value) {
            if (ParseHelper::isJson($value)) {
                // Convert the JSON string to a PHP array
                $requests[$key] = json_decode($value, true);
            }
        }

        return $requests;
    }

    /**
     * Returns the type
     * @return string
     * @author Tim Zapfe
     */
    private function getType(): string
    {
        return match ($this->page) {
            'api' => 'api',
            'migrate' => 'migration',
            default => $this->type,
        };
    }

    /**
     * @return string[]
     * @author Tim Zapfe
     */
    private function getUrlRequests(): array
    {
        $fullUrl = $this->getFullUrl();

        // Remove the base URL from the full URL
        $baseUrl = getenv('BASE_URL');
        if (str_starts_with($fullUrl, $baseUrl)) {
            $url = substr($fullUrl, strlen($baseUrl));
        } else {
            $url = $fullUrl;
        }

        // Remove query parameters
        $url = strtok($url, '?');

        // Explode by "/" and filter out empty elements
        $requests = array_filter(explode('/', $url), function ($value) {
            return $value !== '';
        });

        // Reindex the array to ensure it starts from 0
        $requests = array_values($requests);

        // Merge with $_GET parameters
        return array_merge($requests, $_GET, $_POST);
    }

    /**
     * Returns the full decoded url as string
     * @return string
     * @author Tim Zapfe
     */
    private function getFullUrl(): string
    {
        $http = (empty($_SERVER['HTTPS']) ? 'http' : 'https');
        $host = urldecode($_SERVER['HTTP_HOST']);
        $reqs = ParseHelper::escapeString(urldecode($_SERVER['REQUEST_URI']));

        return urldecode($http . '://' . $host . $reqs);
    }
}