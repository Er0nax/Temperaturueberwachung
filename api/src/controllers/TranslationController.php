<?php

namespace src\controllers;

use src\components\Entry;
use src\helpers\ResultHelper;
use src\helpers\UserHelper;
use src\services\Translation;

/**
 * @author Tim Zapfe
 */
class TranslationController extends BaseController
{
    /**
     * Returns all translations
     * @return array|bool|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 17.10.2024
     */
    public function actionAll(): bool|array|string
    {
        $this->entry->reset();

        // get all roles
        return $this->entry->columns(['translations' => ['*']])->tables('translations')->where(['translations' => [['active', true]]])->all();
    }

    /**
     * Returns a translated string.
     * @return string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 17.10.2024
     */
    public function actionT(): string
    {
        $translation = $this->getParam(0, 't');
        $GLOBALS['API_LANGUAGE'] = $this->getParam(1, 'language', $GLOBALS['API_LANGUAGE']);
        $category = $this->getParam(2, 'category', 'site');

        // translation found?
        if (empty($translation)) {
            ResultHelper::render([
                'message' => 'Could not find a translation string.'
            ], 404, $this->defaultConfig);
        }

        // add variables
        $variables = [];

        // loop through all params and add them as a replacement variable for the translation
        foreach ($this->params as $key => $param) {
            if ($param !== 't') {
                $variables[$key] = $param;
            }
        }

        return ResultHelper::t($translation, $variables, $category);
    }
}