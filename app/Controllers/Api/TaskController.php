<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Exceptions\NotFoundException;
use App\Models\TaskModel;
use App\Services\TaskService;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Validators\TaskValidator;

class TaskController extends RestrictedController
{

    use ResponseTrait, RequestTrait;

    /**
     * Pesquisa Tarefas
     * @return void
     */
    public function search(): void
    {
        try {

            $data = $this->queryParams();

            $data['user_id'] = $this->getUser()->getId();

            $this->json((new TaskService())->search($data));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Retorna uma Tarefa
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

            $model = new TaskModel();
            $model->findOneBy(['id' => $id, 'user_id' => $this->getUser()->getId()]);

            if (empty($model->getId())) {
                throw new NotFoundException("Tarefa não encontrada");
            }

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($model->getId())]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Cria uma nova Tarefa
     * @return void
     */
    public function create(): void
    {
        try {

            $data = TaskValidator::validate($this->inputs());

            $data['user_id'] = $this->getUser()->getId();

            $model = (new TaskService())->save($data);

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($model->getId())]), HttpStatus::CREATED);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Atualiza uma Tarefa
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

            $data = TaskValidator::validate($this->inputs(), $id);

            $data['user_id'] = $this->getUser()->getId();

            $model = (new TaskService())->save($data, $id);

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($id)]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Exclui uma Tarefa
     * @param $encodedId
     * @return void
     */
    public function delete($encodedId): void
    {
        try {

            $id = $this->decode($encodedId);

            if (empty($id)) {
                throw new NotFoundException("Registro não encontrado");
            }

            $model = new TaskModel();
            $model->findOneBy(['id' => $id, 'user_id' => $this->getUser()->getId()]);
            if (!empty($model->getId())) {
                $deleted = $model->delete($id);
            }

            if (empty($deleted)) {
                throw new NotFoundException("Registro não encontrado!");
            }

            $this->json(['type' => Response::SUCCESS, 'message' => 'Registro excluído com sucesso']);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

}