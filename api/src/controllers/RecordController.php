<?php

namespace src\controllers;

use DateTime;
use src\components\Entry;
use src\helpers\RecordHelper;
use src\helpers\ResultHelper;
use src\services\Translation;

/**
 * Content for records.
 */
class RecordController extends BaseController
{
    /**
     * Returns all
     * @return void
     */
    public function actionAll(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                    'limit (index 0) (optinal)' => 'The limit of rendered records.',
                ]
            ], 500, $this->defaultConfig);
        }

        // get the user id
        $userID = $this->getUserID();

        // get custom limit
        $limit = $this->getParam(0, 'limit');

        $entry = new Entry();
        $recordsWithDateAsKey = [];

        $entry->columns(['records' => ['*']])
            ->tables('records')
            ->limit($limit)
            ->order('records.start DESC')
            ->where(['records' => [['active', true], ['userID', $userID]]]);

        // add tasks for records by user id
        foreach ($entry->all() as $key => $record) {

            $recordsWithDateAsKey[$record['date']] = $record;

            // tasks given by hand? (old version)
            if (empty($record['tasks'])) {

                // get all tasks
                $recordsWithDateAsKey[$record['date']]['tasks'] = RecordHelper::getTasksForRecord($record['id']);
            }
        }

        ResultHelper::render([
            'total' => count($recordsWithDateAsKey),
            'records' => $recordsWithDateAsKey
        ]);
    }

    /**
     * Start a new day.
     * @return void
     */
    public function actionStart(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                ]
            ], 500, $this->defaultConfig);
        }

        // get the user id
        $userID = $this->getUserID();

        // get todays date
        $timestamps = RecordHelper::getDatesForToday();

        $entry = new Entry();
        $entry->columns(['records' => ['*']])
            ->tables('records')
            ->where(['records' => [
                ['active', true],
                ['userID', $userID],
                ['date', $timestamps['date']]]
            ]);

        // first check if today exists
        if ($entry->exists()) {
            ResultHelper::render('Today has already been started.', 500, $this->defaultConfig);
        }

        // get id of todays day
        $entry->columns(['days' => ['id']])
            ->tables('days')
            ->where(['days' => [['active', true], ['dayTitle', $timestamps['day']]]]);
        $dayID = $entry->one()['id'];

        // insert today
        $recordID = $entry->insert('records', [
            'userID' => $userID,
            'dayID' => $dayID,
            'date' => $timestamps['date'],
            'start' => $timestamps['now']
        ]);

        if (!is_numeric($recordID)) {
            ResultHelper::render('Could not start a new day.', 500, $this->defaultConfig);
        }

        ResultHelper::render('New day started.', 200, $this->defaultConfig);
    }

    /**
     * End todays day.
     * @return void
     */
    public function actionEnd(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                ]
            ], 500, $this->defaultConfig);
        }

        // get the user id
        $userID = $this->getUserID();

        // get todays date
        $timestamps = RecordHelper::getDatesForToday();
        $todaysRecord = RecordHelper::getToday();

        // end today
        $entry = new Entry();
        $success = $entry->update('records', ['end' => $timestamps['now']], ['id' => $todaysRecord['id']]);

        if (!$success) {
            ResultHelper::render('Could not end todays day.', 500, $this->defaultConfig);
        }

        ResultHelper::render('Successfully ended todays day.', 200, $this->defaultConfig);
    }

    /**
     * Returns the information about a record.
     * @return void
     */
    public function actionInfo(): void
    {
        if (empty($this->params)) {
            ResultHelper::render([
                'info' => 'Please provide the following params:',
                'params' => [
                    'token' => 'Your personal access token.',
                    'id / date (index 0) (optional)' => 'The ID or timestamp (d-m-Y) of the record.'
                ]
            ], 500, $this->defaultConfig);
        }

        // get the user id
        $userID = $this->getUserID();
        $recordID = $this->getParam(0, 'id');
        $recordDate = $this->getParam(0, 'date');

        $info = [];

        // search record
        $entry = RecordHelper::getRecordQuery();

        // valid id given?
        if (is_numeric($recordID)) {
            // change where
            $entry->where(['records' => [['id', $recordID], ['active', true]]]);
            $record = $entry->one();
        }

        // record not found and date is given?
        if (empty($record) && !empty($recordDate) && !is_numeric($recordDate)) {
            // build when it's found by date
            $date = date('d/m/Y', DateTime::createFromFormat('d-m-Y', $recordDate)->getTimestamp());

            // change where
            $entry->where(['records' => [['date', $date], ['active', true]]]);
            $record = $entry->one();
        }

        // record still not found by id or date?
        if (empty($record)) {
            // get todays record
            $record = RecordHelper::getToday();
        }

        // set information
        $info['id'] = $record['id'];
        $info['day'] = Translation->getTranslation($record['dayName']);
        $info['date'] = date('Y-m-d', DateTime::createFromFormat('d/m/Y', $record['date'])->getTimestamp());

        // add start and end if set
        $info['start'] = !empty($record['start']) ? date('H:i', strtotime($record['start'])) : null;
        $info['end'] = !empty($record['end']) ? date('H:i', strtotime($record['end'])) : null;

        // add times
        $info['times'] = RecordHelper::getTimeBetweenStartAndEnd($record['start'], $record['end']);

        // add tasks
        $info['tasks'] = RecordHelper::getTasksForRecord($record['id']);

        ResultHelper::render($info);
    }

    /**
     * Temp Function to set the correct days by the date
     * @return void
     */
    public function actionUpdateDays(): void
    {
        ResultHelper::render('This function has been disabled.', 500, $this->defaultConfig);

        // get all days when day id is 0
        $entry = new Entry();

        $entry->columns(['records' => ['*']])
            ->tables('records')
            ->where(['records' => [['dayID', 0]]])
            ->order('records.start DESC');

        $records = $entry->all();

        // loop through all records
        foreach ($records as $record) {
            // get date
            $day = date('l', DateTime::createFromFormat('d/m/Y', $record['date'])->getTimestamp());

            // get the id of the day
            $dayInfo = $entry->reset()->columns(['days' => ['id']])->tables('days')->where(['days' => [['dayTitle', $day]]])->one();

            $recordID = $record['id'];

            // update record with id
            $updates[$recordID]['updated'] = $entry->update('records', ['dayID' => $dayInfo['id']], ['id' => $recordID]);
            $updates[$recordID]['date'] = $record['date'];
        }

        ResultHelper::render($updates);
    }
}