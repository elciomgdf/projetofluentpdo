<?php

namespace App\Validators;

use App\Constants\HttpStatus;
use App\Exceptions\ValidationException;
use App\Models\Model;
use App\Models\TaskCategoryModel;

/**
 * Classe de Validação, ela avalia o que chega. Separa o que pode passar e valida os campos.
 */
class Validator
{

    /**
     * @param array $errors
     * @return void
     * @throws ValidationException
     */
    public static function throwErrors(array $errors)
    {

        if ($errors) {

            $errorMessage = array_values($errors)[0][0];

            $extraErrors = 0;

            array_map(function ($error) use (&$extraErrors) {
                $extraErrors += count($error);
            }, $errors);

            $extraErrors--;

            if ($extraErrors > 1) {
                $errorMessage .= " e mais $extraErrors erros";
            } else if ($extraErrors) {
                $errorMessage .= " e mais um erro";
            }

            throw new ValidationException($errorMessage, HttpStatus::UNPROCESSABLE_ENTITY, $errors);

        }

    }

    /**
     * Filtra os campos válidos
     * @param array $data
     * @param Model $model
     * @return array
     */
    public static function validFields(array $data, Model $model, array $allowedFields = [])
    {
        $validated = [];
        if ($data) {
            $fieldsAlloweds = $model->getFields(true);
            foreach ($data as $field => $value) {
                if (in_array($field, $fieldsAlloweds)) {
                    $validated[$field] = $value;
                } elseif (in_array($field, $allowedFields)) {
                    $validated[$field] = $value;
                }
            }
        }
        return $validated;
    }

    /**
     * @param $validated
     * @return mixed
     */
    public static function clearHtml($validated) {
        if ($validated) {
            foreach ($validated as $key => $value) {
                if (is_string($value)) {
                    $validated[$key] = trim(strip_tags($value));
                }
            }
        }
        return $validated;
    }

}
