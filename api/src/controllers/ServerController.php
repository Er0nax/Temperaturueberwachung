<?php

namespace src\controllers;

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
}