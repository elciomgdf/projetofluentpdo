<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Services\UserService;
use App\Traits\EncodeTrait;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Validators\UserValidator;

/**
 * Classe para o cadastro do Usuário
 */
class SignUpController
{

    use ResponseTrait, RequestTrait, EncodeTrait;

    /**
     * Cria um novo usuário no sistema
     * @return void
     */
    public function create(): void
    {
        try {

            $data = UserValidator::validate($this->inputs());

            $user = (new UserService())->save($data);

            $this->json(array_merge($user->toArray(), ['encoded_id' => $this->encode($user->getId())]), HttpStatus::CREATED);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }

    }


    /**
     * Gera e envia uma nova senha ao usuário
     * @return void
     */
    public function sendPassword(): void
    {
        try {

            (new UserService())->createNewPassword($this->input('email'));

            $this->json(['type' => Response::SUCCESS, 'message' => 'Caso você possua cadastro com o e-mail informado, seus dados de acesso chegarão em instantes.']);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }

    }

}