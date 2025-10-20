<?php
$flash = getFlashMessage();
if ($flash): ?>
    <div class="alert alert-<?php echo $flash['type']; ?>">
        <?php echo $flash['message']; ?>
    </div>
<?php endif; ?>