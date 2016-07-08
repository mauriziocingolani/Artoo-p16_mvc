<h1>Home Page</h1>

<?= 'Benvenuto nella home page'; ?>

<?php foreach ($utenti as $u) : ?>
    <p><?= $u; ?></p>
<?php endforeach; ?>
