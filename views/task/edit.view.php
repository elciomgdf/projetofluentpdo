<?php

$title = "Nova Tarefa";

if (!empty($encoded_id)) {
    $title = "Tarefa: {$data['title']}";
}

include_once __DIR__ . "/../includes/header.view.php"
?>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <?=escapeString($title ?? '') ?>
        </div>
        <div class="card-body">
            <form id="taskForm" method="post">

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título *</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= escapeString($data['title']) ?? '' ?>" required maxlength="255">
                            <div class="invalid-feedback" id="error_title"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Pendente" <?= ($data['status'] === 'Pendente' ? ' selected ' : '') ?>>Pendente</option>
                                <option value="Em Andamento" <?= ($data['status'] === 'Em Andamento' ? ' selected ' : '') ?>>Em Andamento</option>
                                <option value="Completa" <?= ($data['status'] === 'Completa' ? ' selected ' : '') ?>>Completa</option>
                            </select>
                            <div class="invalid-feedback" id="error_status"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label for="priority" class="form-label">Prioridade</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="Baixa" <?= ($data['priority'] === 'Baixa' ? ' selected ' : '') ?>>Baixa</option>
                                <option value="Média" <?= ($data['priority'] === 'Média' ? ' selected ' : '') ?>>Média</option>
                                <option value="Alta" <?= ($data['priority'] === 'Alta' ? ' selected ' : '') ?>>Alta</option>
                            </select>
                            <div class="invalid-feedback" id="error_priority"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select required class="form-select" id="category_id" name="category_id">
                                <option value="">Selecione...</option>
                                <?php if (!empty($categorias)) { ?>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?= $categoria['id'] ?>" <?= ((int)$data['category_id'] === $categoria['id'] ? ' selected ' : '') ?>><?= escapeString($categoria['name']) ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback" id="error_category_id"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Previsão</label>
                            <input type="date" class="form-control" id="due_date" value="<?= $data['due_date'] ?? '' ?>" name="due_date">
                            <div class="invalid-feedback" id="error_due_date"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" maxlength="1000" id="description" name="description" rows="4"><?= escapeString($data['description'] ?? '') ?></textarea>
                            <div class="invalid-feedback" id="error_description"></div>
                        </div>
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
                <?=$this->csrfTokenInput() ?>
            </form>
        </div>
    </div>
    <script>
        window.onload = function () {
            $('#taskForm').on('submit', function (e) {
                e.preventDefault();
                limpaErros();
                $('#btn-submit').prop('disabled', true).text('Salvando...');
                const formData = $(this).serialize();
                $.ajax({
                    url: '/task/save',
                    method: 'POST',
                    data: formData,
                    dataType: "json",
                    success: function (res) {

                        if (res.id) {
                            toastr['success']('Registro salvo com sucesso!');
                            setTimeout(function () {
                                location.replace('/task/' + res.encoded_id + '/edit')
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
