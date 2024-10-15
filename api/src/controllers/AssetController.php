<?php

namespace src\controllers;

use JetBrains\PhpStorm\NoReturn;
use src\components\Entry;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;
use src\helpers\UserHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class AssetController extends BaseController
{
    private string $name = 'default';
    private string $extension = 'png';
    private string $type = 'general';
    private ?string $height = null;
    private ?string $width = null;

    /**
     * Sets the information about an asset.
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    private function setInfo(): void
    {
        $this->name = $this->getParam(0, 'name', 'default');
        $this->extension = $this->getParam(1, 'extension', 'png');
        $this->type = $this->getParam(2, 'type', 'general');
        $this->height = $this->getParam(3, 'height');
        $this->width = $this->getParam(4, 'width');

        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'name' => 'The image full name without extension.',
                    'extension' => 'The image extension (like png, jpg, jpeg).',
                    'type (optional)' => 'The type of the image (like general, background, cover).',
                    'width (optional)' => 'The width of the displayed image in pixels.',
                    'height (optional)' => 'The height of the displayed image in pixels.',
                ]
            ], 500, $this->defaultConfig);
        }

        if (empty($this->name) || empty($this->extension)) {
            ResultHelper::render([
                'info' => 'Please provide the full name and the extension of the asset.',
            ], 500, $this->defaultConfig);
        }
    }

    /**
     * Returns the full name of a file.
     * @return string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    private function getName(): string
    {
        return $this->name . '.' . $this->extension;
    }

    /**
     * Returns an image.
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    #[NoReturn] public function actionImage(): void
    {
        // set information
        $this->setInfo();

        if (!in_array($this->extension, ['png', 'jpg', 'jpeg', 'gif'])) {
            $this->extension = 'png';
        }

        // get src
        $src = FileHelper::getImage($this->getName(), $this->type, ['height' => $this->height, 'width' => $this->width]);

        // does file exist?
        try {
            // set header
            header('Content-Type: image/' . $this->extension);
            // read file and output it
            readfile($src);
            // end application
            die();
        } catch (\Exception $exception) {
            ResultHelper::render([
                'src' => $src,
                'info' => $exception->getMessage(),
            ], 500, $this->defaultConfig);
        }
    }
}