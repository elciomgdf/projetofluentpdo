<?php


namespace App\Traits;

trait SessionTrait
{
    /**
     * Inicia a sessão se ainda não estiver iniciada.
     */
    protected function ensureSessionStarted(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Retorna um valor da sessão
     */
    public function session(string $key, $default = null)
    {
        $this->ensureSessionStarted();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Define um valor na sessão
     */
    public function setSession(string $key, $value): void
    {
        $this->ensureSessionStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Remove um valor da sessão
     */
    public function unsetSession(string $key): void
    {
        $this->ensureSessionStarted();
        unset($_SESSION[$key]);
    }

    /**
     * Retorna todos os dados da sessão
     */
    public function allSession(): array
    {
        $this->ensureSessionStarted();
        return $_SESSION;
    }

    /**
     * Destroi a sessão inteira
     */
    public function destroySession(): void
    {
        $this->ensureSessionStarted();
        session_destroy();
        $_SESSION = [];
    }

}
