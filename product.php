<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ProductRepository.php';

$id = (int)($_GET['id'] ?? 0);
$product = (new ProductRepository(getPDO()))->fetchById($id);

if (!$product) {
    require __DIR__ . '/404.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> / sadboy archive</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <a class="back-link" href="index.php">← back to archive</a>

        <div class="product">
            <img class="product__img"
                src="<?= htmlspecialchars($product['image']) ?>"
                alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="product__info">
                <span class="product__meta">item · <?= sprintf('#%03d', (int)$product['id']) ?></span>
                <h1 class="product__title"><?= htmlspecialchars($product['name']) ?></h1>
                <p class="product__price">
                    <?= number_format((float)$product['price'], 0, ',', ' ') ?> ₽
                </p>
                <p class="product__description">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </p>
            </div>
        </div>

        <section class="feedback" data-product-id="<?= (int)$product['id'] ?>">
            <h2 class="feedback__heading">отзывы / reviews</h2>
            <div class="feedback__list" id="feedback-list"></div>

            <form class="feedback__form" id="feedback-form">
                <h3>оставить отзыв</h3>
                <label>имя / @handle
                    <input type="text" name="author" required maxlength="100" placeholder="как вас звать">
                </label>
                <div class="rating">
                    <span class="rating__label">оценка</span>
                    <div class="rating__stars" data-rating>
                        <button type="button" class="rating__star" data-value="1">★</button>
                        <button type="button" class="rating__star" data-value="2">★</button>
                        <button type="button" class="rating__star" data-value="3">★</button>
                        <button type="button" class="rating__star" data-value="4">★</button>
                        <button type="button" class="rating__star" data-value="5">★</button>
                    </div>
                    <input type="hidden" name="rating" value="5" required>
                </div>
                <label>комментарий
                    <textarea name="comment" required rows="4" placeholder="поделитесь впечатлениями..."></textarea>
                </label>
                <button type="submit">отправить</button>
            </form>
        </section>
    </div>
    <script src="script.js"></script>
</body>

</html>