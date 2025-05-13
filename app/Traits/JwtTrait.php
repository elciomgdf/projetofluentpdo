<?php

namespace App\Traits;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Trai criado para as ações relativas ao token JWT
 */
trait JwtTrait
{
    private function getJwtSecret(): string
    {
        return $_ENV['APP_SECRET'] ?? 'chave_nada_segura';
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {

        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        return substr($authHeader, 7);
    }

    /**
     * Gera um Token
     * @param array $payload
     * @return string
     */
    public function generateJwt(array $payload): string
    {
        return JWT::encode($payload, $this->getJwtSecret(), 'HS256');
    }

    /**
     * Valida o Token
     * @param string $token
     * @return array|null
     * @throws \Exception
     */
    public function validateJwt(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->getJwtSecret(), 'HS256'));
            return (array)$decoded;
        } catch (ExpiredException $e) {
            throw new \Exception('Token expirado');
        } catch (\Exception $e) {
            throw new \Exception('Token inválido');
        }
    }
}
