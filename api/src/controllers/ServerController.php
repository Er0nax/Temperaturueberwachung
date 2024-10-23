<?php

namespace src\controllers;

use src\helpers\ResultHelper;

/**
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 17.10.2024
 */
class ServerController extends BaseController
{
    /**
     * Returns all servers with sensors.
     * @return array|bool|string
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 17.10.2024
     */
    public function actionAll(): bool|array|string
    {
        $this->entry->reset();

        // get all servers
        $servers = $this->entry->columns(['servers' => ['id', 'name', 'updated_at', 'created_at']])
            ->tables('servers')
            ->where(['servers' => [['active', true]]])
            ->all();

        $this->entry->reset();

        // loop through each server and get sensores
        foreach ($servers as &$server) {

            // get all sensors for server
            $server['sensors'] = $this->entry->columns(['sensors' => ['id', 'name', 'updated_at', 'created_at'], 'manufacturers' => ["name AS 'manufacturer'"]])
                ->tables(['sensors', ['manufacturers', 'manufacturers.id', 'sensors.manufacturer_id', 'LEFT']])
                ->where(['sensors' => [['active', true], ['server_id', $server['id']]]])
                ->all();
        }

        return $servers;
    }

    /**
     * Creates a new sensor.
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 23.10.2024
     */
    public function actionCreate(): void
    {
        $user = $this->requireUser();
        $this->requireRole('Admin');

        $name = $this->getParam(0, 'name');

        if (empty($name)) {
            ResultHelper::render([
                'message' => 'Could not find a valid server name.'
            ], 404, $this->defaultConfig);
        }

        // create server
        $server_id = $this->entry->insert('servers', ['name' => $name]);

        if (is_numeric($server_id)) {
            // log
            $this->entry->insert('logs', [
                'user_id' => $user['id'],
                'action' => 'create',
                'relation' => 'servers',
                'relation_id' => $server_id
            ]);

            ResultHelper::render([
                'message' => 'Server created.'
            ], 200, $this->defaultConfig);
        }

        ResultHelper::render([
            'message' => 'Could not create server.'
        ], 500, $this->defaultConfig);
    }

    /**
     * Update a server.
     * @return void
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 23.10.2024
     */
    public function actionUpdate(): void
    {
        $user = $this->requireUser();
        $this->requireRole('Admin');

        $serverId = $this->getParam(0, 'server_id');
        $name = $this->getParam(1, 'name');
        $active = $this->getParam(2, 'active');

        $updates = [];

        // get server
        $this->entry->reset();
        $server = $this->entry->columns(['servers' => ['name', 'active']])
            ->tables('servers')
            ->where(['servers' => [['id', $serverId]]])
            ->one();

        // server found?
        if (empty($server)) {
            ResultHelper::render([
                'message' => 'Could not find a valid server.'
            ], 404, $this->defaultConfig);
        }

        // name given?
        if (!empty($name)) {
            if ($server['name'] !== $name)
                $updates['name'] = $name;
        }

        // active given?
        if (is_bool($active)) {
            if ($server['active'] !== $active)
                $updates['active'] = $active;
        }

        // updates not empty?
        if (empty($updates)) {
            ResultHelper::render([
                'message' => 'Nothing to update.'
            ], 404, $this->defaultConfig);
        }

        // update
        $updated = $this->entry->update('servers', $updates, ['id' => $serverId]);

        if (!$updated) {
            ResultHelper::render([
                'message' => 'Could not update server.'
            ], 500, $this->defaultConfig);
        }

        // add to log
        foreach ($updates as $column => $value) {
            $this->entry->insert('logs', [
                'user_id' => $user['id'],
                'action' => 'update',
                'relation' => 'servers',
                'relation_id' => $serverId,
                'old_value' => $server[$column],
                'new_value' => $value,
                'column_name' => $column
            ]);
        }

        ResultHelper::render([
            'message' => 'Server updated.'
        ], 200, $this->defaultConfig);
    }
}