<?php

$title = "Perfil: {$data['name']}";

include_once __DIR__ . "/../includes/header.view.php"
?>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <?= escapeString($title ?? '') ?>
        </div>
        <div class="card-body">
            <form id="userForm" method="post">

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= escapeString($data['name']) ?? '' ?>" required maxlength="100">
                            <div class="invalid-feedback" id="error_name"></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= escapeString($data['email']) ?? '' ?>" required maxlength="150">
                            <div class="invalid-feedback" id="error_email"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6" autocomplete="new-password">
                            <div class="invalid-feedback" id="error_password"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="password_confirm" class="form-label">Confirmação da Senha</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" minlength="6" autocomplete="new-password">
                            <div class="invalid-feedback" id="error_password_confirm"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><em>*Caso não queira alterar a senha, deixe estes campos vazios.</em></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link me-auto" href="#" onclick="window.goBack()" role="button">Voltar</a>
                            <button id="btn-submit" type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
                <?=$this->csrfTokenInput() ?>
            </form>
        </div>
    </div>

    <script>
        window.onload = function () {
            $('#userForm').on('submit', function (e) {
                e.preventDefault();
                limpaErros();
                $('#btn-submit').prop('disabled', true).text('Salvando...');
                const formData = $(this).serialize();
                $.ajax({
                    url: '/profile/save',
                    method: 'POST',
                    data: formData,
                    dataType: "json",
                    success: function (res) {

                        if (res.type) {
                            toastr[res.type](res.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1000)
                        } else {
                            toastr['error']('Houve um erro inesperado ao salvar o registro!');
                            $('#btn-submit').prop('disabled', false).text('Salvar');
                        }

                    },
                    error: function (xhr) {

                        $('#btn-submit').prop('disabled', false).text('Salvar');

                        const response = xhr.responseJSON;

                        if (response?.message) {
                            toastr[response.type](response.message)
                        } else {
                            toastr['error']('Erro inesperado');
                        }

                        if (response?.errors) {
                            exibeErros(response.errors);
                        }

                    }
                });
            });
        }
    </script>
</div>
<?php
include_once __DIR__ . "/../includes/footer.view.php"
?>
