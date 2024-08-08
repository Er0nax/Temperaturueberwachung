<?php

namespace src\services;

/**
 * @author Tim Zapfe
 */
class BaseService
{
    /**
     * Echos given data as json.
     * @param mixed $data
     * @param bool $error
     * @return void
     * @author Tim Zapfe
     */
    public function render(mixed $data, bool $error = true): void
    {
        // set header
        $this->setHeader();

        // set content
        $content = [
            'error' => $error,
            'response' => $data
        ];

        // echo as json format
        echo json_encode($content);
        exit();
    }

    /**
     * sets the header as json format.
     * @return void
     * @author Tim Zapfe
     */
    private function setHeader(): void
    {
        header('Content-Type: application/json');
    }
}