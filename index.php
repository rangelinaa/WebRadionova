<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ProductRepository.php';

try {
    $productRepo = new ProductRepository(getPDO());
    $products    = $productRepo->fetchAll();
} catch (PDOException $e) {
    die('Ошибка БД: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>sadboy archive / каталог</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1 class="page-title">sadboy archive</h1>
    <p class="page-subtitle">артефакты эпохи 2012–2017 · <?= count($products) ?> items in stock</p>

    <div class="catalog">
        <?php foreach ($products as $i => $p): ?>
            <a class="card" href="product.php?id=<?= (int)$p['id'] ?>"
               data-index="<?= sprintf('#%03d', $i + 1) ?>">
                <img class="card__img"
                     src="<?= htmlspecialchars($p['image']) ?>"
                     alt="<?= htmlspecialchars($p['name']) ?>"
                     loading="lazy">
                <div class="card__body">
                    <h2 class="card__title"><?= htmlspecialchars($p['name']) ?></h2>
                    <p class="card__price">
                        <strong><?= number_format((float)$p['price'], 0, ',', ' ') ?></strong> ₽
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>