<?php
    $title = "Dashboard";
    include_once "includes/header.view.php"
?>
<div class="container my-4">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Bem-vindo ao <?= $_ENV['APP_NAME'] ?>!</h4>
        <p class="mb-2">
            Este painel foi desenvolvido para oferecer uma gestão simples, intuitiva e segura de tarefas e categorias.
            Utilizando <strong>PHP 8.1</strong>, <strong>Bootstrap 5</strong>, <strong>Jquery</strong> e consultas otimizadas com <strong><?= $_ENV['APP_NAME'] ?></strong>,
            você tem acesso a uma experiência fluida tanto via Web quanto via API autenticada por token.
        </p>
        <p class="mb-2">
            As ações são protegidas por <code>middleware</code> de sessão e rate limit, garantindo controle e segurança para seu ambiente.
        </p>
        <hr>
        <p class="mb-0">Use o menu acima para navegar entre as funcionalidades disponíveis. Boas tarefas!</p>
    </div>
</div>

<?php
    include_once "includes/footer.view.php"
?>
