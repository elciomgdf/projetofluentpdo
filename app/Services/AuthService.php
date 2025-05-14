<?php

namespace App\Services;

use App\Constants\HttpStatus;
use App\Models\UserModel;
use App\Models\UserTokenModel;

class AuthService extends Service
{

    /**
     * Efetua o login caso os dados sejam corretos retornando um token que permite o acesso até a validade definida no .env
     * @param $email
     * @param $password
     * @return array
     * @throws \Envms\FluentPDO\Exception
     */
    public function login($email, $password, $session = false)
    {

        $user = new UserModel();
        $dados = $user->findOneBy(['email' => $email]);

        if (!$user->getId() || !$user->getPassword() || !password_verify($password, $user->getPassword())) {
            throw new \InvalidArgumentException('Credenciais inválidas', HttpStatus::UNAUTHORIZED);
        }

        if ($session) {
            foreach ($dados as $key => $value) {
                $this->setSession("user_$key", $value);
            }
            return $user->toArray();
        }

        $encoded_id = $this->encode($dados['id']);

        $payload = [
            'sub' => $encoded_id,
            'iat' => time(),
            'exp' => time() + (3600 * $_ENV['APP_JWT_EXPIRE_HOURS'])
        ];

        $expireAt = (new \DateTime())->setTimestamp($payload['exp'])->format('Y-m-d H:i:s');

        $token = $this->generateJwt($payload);

        $userToken = new UserTokenModel();
        $userToken->setToken($token);
        $userToken->setUser_id($dados['id']);
        $userToken->setStatus(UserTokenModel::VALID);
        $userToken->setDevice(getDeviceName());
        $userToken->setExpire_at($expireAt);
        $userToken->setIp_address($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $userToken->save();

        return ['id' => $encoded_id, 'token' => $token];

    }


    /**
     * Método chamado ao fazer logout. Em uma autenticação com token, ele invalida o token em uma tabela específica.
     * Em uma autenticação por sessão, ele exclui a sessão.
     * @param $session
     * @return bool
     * @throws \Envms\FluentPDO\Exception
     */
    public function logout($session = false)
    {

        if ($session) {
            $this->destroySession();
            return true;
        }

        $token = $this->getToken();

        if ($token) {

            $userToken = new UserTokenModel();
            $userToken->findOneBy(['token' => $token]);
            if ($userToken->getStatus() === UserTokenModel::VALID) {
                $userToken->setStatus(UserTokenModel::INVALID);
                $userToken->setLogged_out_at(date('Y-m-d H:i:s'));
                if ($userToken->save()) {
                    return true;
                };
            }

        }

        return false;

    }

}