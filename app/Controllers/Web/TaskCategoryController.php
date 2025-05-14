<?php

namespace App\Controllers\Web;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Exceptions\NotFoundException;
use App\Models\TaskCategoryModel;
use App\Services\TaskCategoryService;

class TaskCategoryController extends Controller
{

    /**
     * Tela de pesquisa
     * @return void
     */
    public function search(): void
    {
        try {

            $params = $this->queryParams();

            $data = (new TaskCategoryService())->search($params);

            $this->view('category/search', $data);

        } catch (\Exception $e) {
            $this->htmlError($e->getMessage());
        }
    }

    /**
     * Formulário de alteração/inclusão
     * @param $encodedId
     * @return void
     */
    public function edit($encodedId = null): void
    {
        try {

            $model = new TaskCategoryModel();

            if ($encodedId) {
                $id = $this->decode($encodedId);
                $model->find($id);

                if (empty($model->getId())) {
                    throw new NotFoundException("Categoria não encontrada", HttpStatus::NOT_FOUND);
                }

            }

            $data = $model->toArray();

            $this->view('category/edit', array_merge($data, ['encoded_id' => $encodedId]));

        } catch (\Exception $e) {
            $this->htmlError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Método para salvar os dados. Inclui ou altera.
     * @return void
     */
    public function save(): void
    {
        try {

            $this->checkHeaderCsrfToken();

            $id = $this->decode($this->input('encoded_id'));

            $model = (new TaskCategoryService())->save($this->inputs(), $id);

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($model->getId())]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Exclusão de dados
     * @param $encodedId
     * @return void
     */
    public function delete($encodedId): void
    {
        try {

            $this->checkHeaderCsrfToken();

            (new TaskCategoryService())->delete($this->decode($encodedId));

            $this->json(['type' => Response::SUCCESS, 'message' => 'Registro excluído com sucesso']);

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

}