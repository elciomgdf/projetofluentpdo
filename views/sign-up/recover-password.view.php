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
    <div class='w-100 d-none d-md-flex recover-image'></div>
    <div class='w-100 h-100 d-flex justify-content-center align-items-center main-content'>
        <!-- Dentro da sua estrutura existente -->
        <div class='w-100 d-flex flex-column justify-content-center align-items-center px-3'>
            <h2 class="mb-4 text-center"><?= $_ENV['APP_NAME'] ?></h2>

            <div class="w-100 max-width-400">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Recuperar Senha
                    </div>
                    <div class="card-body">
                        <form id="userForm" method="post">

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" required maxlength="150">
                                        <div class="invalid-feedback" id="error_email"></div>
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
                                        <button id="btn-submit" type="submit" class="btn btn-success">Recuperar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-5">
                                <div class="col-12">
                                    <div class="alert alert-info" role="alert">
                                        Veja seus "e-mails" em <a href="http://localhost:8025" target="_blank">http://localhost:8025</a>
                                    </div>
                                </div>
                            </div>
                            <?= $this->csrfTokenInput() ?>
                        </form>

                    </div>
                </div>
                <script>

                    $(document).ready(function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="csrf_token"]').val()
                            }
                        });
                        $('#userForm').on('submit', function (e) {
                            e.preventDefault();
                            limpaErros();
                            $('#btn-submit').prop('disabled', true).text('Cadastrando...');
                            const formData = $(this).serialize();
                            $.ajax({
                                url: '/recover-password/send',
                                method: 'POST',
                                data: formData,
                                dataType: "json",
                                success: function (res) {
                                    $('#message').text(res.message)
                                        .removeClass('alert-danger d-none')
                                        .addClass('alert-success');
                                    $('#btn-submit').prop('disabled', false).text('Recuperar Senha');
                                },
                                error: function (xhr) {
                                    $('#btn-submit').prop('disabled', false).text('Recuperar Senha');
                                    const msg = xhr.responseJSON?.message || 'Erro ao recuperar a senha.';
                                    const resposta = xhr.responseJSON;
                                    if (resposta?.errors) {
                                        exibeErros(resposta.errors);
                                    }
                                    $('#message').text(msg).removeClass('alert-success d-none')
                                        .addClass('alert-danger');
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>

    </div>
</div>
</body>
</html>
