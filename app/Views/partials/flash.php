<?php

declare(strict_types=1);

$flashMessages = \App\Core\Session::pullFlash();
if ($flashMessages === []) {
    return;
}
?>
<div class="flash-list" role="status">
    <?php foreach ($flashMessages as $flash): ?>
        <?php
        $type = $flash['type'] ?? 'info';
        if (!in_array($type, ['success', 'error', 'info'], true)) {
            $type = 'info';
        }
        ?>
        <p class="flash flash--<?= e($type) ?>"><?= e($flash['message'] ?? '') ?></p>
    <?php endforeach; ?>
</div>
