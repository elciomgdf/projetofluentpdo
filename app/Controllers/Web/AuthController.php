<?php

namespace App\Controllers\Web;

use App\Constants\HttpStatus;
use App\Services\AuthService;

class AuthController extends Controller
{

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

            $this->renewCsrfToken();

            $this->json((new AuthService())->login($email, $password, true));

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
            (new AuthService())->logout(true);
            $this->renewCsrfToken();
            header('location: /');
        } catch (\Exception $e) {
            $this->htmlError($e->getMessage());
        }
    }

}
