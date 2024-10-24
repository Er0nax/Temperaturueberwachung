<?php

namespace src\controllers;

use JetBrains\PhpStorm\NoReturn;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class AssetController extends BaseController
{
    private ?string $name;
    private ?string $extension;
    private ?string $type;
    private ?string $height;
    private ?string $width;

    /**
     * Sets the information about an asset.
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    private function requireInfo(): void
    {
        $this->name = $this->getParam(0, 'src', null, true);
        $this->type = $this->getParam(1, 'type', null, true);
        $this->height = $this->getParam(2, 'height', null, true);
        $this->width = $this->getParam(3, 'width', null, true);

        if (empty($this->params)) {
            ResultHelper::render([
                'message' => 'This function requires some parameters.',
                'params' => [
                    'name' => 'The image full name without extension.',
                    'type (optional)' => 'The type of the image (like general, background, cover).',
                    'width (optional)' => 'The width of the displayed image in pixels.',
                    'height (optional)' => 'The height of the displayed image in pixels.',
                ]
            ], 406, $this->defaultConfig);
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
        // get the info for the image
        $info = pathinfo($this->name);

        if (empty($info['filename']) || empty($info['extension'])) {
            ResultHelper::render([
                'info' => 'Please provide a valid name with the extension for the asset.'
            ], 406, $this->defaultConfig);
        }

        if (!in_array($info['extension'], ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'zip', 'rar', 'pdf', 'mp4', 'mp3', 'webp'])) {
            ResultHelper::render([
                'info' => 'Your asset extension is not valid.'
            ], 400, $this->defaultConfig);
        }

        // set values
        $this->name = $info['filename'];
        $this->extension = $info['extension'];

        // update filename
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
        $this->requireInfo();

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
                'message' => $exception->getMessage(),
                'src' => $src
            ], 500, [
                'translate' => false
            ]);
        }
    }
}