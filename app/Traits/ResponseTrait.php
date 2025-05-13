<?php

namespace App\Traits;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;

trait ResponseTrait
{

    /**
     * @param $data
     * @param int $status
     * @return void
     */
    public function json($data, int $status = HttpStatus::OK): void
    {
        if (!headers_sent()) {
            http_response_code($status);
            header('Content-Type: application/json');
        }
        echo json_encode($data);
        exit;
    }

    /**
     * @param $message
     * @param int $status
     * @param array|null $data
     * @param string $type
     * @return void
     */
    public function jsonError($message, int $status = HttpStatus::BAD_REQUEST, array $data = null, string $type = Response::ERROR): void
    {
        if (!headers_sent()) {
            $status = HttpStatus::getStatus($status);
            http_response_code($status);
            header('Content-Type: application/json');
        }
        $return = ['type' => $type, 'message' => $message];
        if ($data) {
            $return['data'] = $data;
        }
        echo json_encode($return);
        exit;
    }

    /**
     * @param \Exception $e
     * @param array|null $data
     * @param string $type
     * @return void
     */
    public function jsonExceptions(\Exception $e, array $data = null, string $type = Response::ERROR): void
    {

        $return = ['type' => $type, 'message' => $e->getMessage()];

        if ($e instanceof ValidationException) {
            $return['errors'] = $e->getErrors();
            $return['type'] = Response::WARNING;
        }

        if ($e instanceof NotFoundException) {
            $return['type'] = Response::WARNING;
        }

        if ($data) {
            $return['data'] = $data;
        }

        if (!headers_sent()) {
            $status = HttpStatus::getStatus((int)$e->getCode());
            http_response_code($status);
            header('Content-Type: application/json');
        }
        echo json_encode($return);
        exit;
    }

    /**
     * @param $view
     * @param array $data
     * @param int $status
     * @return void
     */
    public function view($view, array $data = [], int $status = HttpStatus::OK): void
    {
        http_response_code($status);
        extract($data);
        $view = __DIR__ . "/../../views/{$view}.view.php";
        if (!file_exists($view)) {
            throw new \RuntimeException("A View {$view} não existe.");
        }
        include_once $view;
        exit;
    }


    /**
     * @param $message
     * @param int $status
     * @param string $type
     * @return void
     */
    public function htmlError($message, int $status = HttpStatus::BAD_REQUEST, string $type = Response::ERROR): void
    {
        if (!headers_sent()) {
            $status = HttpStatus::getStatus($status);
            http_response_code($status);
        }
        echo <<<ERROR
<html lang="pt"><head><title>{$type}</title></head><body>
<div style="text-align: center; margin: 50px auto">
<strong style="text-transform: uppercase">{$type}</strong>
<br />
<strong>{$message}</strong>
</div>
</body></html>
ERROR;
        exit;
    }

}