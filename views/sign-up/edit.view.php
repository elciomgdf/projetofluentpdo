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
    <div class='w-100 d-none d-md-flex sign-image'></div>
    <div class='w-100 h-100 d-flex justify-content-center align-items-center main-content'>

        <div class='w-100 d-flex flex-column justify-content-center align-items-center px-3'>
            <h2 class="mb-4 text-center"><?= $_ENV['APP_NAME'] ?></h2>

            <div class="w-100 max-width-400">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Cadastre-se
                    </div>
                    <div class="card-body">
                        <form id="userForm" method="post" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">

                            <!-- Campo fake para burlar autocomplete do Chrome -->
                            <input type="text" class="d-none" name="fake-user" id="fake-user" autocomplete="username">
                            <input type="password" class="d-none" name="fake-pass" id="fake-pass" autocomplete="current-password">

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="name" class="form-label">Nome completo</label>
                                        <input type="text" value="Elcio Mauro" class="form-control" id="name" name="name" required maxlength="100" autocomplete="off">
                                        <div class="invalid-feedback" id="error_name"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" value="elciomgdf@gmail.com" class="form-control" id="email" name="email" required maxlength="150" autocomplete="off">
                                        <div class="invalid-feedback" id="error_email"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="password" class="form-label">Senha</label>
                                        <input type="password" value="homologa" class="form-control" id="password" name="password" required minlength="6" autocomplete="new-password">
                                        <div class="invalid-feedback" id="error_password"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div id="message" class="alert text-center d-none" role="alert"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-link me-auto" href="/" role="button">Voltar</a>
                                        <button id="btn-submit" type="submit" class="btn btn-success">Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                            <?= $this->csrfTokenInput() ?>
                        </form>

                    </div>
                </div>
                <script>
                    $('#userForm').on('submit', function (e) {
                        e.preventDefault();
                        limpaErros();
                        $('#btn-submit').prop('disabled', true).text('Cadastrando...');
                        const formData = $(this).serialize();
                        $.ajax({
                            url: '/sign-up/create',
                            method: 'POST',
                            data: formData,
                            dataType: "json",
                            success: function (res) {
                                $('#message').text('Usuário cadastrado com sucesso!')
                                    .removeClass('alert-danger d-none')
                                    .addClass('alert-success');
                                $('#btn-submit').text('Redirecionando...');

                                if (res.id) {
                                    setTimeout(function () {
                                        location.replace('/dashboard');
                                    }, 1000);
                                }

                            },
                            error: function (xhr) {
                                $('#btn-submit').prop('disabled', false).text('Cadastrar');
                                const msg = xhr.responseJSON?.message || 'Erro ao cadastrar usuário.';
                                const resposta = xhr.responseJSON;
                                if (resposta?.errors) {
                                    exibeErros(resposta.errors);
                                }
                                $('#message').text(msg).removeClass('alert-success d-none')
                                    .addClass('alert-danger');
                            }
                        });
                    });
                </script>
            </div>
        </div>

    </div>
</div>
</body>
</html>
