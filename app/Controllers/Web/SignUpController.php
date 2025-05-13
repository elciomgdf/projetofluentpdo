<?php

namespace App\Controllers\Web;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Services\AuthService;
use App\Services\UserService;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Validators\UserValidator;

/**
 * Classe para o cadastro do Usuário
 */
class SignUpController extends Controller
{

    /**
     * @return void
     */
    public function signUp(): void
    {
        $this->view('sign-up/edit');
    }

    public function create(): void
    {
        try {

            $this->checkHeaderCsrfToken();

            $data = UserValidator::validate($this->inputs());

            $user = (new UserService())->save($data);

            if ($user->getId()) {
                $auth = new AuthService();
                $auth->login($user->getEmail(), $data['password'], true);
            }

            $this->json($user->toArray(), HttpStatus::CREATED);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }

    }

    /**
     * @return void
     */
    public function recoverPassword(): void
    {
        $this->view('sign-up/recover-password');
    }

    /**
     * @return void
     */
    public function sendPassword(): void
    {
        try {

            $this->checkHeaderCsrfToken();

            (new UserService())->createNewPassword($this->input('email'));

            $this->json(['type' => Response::SUCCESS, 'message' => 'Caso você possua cadastro com o e-mail informado, seus dados de acesso chegarão em instantes.']);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }

    }

}