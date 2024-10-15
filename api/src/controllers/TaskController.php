<?php

namespace src\controllers;

use src\components\Entry;
use src\controllers\BaseController;
use src\helpers\BaseHelper;
use src\helpers\RecordHelper;
use src\helpers\ResultHelper;

/**
 * Controller logic for Tasks
 */
class TaskController extends BaseController
{
    /**
     * Creates a new task for a user and project
     * @return void
     */
    public function actionCreate(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                    'projectID (index 0)' => 'The ID of the project.',
                    'information (index 1)' => 'The information about the task (text).',
                    'recordID (index 2) (optional)' => 'The ID of the record. If empty, the ID of the record from today will be used. If no record has been created today, an error will occur.',
                ]
            ], 500, $this->defaultConfig);
        }

        // get the user id
        $userID = $this->getUserID();

        // get params
        $projectID = $this->getParam(0, 'projectID', 1);
        $information = $this->getParam(1, 'information');
        $recordID = $this->getParam(2, 'recordID');

        // check if project id is given
        if (!is_numeric($projectID)) {
            ResultHelper::render('Could not find a valid project id.', 500, $this->defaultConfig);
        }

        // check if information was empty
        if (empty($information)) {
            ResultHelper::render('Could not find any information about the task.', 500, $this->defaultConfig);
        }

        // check if record was specific
        if (!is_numeric($recordID)) {
            $recordID = RecordHelper::getToday()['id'];
        }

        $entry = new Entry();

        // insert task
        $taskID = $entry->insert('tasks', ['projectID' => $projectID, 'information' => $information]);

        if (!is_numeric($taskID)) {
            ResultHelper::render('Could not create task.', 500, $this->defaultConfig);
        }

        $recordtaskID = $entry->insert('recordtasks', ['recordID' => $recordID, 'taskID' => $taskID, 'userID' => $userID]);

        if (!is_numeric($recordtaskID)) {
            ResultHelper::render('Could not create recordtask.', 500, $this->defaultConfig);
        }

        ResultHelper::render('Successfully created task.', 200, $this->defaultConfig);
    }

    /**
     * Returns all tasks from today.
     * @return void
     */
    public function actionToday(): void
    {
        ResultHelper::render([
            'info' => 'This function is deprecated! Please use "record/info" instead.',
            'link' => BaseHelper::getUrl() . getenv('API_BASE_URL') . 'record/info' . (!empty($_SESSION['token']) ? '?token=' . $_SESSION['token'] : '')
        ], 500, $this->defaultConfig);

        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                ]
            ], 500, $this->defaultConfig);
        }

        $userID = $this->getUserID();
        $todaysRecord = RecordHelper::getToday();

        $entry = new Entry();

        // get all tasks
        $tasks = $entry->columns(['tasks' => ['*']])
            ->tables(['recordtasks', ['tasks', 'recordtasks.taskID', 'tasks.id']])
            ->where(['recordtasks' => [['userID', $userID], ['active', true], ['recordID', $todaysRecord['id']]]])
            ->all();

        // add project information for every task
        foreach ($tasks as $key => $task) {
            $tasks[$key]['project'] = $entry->columns(['projects' => ['name', 'short']])
                ->tables('projects')
                ->where(['projects' => [['active', true], ['id', $task['projectID']]]])
                ->one();
        }

        ResultHelper::render($tasks);
    }
}