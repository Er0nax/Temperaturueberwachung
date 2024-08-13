<?php

namespace src\services;

use src\components\Entry;
use src\Config;
use src\helpers\CacheHelper;

/**
 * Translation Service
 * @author Tim Zapfe
 */
class Translation extends BaseService
{
    public array $translations = [];

    /**
     * Constructor
     * @author Tim Zapfe
     */
    public function __construct()
    {
        // get lang
        $GLOBALS['API_LANGUAGE'] = $this->getLanguage();

        // get all translations from db
        $this->translations = $this->getTranslationsFromDBOrSession();
    }

    /**
     * @return array|false|mixed|string
     * @author Tim Zapfe
     */
    private function getLanguage(): mixed
    {
        // session given?
        if (!empty($_SESSION['lang'])) {
            if ($this->validLanguage($_SESSION['lang'])) {
                return $_SESSION['lang'];
            }
        }

        // cookie given?
        if (!empty($_COOKIE['lang'])) {
            if ($this->validLanguage($_COOKIE['lang'])) {
                return $_COOKIE['lang'];
            }
        }

        // env given?
        if (!empty(getenv('LANG'))) {
            if ($this->validLanguage(getenv('LANG'))) {
                return getenv('LANG');
            }
        }

        return 'en';
    }

    private function validLanguage(mixed $lang): bool
    {
        $validLangs = Config::getConfig('langs', ['en']);

        if (!is_string($lang)) {
            return false;
        }

        if (!in_array($lang, $validLangs)) {
            return false;
        }

        return true;
    }

    /**
     * @param string|null $string $string
     * @param array|string $variables
     * @param string $category
     * @return string
     * @author Tim Zapfe
     */
    public function getTranslation(string|null $string, array|string $variables = [], string $category = 'site'): string
    {
        if (empty($string)) {
            return $string;
        }

        // If the second parameter is a string, treat it as the category name
        if (is_string($variables)) {
            $category = $variables;
            $variables = [];
        }

        // get the value for the db
        $value = strtolower($string);

        // check if translations are given in object
        if (!empty($this->translations[$category][$value])) {

            // check if lang is given
            if (!empty($this->translations[$category][$value][$GLOBALS['API_LANGUAGE']])) {

                // return the translation from the array
                return $this->insertVariables($this->translations[$category][$value][$GLOBALS['API_LANGUAGE']], $variables);
            }
        } else {
            // add it to db/object
            $this->addTranslation($value, $string, $category);
        }

        // return the original content
        return $this->insertVariables($string, $variables);
    }

    /**
     * @param string $value
     * @param string $string
     * @param string $category
     * @return void
     * @author Tim Zapfe
     */
    private function addTranslation(string $value, string $string, string $category = 'site'): void
    {
        // insert if it does not exist
        $entry = new Entry();
        $entry->insert('translations', ['value' => $value, 'category' => $category, 'en' => $string]);

        // add to object
        $this->translations[$category][$value] = [
            'category' => $category,
            'value' => $value,
            'de' => '',
            'en' => $string,
            'active' => true
        ];
    }

    /**
     * @return array
     * @author Tim Zapfe
     */
    private function getTranslationsFromDBOrSession(): array
    {
        // exist in session? can be null
        $translationsFromCache = CacheHelper::getCache('translations', 'translations');

        // not null?
        if (!empty($translationsFromCache)) {

            // return the cached translations
            return $translationsFromCache;
        }

        // get all from db
        $entry = new Entry();
        $entry->columns(['translations' => ['*']])->tables('translations')->where(['translations' => [['active', true]]]);
        $translationsFromDB = $entry->all();

        // empty array
        $translations = [];

        // loop through db translations
        foreach ($translationsFromDB as $translation) {

            // add by category > value
            $translations[$translation['category']][$translation['value']] = $translation;
        }

        // save in cache
        CacheHelper::setCache($translations, 'translations', 1800);

        // return the translations from db
        return $translations;
    }

    /**
     * @param string $string
     * @param array $variables
     * @return string
     * @author Tim Zapfe
     */
    private function insertVariables(string $string, array $variables = []): string
    {
        // Perform the replacements
        foreach ($variables as $key => $value) {
            $string = str_replace('{' . $key . '}', $value, $string);
        }

        return $string;
    }
}