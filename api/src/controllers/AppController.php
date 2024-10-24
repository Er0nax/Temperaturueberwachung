<?php

namespace src\controllers;

use src\components\Entry;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class AppController extends BaseController
{
    /**
     * Returns the latest application.
     * @return bool|array|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    private function getApplication(): bool|array|string
    {
        // get latest version
        $entry = new Entry();

        $entry->columns(['applications' => ['*']])
            ->tables('applications')
            ->where(['applications' => [['active', true]]])
            ->order('applications.created_at DESC');

        // get the application
        return $entry->one();
    }

    /**
     * Downloads the current exe with all information.
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 15.10.2024
     */
    public function actionDownload(): void
    {
        // get the application
        $application = $this->getApplication();

        // latest version found?
        if (empty($application)) {
            ResultHelper::render([
                'message' => 'No application is available to download.'
            ], 404, $this->defaultConfig);
        }

        // version found as zip?
        if (!FileHelper::exist('web/assets/app/versions/' . $application['version'] . '.zip')) {
            ResultHelper::render([
                'message' => 'The latest version could not be found.'
            ], 404, $this->defaultConfig);
        }

        // update download counter
        $entry = new Entry();
        $entry->update('applications', ['downloads' => ($application['downloads'] + 1)], ['id' => $application['id']]);

        // get filename
        $filename = $application['name'] . '-' . $application['version'] . '.zip';
        $file = ASSET_PATH . '\\app\\versions\\' . $application['version'] . '.zip';

        // Send the download headers
        header("Content-disposition: attachment;filename=$filename");
        readfile($file);

        // Output the JavaScript to close the window
        echo '<script type="text/javascript">';
        echo 'window.close();';
        echo '</script>';
    }

    /**
     * Returns the info about the latest application.
     * @return void
     * @author Tim Zapfe
     */
    public function actionInfo(): void
    {
        $application = $this->getApplication();

        ResultHelper::render($application);
    }

    /**
     * Returns simple true to check if the api is successfully connected.
     * @return void
     */
    public function actionCheckApi(): void
    {
        ResultHelper::render(true);
    }
}