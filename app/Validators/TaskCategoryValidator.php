<?php

namespace App\Validators;

use App\Models\TaskCategoryModel;

/**
 * Classe de Validação, ela avalia o que chega. Separa o que pode passar e valida os campos.
 */
class TaskCategoryValidator extends Validator
{
    public static function validate(array $data, $id = null): array
    {

        $errors = [];

        $model = new TaskCategoryModel();

        $validated = self::validFields($data, $model);

        $validated = self::clearHtml($validated);

        if (empty($validated['name']) || strlen($validated['name']) > 100) {
            $errors['name'][] = 'Nome é obrigatório e deve ter até 100 caracteres';
        }

        if ($model->findOneBy(['name' => $validated['name']], null, ['id' => (int)$id])) {
            $errors['name'][] = 'Esta Categoria já existe';
        }

        self::throwErrors($errors);

        return $validated;

    }
}
