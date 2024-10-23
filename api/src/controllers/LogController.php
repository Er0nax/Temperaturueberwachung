<?php

namespace src\controllers;

use src\helpers\UserHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 17.10.2024
 */
class LogController extends BaseController
{
    /**
     * Returns the rows of the log table. Can be filtered by a relation, limit and offset
     * @return array|bool|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 23.10.2024
     */
    public function actionAll(): bool|array|string
    {
        $relation = $this->getParam(0, 'relation');
        $limit = $this->getParam(1, 'limit', 100);
        $offset = $this->getParam(2, 'offset', 0);

        // build the query
        $query = $this->entry->columns(['logs' => ['*']])
            ->tables('logs')
            ->where(['logs' => [['active', true]]])
            ->order('logs.created_at DESC')
            ->limit($limit)
            ->offset($offset);

        // add relation of given
        if (!empty($relation) && $relation != 'all') {
            $query->addWhere(['logs' => [['relation', $relation]]]);
        }

        // return all logs
        $logs = $query->all();

        foreach ($logs as &$log) {
            // get user data
            $log['user'] = UserHelper::getUserQuery()->where(['users' => [['id', $log['user_id']]]])->one();

            // unset useless variables
            unset($log['user_id']);
        }

        return $logs;
    }
}