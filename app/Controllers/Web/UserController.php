<?php

namespace App\Controllers\Web;

use App\Models\UserModel;
use App\Services\UserService;
use App\Validators\UserValidator;

class UserController extends Controller
{

    /**
     * Exibe um formulário para alteração dos dados
     * @return void
     */
    public function edit(): void
    {
        try {

            $model = new UserModel();
            $model->find($this->session('user_id'));
            $data = $model->toArray();
            $this->view('profile/edit', $data);

        } catch (\Exception $e) {
            $this->htmlError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Salva uma Tarefa
     * @return void
     */
    public function save(): void
    {
        try {

            $id = $this->session('user_id');

            $data = UserValidator::validate($this->inputs(), $id);

            $model = (new UserService())->save($data, $id);

            foreach ($model->toArray() as $key => $value) {
                $this->setSession("user_$key", $value);
            }

            $this->json(['type' => 'success', 'message' => 'Dados salvos com sucesso']);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

}