<?php

namespace src\controllers;

use src\controllers\BaseController;
use src\helpers\RecordHelper;
use src\helpers\ResultHelper;

/**
 * Stats Controller.
 * @author Tim Zapfe
 */
class StatsController extends BaseController
{
    /**
     * Get all-time stats for all records
     * @return void
     */
    public function actionTimes(): void
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

        // get all records by user
        $entry = RecordHelper::getRecordQuery();
        $records = $entry->where(['records' => [['active', true], ['userID', $userID]]])->all();

        $totalPause = 0;
        $totalWork = 0;
        $totalWorkWithPause = 0;
        $totalSkippedTime = 0;

        foreach ($records as $record) {
            // get times of day
            $times = RecordHelper::getTimeBetweenStartAndEnd($record['start'], $record['end']);

            // add values
            $totalPause += $times['totalPause']['timestamp'];
            $totalWork += $times['totalWork']['timestamp'];
            $totalWorkWithPause += $times['totalWorkWithPause']['timestamp'];

            // only add time when there was more than 8 total hours of work (like school should not be counted)
            if ($times['totalWork']['timestamp'] > (7 * 60 * 60)) {
                $totalSkippedTime += $times['totalTimeSkipped']['timestamp'] ?? 0;
            }
        }

        ResultHelper::render([
            'totalDays' => count($records),
            'totalPause' => $this->getDayStatsFromSeconds($totalPause),
            'totalWork' => $this->getDayStatsFromSeconds($totalWork),
            'totalWorkWithPause' => $this->getDayStatsFromSeconds($totalWorkWithPause),
            'totalSkippedTime' => $this->getDayStatsFromSeconds($totalSkippedTime),
        ]);
    }

    /**
     * Returns array of values calculates by seconds.
     * @param int $seconds
     * @return array
     */
    private function getDayStatsFromSeconds(int $seconds): array
    {
        // Define variables for seconds in a day, hour, and minute
        $secondsInADay = 31500;
        $secondsInAnHour = 3600;
        $secondsInAMinute = 60;

        // Calculate days, hours, minutes, and seconds without mutating variables
        $days = intdiv($seconds, $secondsInADay);
        $remainingSeconds = $seconds % $secondsInADay;

        $hours = intdiv($remainingSeconds, $secondsInAnHour);
        $remainingSeconds %= $secondsInAnHour;

        $minutes = intdiv($remainingSeconds, $secondsInAMinute);
        $seconds = $remainingSeconds % $secondsInAMinute;

        // Return the result as an array
        return [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
        ];
    }
}