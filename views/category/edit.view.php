<?php

$title = "Nova Categoria";

if (!empty($encoded_id)) {
    $title = "Categoria: {$data['name']}";
}

include_once __DIR__ . "/../includes/header.view.php"
?>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <?= escapeString($title) ?>
        </div>
        <div class="card-body">
            <form id="taskForm" method="post">

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= escapeString($data['name']) ?? '' ?>" required maxlength="255">
                            <div class="invalid-feedback" id="error_name"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea maxlength="200" class="form-control" id="description" name="description" rows="4"><?= escapeString($data['description'] ?? '') ?></textarea>
                            <div class="invalid-feedback" id="error_description"></div>
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
                            <input name="encoded_id" id="encoded_id" type="hidden" value="<?= $encoded_id ?>">
                            <a class="btn btn-link me-auto" href="#" onclick="window.goBack()" role="button">Voltar</a>
                            <button id="btn-submit" type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
                <?= $this->csrfTokenInput() ?>
            </form>
        </div>
    </div>
    <script>
        $('#taskForm').on('submit', function (e) {
            e.preventDefault();
            limpaErros();
            $('#btn-submit').prop('disabled', true).text('Salvando...');
            const formData = $(this).serialize();
            $.ajax({
                url: '/category/save',
                method: 'POST',
                data: formData,
                success: function (res) {
                    $('#message').text('Categoria salva com sucesso!')
                        .removeClass('alert-danger d-none')
                        .addClass('alert-success');
                    $('#btn-submit').text('Carregando...');
                    setTimeout(function () {
                        location.replace('/category/' + res.encoded_id + '/edit')
                    }, 1000)
                },
                error: function (xhr) {
                    $('#btn-submit').prop('disabled', false).text('Salvar');
                    const msg = xhr.responseJSON?.message || 'Erro ao salvar tarefa.';
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
<?php
include_once __DIR__ . "/../includes/footer.view.php"
?>
