<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Models\UserModel;
use App\Models\UserTokenModel;
use App\Traits\EncodeTrait;
use App\Traits\JwtTrait;
use App\Traits\ResponseTrait;

/**
 * Classe criada para restringir o acesso às controllers que dependem de um token de acesso
 */
class RestrictedController
{

    use JwtTrait, ResponseTrait, EncodeTrait;

    protected UserModel $user;

    public function __construct()
    {
        $this->user = $this->getAuthenticatedUser();
    }

    /**
     * @return UserModel
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retorna o usuário autenticado via token
     * @return UserModel|null
     */
    private function getAuthenticatedUser()
    {

        try {

            $token = $this->getToken();

            if (!$token) {
                throw new \Exception('Token não informado', HttpStatus::UNAUTHORIZED);
            }

            $userToken = new UserTokenModel();
            $userToken->findOneBy(['token' => $token]);

            if (!$userToken->getStatus()) {
                throw new \Exception('Token inexistente', HttpStatus::UNAUTHORIZED);
            }

            if ($userToken->getStatus() === UserTokenModel::INVALID) {
                throw new \Exception('Token cancelado em ' . $userToken->getLogged_out_at(), HttpStatus::UNAUTHORIZED);
            }

            $decoded = $this->validateJwt($token);

            if (!empty($decoded['sub'])) {
                $user = new UserModel();
                $user->find($this->decode($decoded['sub']));
                if ($user->getId()) {
                    return $user;
                }
            }

            throw new \Exception('Token inválido', HttpStatus::UNAUTHORIZED);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }

        return null;
    }

}