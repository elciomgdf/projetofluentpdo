<?php

namespace App\Controllers\Web;

use App\Constants\Response;
use App\Exceptions\NotFoundException;
use App\Models\TaskModel;
use App\Services\TaskCategoryService;
use App\Services\TaskService;

class TaskController extends Controller
{

    /**
     * Pesquisa as Tarefas
     * @return void
     */
    public function search(): void
    {
        try {

            $params = $this->queryParams();

            $categorias = (new TaskCategoryService())->all();

            $data = (new TaskService())->search(array_merge($params, ['user_id' => $this->session('user_id')]));

            $this->view('task/search', array_merge($data, ['categorias' => $categorias]));

        } catch (\Exception $e) {
            $this->jsonExceptions($e);
        }
    }

    /**
     * Exibe um formulário para inclusão ou alteração dos dados
     * @param $encodedId
     * @return void
     */
    public function edit($encodedId = null): void
    {
        try {

            $model = new TaskModel();

            if ($encodedId) {
                $id = $this->decode($encodedId);
                $model->findOneBy(['id' => $id, 'user_id' => $this->session('user_id')]);
                if (empty($model->getId())) {
                    throw new NotFoundException("Tarefa não encontrada");
                }
            }

            $data = $model->toArray();

            $categorias = (new TaskCategoryService())->all();

            $this->view('task/edit', array_merge($data, ['encoded_id' => $encodedId], ['categorias' => $categorias]));

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

            $this->checkHeaderCsrfToken();

            $id = $this->decode($this->input('encoded_id'));

            $data = $this->inputs();

            $data['user_id'] = $this->session('user_id');

            $model = (new TaskService())->save($data, $id);

            $this->json(array_merge($model->toArray(), ['encoded_id' => $this->encode($model->getId())]));

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

            $this->checkHeaderCsrfToken();

            $id = $this->decode($encodedId);

            if (empty($id)) {
                throw new NotFoundException("Registro não encontrado");
            }

            $model = new TaskModel();
            $model->findOneBy(['id' => $id, 'user_id' => $this->session('user_id')]);
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