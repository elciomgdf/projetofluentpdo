<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Services\UserService;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Validators\UserValidator;

/**
 * Classe para o cadastro do Usuário
 */
class SignUpController {

    use ResponseTrait, RequestTrait;

    public function create(): void
    {
        try {

            $data = UserValidator::validate($this->inputs());

            $user = (new UserService())->save($data);

            $this->json($user->toArray(), HttpStatus::CREATED);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }

    }

}