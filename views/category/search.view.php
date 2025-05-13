<?php
$title = "Categorias";
include_once __DIR__ . "/../includes/header.view.php";
echo $this->csrfTokenInput();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="/categories">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="q" class="form-label">Termo</label>
                                    <input
                                            type="text" class="form-control form-control-sm" id="q" name="q" value="<?= escapeString($this->queryParam('q')) ?? '' ?>"
                                            placeholder="Categorias..."/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex align-items-end justify-content-end">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                        <input name="order" value="<?= escapeString($this->queryParam('order', 'name')) ?>" type="hidden"/>
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
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th><a href="<?= $this->buildQuery('order', 'id') ?>">Id</a></th>
                        <th><a href="<?= $this->buildQuery('order', 'name') ?>">Categoria</a></th>
                        <th><a href="<?= $this->buildQuery('order', 'description') ?>">Descrição</a></th>
                        <th><a href="<?= $this->buildQuery('order', 'created_at') ?>">Criada em</a></th>
                        <th><a href="<?= $this->buildQuery('order', 'updated_at') ?>">Atualizada em</a></th>
                        <th class="text-end"><a class="btn btn-sm btn-success" href="/category/create" role="button">Nova Categoria</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($items)) { ?>
                        <?php foreach ($items as $item) { ?>
                            <tr class="align-middle">
                                <td><?php echo $item['id'] ?? '' ?></td>
                                <td><?php echo escapeString($item['name']) ?? '' ?></td>
                                <td><?php echo escapeString($item['description']) ?? '' ?></td>
                                <td><?php echo dateFormat($item['created_at'], 'd/m/Y H:i:s') ?></td>
                                <td><?php echo dateFormat($item['updated_at'], 'd/m/Y H:i:s') ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <a class="btn btn-sm btn-primary me-2" href="/category/<?php echo $item['encoded_id'] ?>/edit">Editar</a>
                                        <button
                                                class="btn btn-sm btn-danger <?php if ($item['id'] === 1): ?>invisible<?php endif; ?>"
                                                onclick="confirmarExclusao('/category/<?php echo $item['encoded_id'] ?>/delete', function () {
                                                        location.reload(); // ou remove o item da lista
                                                        })">Excluir
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
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
