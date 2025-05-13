<?php
$title = "Tarefas";
include_once __DIR__ . "/../includes/header.view.php";
echo $this->csrfTokenInput();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="/tasks">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="mb-2">
                                    <label for="q" class="form-label">Termo</label>
                                    <input
                                            type="text" class="form-control form-control-sm" id="q" name="q" value="<?= escapeString($this->queryParam('q')) ?? '' ?>"
                                            placeholder="Tarefa, status, prioridade..."/>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-2">
                                    <label for="category_id" class="form-label">Categoria</label>
                                    <select name="category_id" id="category_id" class="form-select form-select-sm">
                                        <option value="">Selecione...</option>
                                        <?php if (!empty($categorias)) { ?>
                                            <?php foreach ($categorias as $categoria) { ?>
                                                <option value="<?= $categoria['id'] ?>" <?= ((int)$this->queryParam('category_id') === $categoria['id'] ? ' selected ' : '') ?>><?=escapeString($categoria['name']) ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="mb-2">
                                    <label for="priority" class="form-label">Prioridade</label>
                                    <select name="priority" id="priority" class="form-select form-select-sm">
                                        <option value="">Selecione...</option>
                                        <option value="Baixa" <?= ($this->queryParam('priority') === 'Baixa' ? ' selected ' : '') ?>>Baixa</option>
                                        <option value="Média" <?= ($this->queryParam('priority') === 'Média' ? ' selected ' : '') ?>>Média</option>
                                        <option value="Alta" <?= ($this->queryParam('priority') === 'Alta' ? ' selected ' : '') ?>>Alta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select form-select-sm">
                                        <option value="">Selecione...</option>
                                        <option value="Pendente" <?= ($this->queryParam('status') === 'Pendente' ? ' selected ' : '') ?>>Pendente</option>
                                        <option value="Em Andamento" <?= ($this->queryParam('status') === 'Em Andamento' ? ' selected ' : '') ?>>Em Andamento</option>
                                        <option value="Completa" <?= ($this->queryParam('status') === 'Completa' ? ' selected ' : '') ?>>Completa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 d-flex align-items-end justify-content-end">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                        <input name="order" value="<?= escapeString($this->queryParam('order', 'title')) ?>" type="hidden"/>
                        <input name="page" value="1" type="hidden"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="alert-container" class="alert alert-danger text-center alert-dismissible fade show d-none" role="alert">
                <strong>Atenção!</strong> <span id="alert-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <?php if (!empty($items)) { ?>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th><a href="<?= $this->buildQuery('order', 'id') ?>">Id</a></th>
                            <th><a href="<?= $this->buildQuery('order', 'title') ?>">Tarefa</a></th>
                            <th><a href="<?= $this->buildQuery('order', 'category_id') ?>">Categoria</a></th>
                            <th><a href="<?= $this->buildQuery('order', 'priority') ?>">Prioridade</a></th>
                            <th><a href="<?= $this->buildQuery('order', 'status') ?>">Status</a></th>
                            <th><a href="<?= $this->buildQuery('order', 'due_date') ?>">Previsão</a></th>
                            <th><a href="<?= $this->buildQuery('order', 'created_at') ?>">Criada em</a></th>
                            <th><a href="<?= $this->buildQuery('order', 'updated_at') ?>">Atualizada em</a></th>
                            <th class="text-end">
                                <a class="btn btn-sm btn-success" href="/task/create" role="button">Nova Tarefa</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item) { ?>
                            <tr class="align-middle">
                                <td><?php echo $item['id'] ?? '' ?></td>
                                <td><?php echo escapeString($item['title']) ?? '' ?></td>
                                <td><?php echo escapeString($item['category']) ?? '' ?></td>
                                <td><?php echo $item['priority'] ?? '' ?></td>
                                <td><?php echo $item['status'] ?? '' ?></td>
                                <td><?php echo dateFormat($item['due_date'], 'd/m/Y') ?></td>
                                <td><?php echo dateFormat($item['created_at'], 'd/m/Y H:i:s') ?></td>
                                <td><?php echo dateFormat($item['updated_at'], 'd/m/Y H:i:s') ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <a class="btn btn-sm btn-primary me-2" href="/task/<?php echo $item['encoded_id'] ?>/edit">Editar</a>
                                        <button
                                                class="btn btn-sm btn-danger"
                                                onclick="confirmarExclusao('/task/<?php echo $item['encoded_id'] ?>/delete', function () {
                                                        location.reload(); // ou remove o item da lista
                                                        })">Excluir
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-light text-center">
                        Parece que você não tem tarefas a exibir. Que tal criar uma nova clicando aqui: <a href="/task/create" role="button">Nova Tarefa</a>!
                    </div>
                <?php } ?>


            </div>
            <?php include_once __DIR__ . "/../includes/pagination.view.php"; ?>
        </div>
    </div>
</div>
<script>
    window.setPreviousUrl(window.location.href)
</script>
<?php
include_once __DIR__ . "/../includes/footer.view.php"
?>
