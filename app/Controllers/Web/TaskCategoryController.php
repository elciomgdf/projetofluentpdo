<?php

namespace App\Controllers\Web;

use App\Constants\HttpStatus;
use App\Constants\Response;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Models\TaskCategoryModel;
use App\Models\TaskModel;
use App\Services\TaskCategoryService;
use App\Validators\TaskCategoryValidator;

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
                    throw new \Exception("Categoria não encontrada", HttpStatus::NOT_FOUND);
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

            $data = TaskCategoryValidator::validate($this->inputs(), $id);

            $model = (new TaskCategoryService())->save($data, $id);

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