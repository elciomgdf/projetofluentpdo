<?php

namespace App\Constants;

class HttpStatus {
    public const OK = 200;
    public const CREATED = 201;
    public const NO_CONTENT = 204;
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const UNPROCESSABLE_ENTITY = 422;
    public const INTERNAL_SERVER_ERROR = 500;

    public static function toArray(): array {
        return [
            'OK' => self::OK,
            'CREATED' => self::CREATED,
            'NO_CONTENT' => self::NO_CONTENT,
            'BAD_REQUEST' => self::BAD_REQUEST,
            'UNAUTHORIZED' => self::UNAUTHORIZED,
            'FORBIDDEN' => self::FORBIDDEN,
            'NOT_FOUND' => self::NOT_FOUND,
            'UNPROCESSABLE_ENTITY' => self::UNPROCESSABLE_ENTITY,
            'INTERNAL_SERVER_ERROR' => self::INTERNAL_SERVER_ERROR,
            'METHOD_NOT_ALLOWED' => self::METHOD_NOT_ALLOWED,
        ];
    }

    public static function getStatus(int $code, $default = self::BAD_REQUEST): int {

        if (empty(array_search($code, self::toArray(), true))) {
            return $default;
        }

        return $code;

    }

}
