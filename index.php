<?php
function writeLog() {
    $logFile = 'log.txt';
    $time = date('Y-m-d H:i:s');
    $entry = $time . "\n";

    $count = 0;
    if (file_exists($logFile)) {
        $content = file_get_contents($logFile);
        $count = substr_count($content, "\n");
    }

    if ($count >= 10) {
        $archiveIndex = 0;
        while (file_exists('log' . $archiveIndex . '.txt')) {
            $archiveIndex++;
        }
        rename($logFile, 'log' . $archiveIndex . '.txt');
    }

    file_put_contents($logFile, $entry, FILE_APPEND);
}

writeLog();

$images = [
    "img/fan-001.jpg",
    "img/caps-002.jpg",
    "img/sakura-003.jpg",
    "img/lotus-004.jpg",
    "img/wake-005.jpg",
    "img/buddha-006.jpg",
    "img/hardy-007.jpg",
    "img/stairs-015.jpg",   
];

// Задание 1
function buildGalleryStatic($images) {
    foreach ($images as $i => $img) {
        $name = strtoupper(pathinfo($img, PATHINFO_FILENAME));
        $ext  = strtoupper(pathinfo($img, PATHINFO_EXTENSION));
        $num  = '(1.' . ($i + 1) . ')';
        echo '<a href="' . $img . '" target="_blank">';
        echo   '<div class="card-index">' . $num . '</div>';
        echo   '<img src="' . $img . '">';
        echo   '<div class="card-label"><span>' . $name . '</span><span class="card-ext">' . $ext . '</span></div>';
        echo '</a>';
    }
}

// Задание 2
function buildGallery($folder) {
    $files = scandir($folder);
    $i = 1;
    foreach ($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            $path = $folder . '/' . $file;
            $name = strtoupper(pathinfo($file, PATHINFO_FILENAME));
            echo '<a href="' . $path . '" target="_blank">';
            echo   '<div class="card-index">(2.' . $i . ')</div>';
            echo   '<img src="' . $path . '">';
            echo   '<div class="card-label"><span>' . $name . '</span><span class="card-ext">' . strtoupper($ext) . '</span></div>';
            echo '</a>';
            $i++;
        }
    }
}

// Задание 3
function buildUploadedGallery($folder) {
    if (!is_dir($folder)) { echo '<p class="empty">нет загруженных фото</p>'; return; }
    $files = scandir($folder);
    $found = false; $i = 1;
    foreach ($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']) && strpos($file, 'thumb_') !== 0) {
            $found = true;
            $path  = $folder . '/' . $file;
            $name  = strtoupper(pathinfo($file, PATHINFO_FILENAME));
            echo '<a href="' . $path . '" target="_blank">';
            echo   '<div class="card-index">(3.' . $i . ')</div>';
            echo   '<img src="' . $path . '">';
            echo   '<div class="card-label"><span>' . $name . '</span><span class="card-ext">' . strtoupper($ext) . '</span></div>';
            echo '</a>';
            $i++;
        }
    }
    if (!$found) echo '<p class="empty">нет загруженных фото</p>';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024;

    if (!in_array($file['type'], $allowedTypes)) {
        $error = "Ошибка: загружать можно только JPG, PNG, GIF";
    } elseif ($file['size'] > $maxSize) {
        $error = "Ошибка: файл слишком большой (максимум 5MB)";
    } else {
    $filename = basename($file['name']);

    move_uploaded_file($file['tmp_name'], "uploads/" . $filename);

    $src = imagecreatefromjpeg("uploads/" . $filename);
    $thumb = imagecreatetruecolor(200, 200);
    $w = imagesx($src);
    $h = imagesy($src);
    imagecopyresampled($thumb, $src, 0, 0, 0, 0, 200, 200, $w, $h);
    imagejpeg($thumb, "uploads/thumb_" . $filename);

    header("Location: index.php");
    exit;
}
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>«ФОТОАРХИВ»</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-logo">«Фотоархив»</div>
    <div class="nav-links">
        <a href="#task1">Задание 1</a>
        <a href="#task2">Задание 2</a>
        <a href="#task3">Задание 3</a>
    </div>
</nav>

<div class="section" id="task1">
    <div class="section-title">Задание 1 - статичный список</div>
    <div class="gallery"><?php buildGalleryStatic($images); ?></div>
</div>

<div class="section" id="task2">
    <div class="section-title">Задание 2 - чтение папки</div>
    <div class="gallery"><?php buildGallery('img'); ?></div>
</div>

<div class="section" id="task3">
    <div class="section-title">Задание 3 - загрузить фото</div>
    <?php if (isset($error)) echo '<p class="error">' . $error . '</p>'; ?>
    <label class="upload-area" for="photo">
        <span class="upload-icon">+</span>
        <span class="upload-hint">выберите файл</span>
        <span class="upload-hint" style="color:var(--gray-light);margin-top:4px">JPG PNG GIF - до 5MB</span>
        <p id="file-name"></p>
        <input type="file" name="photo" id="photo" accept="image/*"
               form="upload-form"
               onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
    </label>
    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <button type="submit" class="btn-upload">Загрузить экспонат</button>
    </form>
    <div class="gallery" style="margin-top:32px"><?php buildUploadedGallery('uploads'); ?></div>
</div>

<div class="section">
    <div class="section-title">Задание 4–5 - журнал посещений</div>
    <div class="log-box"><?php echo file_exists('log.txt') ? nl2br(htmlspecialchars(file_get_contents('log.txt'))) : '-'; ?></div>
</div>

<footer>
    <span>«Фотоархив»</span>
    <span>2026</span>
</footer>

</body>
</html>