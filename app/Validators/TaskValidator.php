<?php

namespace App\Validators;

use App\Models\TaskCategoryModel;
use App\Models\TaskModel;
use App\Models\UserModel;

/**
 * Classe de Validação, ela avalia o que chega. Separa o que pode passar e valida os campos.
 */
class TaskValidator extends Validator
{

    /**
     * Valida os dados de entrada da Tarefa
     * @param array $data
     * @param int|null $id
     * @return array
     * @throws \App\Exceptions\ValidationException
     * @throws \Envms\FluentPDO\Exception
     */
    public static function validate(array $data, int $id = null): array
    {

        $errors = [];

        $model = new TaskModel();

        $validated = self::validFields($data, $model);

        $validated = self::clearHtml($validated);

        if (!empty($validated['title']) && strlen($validated['title']) > 100) {
            $errors['title'][] = 'Título deve ter até 100 caracteres';
        }

        if (!empty($validated['description'])) {
            if (strlen($validated['description']) > 1000) {
                $errors['description'][] = 'Descrição deve ter até 1000 caracteres';
            }
        }

        if (empty($id)) {

            if (empty($validated['due_date'])) {
                $errors['due_date'][] = 'A data de previsão da tarefa é obrigatória';
            }

            if (empty($validated['title'])) {
                $errors['title'][] = 'Título é obrigatório';
            }
            $validated['status'] = $validated['status'] ?? 'Pendente';
            $validated['priority'] = $validated['priority'] ?? 'Média';

        }

        if (!empty($validated['user_id'])) {
            if (empty((new UserModel())->find($validated['user_id']))) {
                $errors['user_id'][] = 'Usuário não encontrado';
            }
        }

        if (!empty($validated['category_id'])) {
            if (empty((new TaskCategoryModel())->find($validated['category_id']))) {
                $errors['category_id'][] = 'Categoria não encontrada';
            }
        }

        if (!empty($validated['due_date'])) {
            if (!isValidDate($validated['due_date'])) {
                $errors['due_date'][] = 'A data de previsão da tarefa precisa ser uma data válida no formato YYYY-MM-DD';
            }
        }

        if (!empty($validated['priority'])) {
            if (!in_array($validated['priority'], [TaskModel::PRIORIDADE_BAIXA, TaskModel::PRIORIDADE_MEDIA, TaskModel::PRIORIDADE_ALTA])) {
                $errors['priority'][] = 'As prioridades permitidas são Alta, Média e Baixa';
            }
        }

        if (!empty($validated['status'])) {
            if (!in_array($validated['status'], [TaskModel::STATUS_EM_ANDAMENTO, TaskModel::STATUS_COMPLETA, TaskModel::STATUS_PENDENTE])) {
                $errors['status'][] = 'Os status permitidos são Em Andamento, Pendente e Completa';
            }
        }

        self::throwErrors($errors);

        return $validated;

    }
}
