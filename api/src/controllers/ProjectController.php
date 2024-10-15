<?php

namespace src\controllers;

use src\components\Entry;
use src\controllers\BaseController;
use src\helpers\ResultHelper;

/**
 * Logic for Projects
 */
class ProjectController extends BaseController
{
    /**
     * Returns all available projects
     * @return array|bool|string
     */
    private function getProjects(): bool|array|string
    {
        $entry = new Entry();

        $entry->columns(['projects' => ['*']])
            ->tables('projects')
            ->where(['projects' => [['active', true]]]);

        return $entry->all();
    }

    /**
     * Returns all available projects
     * @return void
     */
    public function actionAll(): void
    {
        $projects = $this->getProjects();
        ResultHelper::render($projects);
    }

    /**
     * Returns the last used project by a user
     * @return void
     */
    public function actionLast(): void
    {
        // get user
        $userID = $this->getUserID();

        // get last used project id
        $entry = new Entry();

        $entry->columns(['projects' => ['*']])
            ->tables(['recordtasks',
                ['tasks', 'recordtasks.taskID', 'tasks.id'],
                ['projects', 'tasks.projectID', 'projects.id']])
            ->where(['recordtasks' => [['userID', $userID], ['active', true]]])
            ->order('recordtasks.createdAt DESC');

        $project = $entry->one();

        // project found?
        if (!empty($project)) {
            ResultHelper::render($project);
        }

        // return first project from all projects
        $allProjects = $this->getProjects();

        ResultHelper::render($allProjects[0]);
    }

    /**
     * Creates a new project
     * @return void
     */
    public function actionCreate(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'name (index 0)' => 'The actual name of the project.',
                    'short (index 1) (optional)' => 'The actual short name of the project. If empty, it will be generated automaticly.',
                ]
            ], 500, $this->defaultConfig);
        }

        $name = $this->getParam(0, 'name');
        $short = $this->getParam(1, 'short', $this->createShortName($name));

        // name empty?
        if (empty($name)) {
            ResultHelper::render('Could not find a valid name.', 500, $this->defaultConfig);
        }

        $entry = new Entry();

        $entry->columns(['projects' => ['*']])
            ->tables('projects')
            ->where(['projects' => [
                ['name', $name],
                ['short', $short]
            ]], 'OR');

        $entry->addWhere(['projects' => [['active', true]]]);

        // does project exist?
        if ($entry->exists()) {
            ResultHelper::render('The project does already exist by name or short!', 500, $this->defaultConfig);
        }

        // try to insert
        $success = $entry->insert('projects', ['name' => $name, 'short' => $short]);

        // when successfull it will return the inserted id
        if (is_numeric($success)) {
            ResultHelper::render('Project has been created.');
        }

        ResultHelper::render('There was an error while creating a new project!', 500, $this->defaultConfig);
    }

    /**
     * Returns a short name for an input
     * @param $input
     * @return string
     */
    private function createShortName($input): string
    {
        // Trim and remove any multiple spaces
        $input = trim(preg_replace('/\s+/', ' ', $input));

        // Split the string into words
        $words = explode(' ', $input);

        // If there is only one word or the word is short, return it as is
        if (count($words) == 1 || strlen($input) <= 10) {
            return $input;
        }

        $abbreviation = '';
        foreach ($words as $word) {
            // Skip common conjunctions like "und", "and"
            if (strtolower($word) == 'und' || strtolower($word) == 'and') {
                $abbreviation .= '&';
            } // Take the first letter of each meaningful word (longer than 2 characters or contains capital letters)
            elseif (strlen($word) > 2 || preg_match('/[A-ZÄÖÜ]/', $word)) {
                $abbreviation .= mb_substr($word, 0, 1);
            }
        }

        return strtoupper($abbreviation); // Return the abbreviation in uppercase
    }
}