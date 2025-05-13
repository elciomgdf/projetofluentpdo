<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\TaskCategoryModel;
use App\Traits\EncodeTrait;
use App\Traits\JwtTrait;
use App\Traits\MailTrait;

class TaskCategoryService
{

    use JwtTrait, EncodeTrait, MailTrait, EncodeTrait;

    /**
     * @param $data
     * @return array
     * @throws \Envms\FluentPDO\Exception
     */
    public function all($limit = 1000)
    {
        return (new TaskCategoryModel())->all((int)$limit, 'name');
    }

    /**
     * @param $data
     * @return array
     * @throws \Envms\FluentPDO\Exception
     */
    public function search($data)
    {

        $page = max(1, $data['page'] ?? 1);

        $where = [];

        if (!empty($data['q'])) {
            $where = ['name like ?' => "%{$data['q']}%"];
        }

        $fields = (new TaskCategoryModel())->getFields();

        $orderBy = sanitizeOrderBy($data['order'] ?? 'name', $fields);

        $per_page = $data['per_page'] ?? 10;

        $data = (new TaskCategoryModel())->paginate($page, (int)$per_page, $where, $orderBy, $data['direction'] ?? 'ASC');

        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $item) {
                $data['items'][$key]['encoded_id'] = $this->encode($item['id']);
            }
        }

        return $data;

    }

    /**
     * @param $data
     * @param $id
     * @return TaskCategoryModel|null
     * @throws \Envms\FluentPDO\Exception
     */
    public function save($data, $id = null): ?TaskCategoryModel
    {

        $model = new TaskCategoryModel();
        if ($id) {
            $model->find($id);
            if (empty($model->getId())) {
                throw new NotFoundException("Registro não encontrado");
            }
        }
        $model->fill($data);

        $model->save();

        return $model;

    }

}