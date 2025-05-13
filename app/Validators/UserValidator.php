<?php

namespace App\Validators;

use App\Constants\HttpStatus;
use App\Exceptions\ValidationException;
use App\Models\UserModel;

/**
 * Classe de Validação, ela avalia o que chega. Separa o que pode passar e valida os campos.
 */
class UserValidator extends Validator
{
    /**
     * Garante a entrada segura dos dados do usuário
     * @param array $data
     * @param $id
     * @return array
     * @throws ValidationException
     * @throws \Envms\FluentPDO\Exception
     */
    public static function validate(array $data, $id = null): array
    {

        $errors = [];

        $model = new UserModel();

        $validated = self::validFields($data, $model, ['password_confirm']);

        $validated = self::clearHtml($validated);

        if (empty($id)) {

            if (empty($validated['name']) || strlen($validated['name']) > 100) {
                $errors['name'][] = 'Nome é obrigatório e deve ter até 100 caracteres';
            }

            if (empty($validated['password'])) {
                $errors['password'][] = 'Senha obrigatória quando se está inserindo um novo registro';
            }

            if (empty($validated['email'])) {
                $errors['password'][] = 'E-mail obrigatório quando se está inserindo um novo registro';
            }

        } else {
            if (!empty($validated['password'])) {
                if (empty($validated['password_confirm'])) {
                    $errors['password_confirm'][] = 'Informe a mesma senha para confirmação';
                }

                if ($validated['password_confirm'] !== $validated['password']) {
                    $errors['password_confirm'][] = 'A senha e a senha de confirmação precisam ter o mesmo valor';
                }
            }
        }

        if (!empty($validated['name'])) {
            if (count(explode(' ', $validated['name'])) === 1) {
                $errors['name'][] = 'Informe o nome e o sobrenome';
            }
            if (strlen($validated['name']) > 100) {
                $errors['name'][] = 'Nome deve ter até 100 caracteres';
            }
        }

        if (!empty($validated['email'])) {
            if (!filter_var($validated['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'][] = 'E-mail inválido';
            }
            if ($model->findOneBy(['email' => $validated['email']], null, ['id' => (int)$id])) {
                $errors['email'][] = 'Este e-mail já está sendo usado em outro cadastro. Use o recuperar senha caso não tenha seus dados de acesso.';
            }
        }

        self::throwErrors($errors);

        return $validated;

    }
}
