<?php

use App\Controllers\Api\AuthController;
use App\Controllers\Api\SignUpController;
use App\Controllers\Api\TaskCategoryController;
use App\Controllers\Api\TaskController;
use App\Controllers\Api\UserController;
use App\Controllers\Web\IndexController;
use App\Controllers\Web\SignUpController as WebSignUpController;
use App\Controllers\Web\UserController as WebUserController;
use App\Controllers\Web\AuthController as WebAuthController;
use App\Controllers\Web\TaskController as WebTaskController;
use App\Controllers\Web\TaskCategoryController as WebTaskCategoryController;
use App\Middlewares\RateLimitMiddleware;
use App\Middlewares\SessionMiddleware;

$routes = [

    /**
     * Rotas Web (interface do usuário)
     * Autenticadas por sessão e protegidas por middleware
     */
    '' => [IndexController::class, 'index', 'get', [RateLimitMiddleware::class]], // Página inicial
    'auth/login' => [WebAuthController::class, 'login', 'post', [RateLimitMiddleware::class]], // Login de usuário
    'logout' => [WebAuthController::class, 'logout', 'get', [RateLimitMiddleware::class]], // Logout de sessão
    'dashboard' => [IndexController::class, 'dashboard', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Painel principal (requer sessão)

    // Gerenciamento de tarefas via interface Web
    'tasks' => [WebTaskController::class, 'search', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Lista de tarefas
    'task/create' => [WebTaskController::class, 'edit', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Formulário de criação
    'task/{id}/edit' => [WebTaskController::class, 'edit', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Edição de tarefa
    'task/{id}/delete' => [WebTaskController::class, 'delete', 'delete', [SessionMiddleware::class, RateLimitMiddleware::class]], // Exclusão de tarefa
    'task/save' => [WebTaskController::class, 'save', 'post', [SessionMiddleware::class, RateLimitMiddleware::class]], // Salvamento (create/update)

    // Gerenciamento de categorias via interface Web
    'categories' => [WebTaskCategoryController::class, 'search', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Lista de categorias
    'category/create' => [WebTaskCategoryController::class, 'edit', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Formulário de criação
    'category/save' => [WebTaskCategoryController::class, 'save', 'post', [SessionMiddleware::class, RateLimitMiddleware::class]], // Salvamento (create/update)
    'category/{id}/edit' => [WebTaskCategoryController::class, 'edit', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Edição de categoria
    'category/{id}/delete' => [WebTaskCategoryController::class, 'delete', 'delete', [SessionMiddleware::class, RateLimitMiddleware::class]], // Exclusão de categoria

    // Cadastro e recuperação de senha via Web
    'sign-up' => [WebSignUpController::class, 'signUp', 'get', [RateLimitMiddleware::class]], // Criação de conta
    'sign-up/create' => [WebSignUpController::class, 'create', 'post', [RateLimitMiddleware::class]], // Criação de conta
    'recover-password' => [WebSignUpController::class, 'recoverPassword', 'get', [RateLimitMiddleware::class]], // Recuperação de senha
    'recover-password/send' => [WebSignUpController::class, 'sendPassword', 'post', [RateLimitMiddleware::class]], // Recuperação de senha

    // Perfil do usuário autenticado
    'profile' => [WebUserController::class, 'edit', 'get', [SessionMiddleware::class, RateLimitMiddleware::class]], // Página de perfil
    'profile/save' => [WebUserController::class, 'save', 'post', [SessionMiddleware::class, RateLimitMiddleware::class]], // Salva o Perfil

    /**
     * Rotas da API (acesso por token)
     * Projetadas para integrações e consumo por clientes externos
     */

    // Autenticação via API
    'api/auth/login' => [AuthController::class, 'login', 'post', [RateLimitMiddleware::class]], // Autentica e gera token
    'api/auth/logout' => [AuthController::class, 'logout', 'post', [RateLimitMiddleware::class]], // Invalida token

    // Registro de usuário via API (acesso público)
    'api/sign-up' => [SignUpController::class, 'create', 'post', [RateLimitMiddleware::class]],
    'api/recover-password' => [SignUpController::class, 'sendPassword', 'post', [RateLimitMiddleware::class]], // Recuperação de senha

    // Usuários - operações protegidas
    'api/user/search' => [UserController::class, 'search', 'get', [RateLimitMiddleware::class]], // Busca paginada
    'api/user/{id}' => [UserController::class, 'return', 'get', [RateLimitMiddleware::class]], // Detalhes de um usuário
    'api/user/{id}/update' => [UserController::class, 'update', 'put', [RateLimitMiddleware::class]], // Atualização de dados

    // Categorias - operações CRUD básicas
    'api/category/create' => [TaskCategoryController::class, 'create', 'post', [RateLimitMiddleware::class]],
    'api/category/search' => [TaskCategoryController::class, 'search', 'get', [RateLimitMiddleware::class]],
    'api/category/{id}' => [TaskCategoryController::class, 'return', 'get', [RateLimitMiddleware::class]],
    'api/category/{id}/update' => [TaskCategoryController::class, 'update', 'put', [RateLimitMiddleware::class]],
    'api/category/{id}/delete' => [TaskCategoryController::class, 'delete', 'delete', [RateLimitMiddleware::class]], // Exclusão de categoria
    'api/categories' => [TaskCategoryController::class, 'all', 'get', [RateLimitMiddleware::class]], // Retorna todas as categorias

    // Tarefas - operações CRUD básicas
    'api/task/create' => [TaskController::class, 'create', 'post', [RateLimitMiddleware::class]],
    'api/task/search' => [TaskController::class, 'search', 'get', [RateLimitMiddleware::class]],
    'api/task/{id}' => [TaskController::class, 'return', 'get', [RateLimitMiddleware::class]],
    'api/task/{id}/update' => [TaskController::class, 'update', 'put', [RateLimitMiddleware::class]],
    'api/task/{id}/delete' => [TaskController::class, 'delete', 'delete', [RateLimitMiddleware::class]],

];
