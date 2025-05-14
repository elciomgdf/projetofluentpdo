<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Models\UserModel;
use App\Services\UserService;
use App\Traits\MailTrait;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Validators\UserValidator;

class UserController extends RestrictedController
{

    use ResponseTrait, RequestTrait, MailTrait;

    /**
     * Pesquisa
     * @return void
     */
    public function search(): void
    {
        try {

            $this->json((new UserService())->search($this->queryParams()));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Retorna os dados de um usuário
     * @param $id
     * @return void
     */
    public function return($id): void
    {
        try {

            $id = $this->decode($id);

            if (empty($id)) {
                throw new \Exception("ID não informado", HttpStatus::BAD_REQUEST);
            }

            $model = new UserModel();
            $model->find($id);

            if (empty($model->getId())) {
                throw new \Exception("Usuário não encontrado", HttpStatus::NOT_FOUND);
            }

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($model->getId())]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Atualiza os dados de um usuário
     * @param $id
     * @return void
     */
    public function update($id): void
    {
        try {

            $id = $this->decode($id);

            if (empty($id)) {
                throw new \Exception("ID não informado", HttpStatus::BAD_REQUEST);
            }

            $data = UserValidator::validate($this->inputs(), $id);

            $user = (new UserService())->save($data, $id);

            $this->json(array_merge($user->toArray(), ['encoded_id' => $this->encode($id)]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

}