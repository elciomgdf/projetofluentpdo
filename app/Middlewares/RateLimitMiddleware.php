<?php

namespace App\Middlewares;

class RateLimitMiddleware
{
    protected int $limit = 60; // requisições
    protected int $window = 60; // segundos

    public function handle(): void
    {

        // Arquivo temporário simples como "cache"
        $file = sys_get_temp_dir() . '/ratelimit_' . md5($_SERVER['REMOTE_ADDR'] ?? 'unknown');

        $requests = [];

        if (file_exists($file)) {
            $requests = json_decode(file_get_contents($file), true) ?? [];
            $requests = array_filter($requests, fn($time) => $time >= (time() - $this->window));
        }

        if (count($requests) >= $this->limit) {
            http_response_code(429);
            echo json_encode(['error' => 'Limite de requisições excedido. Tente novamente mais tarde.']);
            exit;
        }

        $requests[] = time();
        file_put_contents($file, json_encode($requests));
    }
}
