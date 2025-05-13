<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Models\UserModel;
use App\Traits\EncodeTrait;
use App\Traits\JwtTrait;
use App\Traits\MailTrait;

class UserService
{

    use JwtTrait, EncodeTrait, MailTrait;

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

        $fields = (new UserModel())->getFields();

        $orderBy = sanitizeOrderBy($data['order'] ?? 'name', $fields);

        $per_page = $data['per_page'] ?? 10;

        return (new UserModel())->paginate($page, (int)$per_page, $where, $orderBy, $data['direction'] ?? 'ASC');

    }

    /**
     * @param $data
     * @param $id
     * @return UserModel|null
     * @throws \Envms\FluentPDO\Exception
     */
    public function save($data, $id = null)
    {

        $model = new UserModel();
        if ($id) {
            $model->find($id);
            if (empty($model->getId())) {
                throw new NotFoundException("Registro não encontrado");
            }
        }
        $model->fill($data);
        if (!empty($data['password'])) {
            $model->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        }

        $model->save();

        if ($model->getId()) {
            if (empty($id)) {
                $this->sendPassword($model, $data['password'], 'Bem vindo(a) ao ' . $_ENV['APP_NAME']);
            }
        }

        return $model;

    }

    /**
     * @param $email
     * @return UserModel
     * @throws ValidationException
     * @throws \Envms\FluentPDO\Exception
     */
    public function createNewPassword($email): UserModel
    {

        if (empty($email)) {
            throw new ValidationException('O e-mail é Obrigatório');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('E-mail inválido');
        }

        $model = new UserModel();
        $model->findOneBy(['email' => $email]);
        if ($model->getId()) {
            $password = rand(111111, 999999);
            $model->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $model->save();
            $this->sendPassword($model, $password, 'Nova senha de acesso ao ' . $_ENV['APP_NAME']);
        }
        return $model;

    }

    /**
     * Envia um e-mail com a nova senha
     * @param UserModel $model
     * @param $password
     * @param $subject
     * @return void
     */
    public function sendPassword(UserModel $model, $password, $subject = 'Cadastro'): void
    {

        $emailBody = <<<EMAIL
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bem-vindo ao {$_ENV['APP_NAME']}</title>
</head>
<body style="margin:0; padding:0; background:#f5f5f5; font-family:Arial, sans-serif;">
  <table width="100%" bgcolor="#f5f5f5" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <!-- container principal -->
        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; margin:20px 0; border-radius:8px; overflow:hidden;">
          
          <!-- header -->
          <tr>
            <td style="background:#0051ba; padding:20px; text-align:center;color: #ffffff">
              <strong>{$_ENV['APP_NAME']}</strong>
            </td>
          </tr>
          
          <!-- corpo -->
          <tr>
            <td style="padding:30px; color:#333333; line-height:1.5;">
              <h1 style="font-size:22px; margin:0 0 20px;">Olá, {$model->getName()}!</h1>
              <p style="font-size:16px; margin:0 0 20px;">
                Seja muito bem-vindo ao {$_ENV['APP_NAME']}. Abaixo estão seus dados de acesso:
              </p>
              
              <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;">
                <tr>
                  <td style="background:#f0f0f0; padding:15px; border-radius:4px;">
                    <p style="margin:0 0 8px;"><strong>E-mail:</strong> {$model->getEmail()}</p>
                    <p style="margin:0;"><strong>Senha:</strong> {$password}</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- rodapé -->
          <tr>
            <td style="background:#fafafa; padding:20px; text-align:center; font-size:12px; color:#999999;">
              © <?= date('Y') ?> {$_ENV['APP_NAME']}. Todos os direitos reservados.<br>
              Rua Exemplo, 123 – Bairro – Cidade/UF – CEP 00000-000<br>
              <a href="{$_ENV['APP_URL']}" style="color:#0051ba; text-decoration:none;">visite nosso site</a>
            </td>
          </tr>
        </table>
        <!-- fim do container -->
      </td>
    </tr>
  </table>
</body>
</html>
EMAIL;

        $this->sendMail($model->getEmail(), $subject, $emailBody);

    }

}