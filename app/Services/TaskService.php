<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Models\TaskModel;
use App\Validators\TaskValidator;

class TaskService extends Service
{

    /**
     * @param $data
     * @return array
     * @throws \Envms\FluentPDO\Exception
     */
    public function search($data)
    {

        $page = max(1, $data['page'] ?? 1);

        $where = [];

        $termo = isset($data['q']) ? trim($data['q']) : '';

        if ($termo !== '') {
            $like = "%{$termo}%";
            $where = [
                '(title LIKE ? OR description LIKE ? OR status LIKE ? OR priority LIKE ?)' => [
                    $like, $like, $like, $like
                ]
            ];
        }

        if (!empty($data['status'])) {
            $where['status'] = $data['status'];
        }

        if (!empty($data['priority'])) {
            $where['priority'] = $data['priority'];
        }

        if (!empty($data['category_id'])) {
            $where['category_id'] = $data['category_id'];
        }

        if (empty($data['user_id'])) {
            throw new ValidationException("O Usuário é obrigatório");
        }

        $where['user_id'] = $data['user_id'];

        $fields = (new TaskModel())->getFields();

        $orderBy = sanitizeOrderBy($data['order'] ?? 'title', $fields);

        $per_page = $data['per_page'] ?? 7;

        $data = (new TaskModel())->paginate($page, (int)$per_page, $where, $orderBy, $data['direction'] ?? 'ASC');

        $categorias = (new TaskCategoryService())->all();

        $categoria = array_column($categorias, null, 'id');

        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $item) {
                $data['items'][$key]['encoded_id'] = $this->encode($item['id']);
                $data['items'][$key]['category'] = $categoria[$item['category_id']]['name'] ?? null;
            }
        }

        return $data;

    }

    /**
     * @param $data
     * @param $id
     * @return TaskModel|null
     * @throws \Envms\FluentPDO\Exception
     */
    public function save($data, $id = null): ?TaskModel
    {

        $data = TaskValidator::validate($data, $id);

        $model = new TaskModel();
        if ($id) {

            if (empty($data['user_id'])) {
                throw new ValidationException("O Usuário é obrigatório", null, ['user_id' => 'O Usuário é obrigatório']);
            }

            $model->findOneBy(['id' => $id, 'user_id' => $data['user_id']]);

            if (empty($model->getId())) {
                throw new NotFoundException("Registro não encontrado");
            }

        }

        /**
         * A Atualização deve ocorrer com a informação do ID
         */
        unset($data['id']);

        $model->fill($data);

        $model->save();

        return $model;

    }

    public function delete(int $id = null, string $table = null): bool
    {

    }
}