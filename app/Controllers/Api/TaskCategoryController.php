<?php

namespace App\Controllers\Api;

use App\Constants\HttpStatus;
use App\Models\TaskCategoryModel;
use App\Services\TaskCategoryService;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Validators\TaskCategoryValidator;

class TaskCategoryController extends RestrictedController
{

    use ResponseTrait, RequestTrait;

    /**
     * Lista todas as Categorias
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
     * Pesquisa categorias
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
     * Retorna uma Categoria
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
     * Cadastra uma nova Categoria
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
     * Atualiza uma Categoria
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

}