<?php

namespace App\Core;

use App\Constants\HttpStatus;
use App\Traits\ResponseTrait;

class Router
{

    use ResponseTrait;

    /**
     * Executa a lógica de roteamento com base nas rotas definidas.
     *
     * @param array $routes Array de rotas no formato [path => [Controller, método, verbo HTTP]]
     */
    public function dispatch(array $routes): void
    {
        // Obtém a URI da requisição
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $methodHttp = strtolower($_SERVER['REQUEST_METHOD']);

        foreach ($routes as $pattern => $route) {

            [$controllerClass, $action, $method] = $route;

            $middlewares = $route[3] ?? [];

            // Extrai parâmetros da rota como {id}, {nome}, etc.
            preg_match_all('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', $pattern, $paramNames);

            // Converte padrão para regex
            $regex = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([a-zA-Z0-9_-]+)', $pattern);
            $regex = "#^{$regex}$#";

            // Verifica se a URI bate com a rota
            if (preg_match($regex, $uri, $matches)) {

                // Verifica se o método HTTP é o correto
                if ($methodHttp !== strtolower($method)) {
                    $this->jsonError("Método HTTP não permitido. Você queria usar o " . strtoupper($method) . "?", HttpStatus::METHOD_NOT_ALLOWED);
                }

                array_shift($matches); // Remove o match completo
                $paramMap = array_combine($paramNames[1], $matches);

                // Verifica se o controller e o método existem
                if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
                    $this->jsonError("Controller ou método inválido: {$controllerClass}::{$action}()", HttpStatus::INTERNAL_SERVER_ERROR);
                }

                // Executa os middlewares
                if (isset($middlewares) && is_array($middlewares)) {
                    foreach ($middlewares as $middlewareClass) {
                        if (class_exists($middlewareClass)) {
                            (new $middlewareClass())->handle();
                        }
                    }
                }

                // Instancia o controller e injeta os parâmetros, se suportado
                $controller = new $controllerClass();
                if (method_exists($controller, 'setRouteParams')) {
                    $controller->setRouteParams($paramMap);
                }

                // Executa o método do controller com os parâmetros capturados
                call_user_func_array([$controller, $action], $matches);
                exit;
            }
        }

        $this->jsonError("Rota não encontrada", HttpStatus::NOT_FOUND);

    }
}
