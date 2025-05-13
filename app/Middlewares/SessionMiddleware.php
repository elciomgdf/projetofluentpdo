<?php

namespace App\Middlewares;

use App\Traits\ResponseTrait;

class SessionMiddleware
{

    use ResponseTrait;
    public function handle(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->htmlError('Você não está autenticado');
        }
    }
}
