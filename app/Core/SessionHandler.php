<?php

namespace App\Core;

use App\Traits\DataBaseTrait;
use SessionHandlerInterface;

class SessionHandler implements SessionHandlerInterface
{
    use DataBaseTrait;

    public function open($path, $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read($id): string
    {
        $row = $this->db()->from('user_sessions')->where('id', $id)->fetch();
        return $row['data'] ?? '';
    }

    public function write($id, $data): bool
    {
        try {

            if (empty($data)) {
                return true; // Evita salvar sessão vazia
            }

            $ip = $_SERVER['REMOTE_ADDR'] ?? null;
            $agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

            $this->db()->delete('user_sessions')->where('id', $id)->execute();

            $this->db()->insertInto('user_sessions')->values([
                'id' => $id,
                'data' => $data,
                'ip_address' => $ip,
                'user_agent' => $agent,
                'last_activity' => date('Y-m-d H:i:s')
            ])->execute();

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }


    public function destroy($id): bool
    {
        return (bool) $this->db()
            ->delete('user_sessions')
            ->where('id', $id)
            ->execute();
    }

    public function gc($max_lifetime): int|false
    {
        return $this->db()
            ->delete('user_sessions')
            ->where('last_activity < DATE_SUB(NOW(), INTERVAL ? SECOND)', $max_lifetime)
            ->execute();
    }
}
