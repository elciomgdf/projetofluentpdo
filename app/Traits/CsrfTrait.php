<?php


namespace App\Traits;

use App\Exceptions\InvalidCsrfTokenException;

trait CsrfTrait
{
    use SessionTrait;

    /**
     * Verifica se o Token bate com o salvo em sessão
     * @param string $token
     * @return void
     * @throws InvalidCsrfTokenException
     */
    public function checkCsrfToken(string $token): void
    {
        if (!hash_equals($this->session('csrf_token') ?? '', $token)) {
            throw new InvalidCsrfTokenException("Falha de verificação CSRF. Atualize a página e tente novamente.");
        }
    }

    /**
     * Verifica se o Token presente no Header é válido
     * @return void
     * @throws InvalidCsrfTokenException
     */
    public function checkHeaderCsrfToken(): void
    {
        $this->checkCsrfToken($this->getCsrfTokenFromHeader());
    }

    /**
     * Renova o Token
     * @return void
     * @throws \Random\RandomException
     */
    public function renewCsrfToken(): void
    {
        $this->setSession('csrf_token', bin2hex(random_bytes(32)));
    }

    /**
     * Retorna o Token do Header
     * @return string
     */
    public function getCsrfTokenFromHeader(): string
    {
        return $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    }

    public function csrfTokenInput(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . $this->session('csrf_token') . '">';
    }

}
