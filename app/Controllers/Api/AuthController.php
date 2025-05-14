<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Services\AuthService;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;

class AuthController
{
    use RequestTrait, ResponseTrait;

    /**
     * Login por E-mail e Senha
     *
     * @return void
     */
    public function login()
    {

        try {

            $email = $this->input('email');

            $password = $this->input('password');

            if (!$email || !$password) {
                throw new \Exception("E-mail e senha são obrigatórios", HttpStatus::UNAUTHORIZED);
            }

            $this->json((new AuthService())->login($email, $password));

        } catch (\Exception $e) {
            $this->jsonError($e->getMessage(), $e->getCode());
        }

    }

    /**
     * Faz o logout do usuário
     * @return void
     */
    public function logout()
    {
        try {
            if ((new AuthService())->logout()) {
                $this->json(['type' => Response::SUCCESS, 'message' => 'Logout efetuado com sucesso']);
            }
            $this->jsonError('Logout inválido ou desnecessário');
        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

}
