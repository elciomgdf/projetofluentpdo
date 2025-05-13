<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo escapeString($title ?? '') ?? $_ENV['APP_NAME'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.png">
    <link href="/assets/css/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/assets/css/base.css" rel="stylesheet"/>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/funcoes.js"></script>
</head>
<body class="bg-body-tertiary">

<div class="d-flex flex-column flex-md-row justify-content-evenly align-items-center vh-100 w-100 main-content-bg">
    <div class='w-100 d-none d-md-flex login-image'></div>
    <div class='w-100 h-100 d-flex justify-content-center align-items-center main-content'>
        <!-- Dentro da sua estrutura existente -->
        <div class='w-100 d-flex flex-column justify-content-center align-items-center px-3'>
            <h2 class="mb-4 text-center"><?= $_ENV['APP_NAME'] ?></h2>

            <div class="w-100 max-width-400">
                <form id="loginForm" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary" id="btn-submit">Entrar</button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/recover-password" id="recover">Esqueci a senha</a>
                        <a href="/sign-up" target="_self" id="register">Cadastrar</a>
                    </div>
                </form>

                <div id="error" class="alert alert-danger d-none w-100"></div>

            </div>

            <div class="row pt-5">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        Você também pode consumir este app via API seguindo a documentação em: <a href="http://localhost:8082" target="_blank">http://localhost:8082</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<script>
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();

        $('#error').addClass('d-none');
        $('#btn-submit').prop('disabled', true).text('Autenticando...');

        $.ajax({
            url: '/auth/login',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({email, password}),
            success: function (res) {
                if (res.id) {
                    return location.replace('/dashboard');
                }
                $('#btn-submit').prop('disabled', false).text('Entrar');
            },
            error: function (xhr) {
                const error = xhr.responseJSON?.message || 'Erro ao tentar fazer login.';
                $('#error').text(error).removeClass('d-none');
                $('#btn-submit').prop('disabled', false).text('Entrar');
            }
        });
    });

</script>
</body>
</html>
