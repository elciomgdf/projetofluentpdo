<?php

namespace App\Controllers\Web;

use App\Constants\HttpStatus;
use App\Services\AuthService;

class AuthController extends Controller
{

    /**
     * Login
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

    public function logout()
    {
        (new AuthService())->logout(true);
        $this->renewCsrfToken();
        header('location: /');
    }

}
