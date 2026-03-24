<?php
$conn = new mysqli('localhost', 'root', '', 'menu_db');
$conn->set_charset('utf8');

function renderMenu($conn, $parent_id = null) {
    $pid = is_null($parent_id) ? 'IS NULL' : "= $parent_id";
    $result = $conn->query("SELECT * FROM categories WHERE parent_id $pid");
    
    if ($result->num_rows === 0) return '';
    
    $html = '';
    while ($row = $result->fetch_assoc()) {
        $children = renderMenu($conn, $row['id']);
        $hasChildren = !empty($children);
        
        $openClass = $hasChildren ? ' list-item_open' : '';
        $arrowStyle = $hasChildren ? '' : ' style="visibility: hidden;"';
        
        $html .= '
        <div class="list-item' . $openClass . '" data-parent>
            <div class="list-item__inner">
                <img class="list-item__arrow" src="img/chevron-down.png" alt="chevron-down" data-open' . $arrowStyle . '>
                <img class="list-item__folder" src="img/folder.png" alt="folder">
                <span>' . htmlspecialchars($row['name']) . '</span>
            </div>
            <div class="list-item__items">
                ' . $children . '
            </div>
        </div>';
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="list-items" id="list-items">
    <?= renderMenu($conn) ?>
</div>
<script src="script.js"></script>
</body>
</html>