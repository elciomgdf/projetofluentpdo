<?php

namespace App\Services;

use App\Traits\DataBaseTrait;
use App\Traits\EncodeTrait;
use App\Traits\JwtTrait;
use App\Traits\MailTrait;
use App\Traits\SessionTrait;

class Service
{

    use JwtTrait, EncodeTrait, MailTrait, SessionTrait, DataBaseTrait;

    /**
     * Verifica se as tabelas foram criadas na base de dados
     * @return void
     */
    public function checkDatabase(): void
    {

        $tables = [
            'users', 'user_sessions', 'user_tokens', 'tasks', 'task_categories',
        ];

        $errors = [];

        foreach ($tables as $table) {
            try {
                $this->getTable($table);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            echo "As tabelas abaixo não foram encontradas. Para a correta instalação, você pode executar o comando de criação em /databases.<br/>";
            echo implode("<br />", $errors);
            exit;
        }

    }

}