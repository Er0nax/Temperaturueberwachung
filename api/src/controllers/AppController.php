<?php

namespace src\controllers;

use src\components\Entry;
use src\controllers\BaseController;
use src\helpers\FileHelper;
use src\helpers\ResultHelper;

/**
 * App Controller
 * @author Tim Zapfe
 */
class AppController extends BaseController
{
    /**
     * Returns the latest application.
     * @return array|bool|string
     * @author Tim Zapfe
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
     */
    public function actionDownload(): void
    {
        // get the application
        $application = $this->getApplication();

        // latest version found?
        if (empty($application)) {
            ResultHelper::render('No application is available to download.', 500);
        }

        // version found as zip?
        if (!FileHelper::exist('web/assets/app/versions/' . $application['version'] . '.zip')) {
            ResultHelper::render('The latest version could not be found.', 500);
        }

        // update download counter
        $entry = new Entry();
        $entry->update('applications', ['downloads' => ($application['downloads'] + 1)], ['id' => $application['id']]);

        // get filename
        $filename = $application['name'] . '-' . $application['version'] . '.zip';
        $file = ASSET_PATH . '\\app\\versions\\' . $application['version'] . '.zip';

        header("Content-disposition: attachment;filename=$filename");
        readfile($file);
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
}