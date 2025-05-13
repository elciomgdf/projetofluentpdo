<?php if (!empty($data) && $data['total_pages'] > 1): ?>
    <?php
    $current = $data['current_page'];
    $total = $data['total_pages'];
    $range = 2; // mostra 2 antes e 2 depois
    ?>
    <div class="d-flex justify-content-between align-items-center my-3">
        <div class="text-muted">
            <?= $data['total'] ?> registro<?= $data['total'] > 1 ? 's' : '' ?> encontrado<?= $data['total'] > 1 ? 's' : '' ?>
        </div>
        <nav>
            <ul class="pagination mb-0">

                <!-- Anterior -->
                <li class="page-item <?= $current == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $this->buildQuery('page', $current - 1) ?>">&laquo;</a>
                </li>

                <!-- Primeira -->
                <?php if ($current > $range + 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $this->buildQuery('page', 1) ?>">1</a>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                <?php endif; ?>

                <!-- Faixa dinâmica -->
                <?php for ($i = max(1, $current - $range); $i <= min($total, $current + $range); $i++): ?>
                    <li class="page-item <?= $i == $current ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $this->buildQuery('page', $i) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Última -->
                <?php if ($current < $total - $range): ?>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item">
                        <a class="page-link" href="<?= $this->buildQuery('page', $total) ?>"><?= $total ?></a>
                    </li>
                <?php endif; ?>

                <!-- Próxima -->
                <li class="page-item <?= $current == $total ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $this->buildQuery('page', $current + 1) ?>">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
<?php endif; ?>
