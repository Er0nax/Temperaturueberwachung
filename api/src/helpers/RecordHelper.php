<?php

namespace src\helpers;

use ECSPrefix202206\React\Dns\Model\Record;
use src\components\Entry;
use src\helpers\BaseHelper;

/**
 * Helper Class for Records
 */
class RecordHelper extends BaseHelper
{
    /**
     * Returns the pre-build entry query.
     * @return Entry
     */
    public static function getRecordQuery(): Entry
    {
        $today = self::getDatesForToday()['date'];

        $entry = new Entry();

        $entry->columns(['records' => ['*'], 'days' => ['dayName']])
            ->tables(['records', ['days', 'records.dayID', 'days.id']])
            ->order('records.start DESC')
            ->where(['records' => [['date', $today], ['active', true]]]);

        return $entry;
    }

    /**
     * Returns the todays record.
     * @return array|bool|string|void
     */
    public static function getToday()
    {
        $entry = self::getRecordQuery();

        // does record exist?
        if ($entry->exists()) {
            return $entry->one();
        }

        // return error message
        ResultHelper::render('Today has not been started.');
    }

    /**
     * Get all tasks for one record.
     * @param int|null $recordID
     * @param int|null $userID
     * @return array
     */
    public static function getTasksForRecord(null|int $recordID): string|array
    {
        // check if record id is valid
        if (!is_numeric($recordID) || empty($recordID)) {
            return [];
        }

        $entry = new Entry();

        $entry->columns([
            'tasks' => ['information'],
            'projects' => ["name AS 'project'"]
        ])->tables([
            'recordtasks',
            ['tasks', 'recordtasks.taskID', 'tasks.id'],
            ['projects', 'tasks.projectID', 'projects.id']
        ])->where([
            'recordtasks' => [
                ['recordID', $recordID],
                ['active', true]
            ]
        ]);

        $tasks = $entry->all();

        // any task found?
        if (!empty($tasks)) {

            // loop throgh tasks
            foreach ($tasks as &$task) {
                // Bindestrich und Leerzeichen am Anfang entfernen
                $task['information'] = str_replace('-', '', $task['information']);

                // Zusätzliche Leerzeichen am Anfang und Ende entfernen
                $task['information'] = trim($task['information']);
            }

            return $tasks;
        }

        // get tasks set in record
        $entry->reset()->columns(['records' => ['tasks']])
            ->tables('records')
            ->where(['records' => [['id', $recordID]]]);

        $record = $entry->one();

        // task not empty?
        if (!empty($record['tasks'])) {
            // create array
            $tasks = [];
            $singleTasks = explode("\r\n", $record['tasks']);

            foreach ($singleTasks as $key => $task) {
                // Bindestrich und Leerzeichen am Anfang entfernen
                $task = str_replace('-', '', $task);

                // Zusätzliche Leerzeichen am Anfang und Ende entfernen
                $task = trim($task);

                $tasks[$key]['information'] = $task;
                $tasks[$key]['project'] = '/';
            }

            return $tasks;
        }

        return [];
    }

    /**
     * Returns useable timestamps for today
     * @return array
     */
    public static function getDatesForToday(): array
    {
        $info['date'] = date('d/m/Y');
        $info['day'] = date('l');
        $info['now'] = date('Y-m-d H:i:s');

        return $info;
    }

    /**
     * Returns all calculated times for a specific start and end.
     * @param string|null $starttime
     * @param string|null $endtime
     * @return array[]
     */
    public static function getTimeBetweenStartAndEnd(string|null $starttime, string|null $endtime): array
    {
        // 8h 45min
        $fullWorkDay = (8 * 60 * 60);
        $fullPause = (45 * 60);

        // get the start
        $start = strtotime($starttime ?? self::getDatesForToday()['now']);

        // get the end
        $end = strtotime($endtime ?? self::getDatesForToday()['now']);

        // is today?
        $isToday = (date('d/m/Y', $start) == date('d/m/Y'));

        // get the supposed end
        $supposedEnd = strtotime($starttime) + $fullWorkDay + $fullPause;

        // get total time between
        $totalWork = $end - $start;

        if ($totalWork < (5 * 60 * 60)) {
            $fullPause = 0;
        }

        // get time left to supposed end
        $totalWorkLeft = $supposedEnd - strtotime('now');
        $totalTimeSkipped = $fullWorkDay - ($totalWork - $fullPause);

        return [
            'totalPause' => [
                'help' => 'Total pause in hours.',
                'readable' => gmdate('H:i', $fullPause),
                'timestamp' => $fullPause
            ],
            'totalWork' => [
                'help' => 'Total work in hours.',
                'readable' => gmdate('H:i', $totalWork - $fullPause),
                'timestamp' => $totalWork - $fullPause
            ],
            'totalWorkWithPause' => [
                'help' => 'Total work + pause in hours.',
                'readable' => gmdate('H:i', $totalWork),
                'timestamp' => $totalWork
            ],
            'totalWorkLeft' => [
                'help' => 'Total work left in hours. If null, the day has been ended already.',
                'readable' => ($isToday) ? gmdate('H:i', $totalWorkLeft) : null,
                'timestamp' => ($isToday) ? $totalWorkLeft : null
            ],
            'totalTimeSkipped' => [
                'help' => 'Total time which should have been work time but was skipped instead. If null, no time was skipped.',
                'readable' => ($totalTimeSkipped > 0) ? gmdate('H:i', $totalTimeSkipped) : null,
                'timestamp' => ($totalTimeSkipped > 0) ? $totalTimeSkipped : null
            ],
            'supposedEnd' => [
                'help' => 'The supposed end time when work+pause should be finished.',
                'readable' => date('H:i', $supposedEnd),
                'timestamp' => $supposedEnd
            ]
        ];
    }
}