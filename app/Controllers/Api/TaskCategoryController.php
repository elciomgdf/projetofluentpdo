<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Models\TaskCategoryModel;
use App\Models\TaskModel;
use App\Services\TaskCategoryService;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Validators\TaskCategoryValidator;

class TaskCategoryController extends RestrictedController
{

    use ResponseTrait, RequestTrait;

    /**
     * Lista todas os registros
     * @return void
     */
    public function all(): void
    {
        try {

            $this->json((new TaskCategoryService())->all($this->queryParam('limit', 1000)));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Pesquisa
     * @return void
     */
    public function search(): void
    {
        try {

            $this->json((new TaskCategoryService())->search($this->queryParams()));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Retorna um registro
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

            $model = new TaskCategoryModel();
            $model->find($id);

            if (empty($model->getId())) {
                throw new \Exception("Categoria não encontrada", HttpStatus::NOT_FOUND);
            }

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($model->getId())]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Cadastra um novo registro
     * @return void
     */
    public function create(): void
    {
        try {

            $data = TaskCategoryValidator::validate($this->inputs());

            $model = (new TaskCategoryService())->save($data);

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($model->getId())]), HttpStatus::CREATED);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Atualiza um registro
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

            $data = TaskCategoryValidator::validate($this->inputs(), $id);

            $model = (new TaskCategoryService())->save($data, $id);

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($id)]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Exclui um registro da tabela
     * @param $encodedId
     * @return void
     */
    public function delete($encodedId): void
    {
        try {

            $id = $this->decode($encodedId);

            if ($id === 1) {
                throw new ValidationException("A Categoria geral não pode ser excluída");
            }

            if (empty($id)) {
                throw new NotFoundException("Registro não encontrado");
            }

            if ((new TaskModel())->findOneBy(["category_id" => $id])) {
                throw new \Exception("Não é possível excluir uma categoria que esteja sendo usada");
            };

            $model = new TaskCategoryModel();
            $deleted = $model->delete($id);

            if (empty($deleted)) {
                throw new NotFoundException("Registro não encontrado!");
            }

            $this->json(['type' => Response::SUCCESS, 'message' => 'Registro excluído com sucesso']);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

}