<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo escapeString($title ?? '') ?? $_ENV['APP_NAME'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.png">
    <link href="/assets/css/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/js/toastr/toastr.min.css"/>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/toastr/toastr.min.js"></script>
    <script src="/assets/js/funcoes.js"></script>
</head>
<body class="bg-body-tertiary">

<header class="py-2 mb-0 text-bg-dark border-bottom">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-between">
            <a href="/dashboard" class="d-flex align-items-center mb-2 mb-lg-0  text-white text-decoration-none">
                <i class="bi bi-house"></i> <?=$_ENV['APP_NAME'] ?>
            </a>
            <ul class="nav col-12 col-lg-auto ms-lg-3 me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/tasks" class="nav-link px-2 text-white text-decoration-none">Tarefas</a></li>
                <li><a href="/categories" class="nav-link px-2 text-white text-decoration-none">Categorias</a></li>
            </ul>
            <ul class="nav col-12 col-lg-auto me-lg-3 ms-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="http://localhost:8082" target="_documentacao" class="nav-link px-2 text-white text-decoration-none">Documentação API</a></li>
            </ul>
            <div class="dropdown text-end">
                <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo escapeString($this->session("user_name")); ?>
                </a>
                <ul class="dropdown-menu text-small">
                    <li><a class="dropdown-item" href="/profile">Meus Dados</a></li>
                    <li><a class="dropdown-item" href="http://localhost:8025" target="_emails">Meus E-mail</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="/logout">Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="container-fluid border-bottom mb-3 py-2 bg-body shadow-sm">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= escapeString($title) ?? ''?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir este item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-delete">Excluir</button>
            </div>
        </div>
    </div>
</div>