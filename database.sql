CREATE DATABASE IF NOT EXISTS catalog_menu
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE catalog_menu;

DROP TABLE IF EXISTS menu_items;

CREATE TABLE menu_items (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    parent_id  INT NULL,
    name       VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    CONSTRAINT fk_parent
        FOREIGN KEY (parent_id) REFERENCES menu_items(id)
        ON DELETE CASCADE,

    INDEX idx_parent (parent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO menu_items (id, parent_id, name, sort_order) VALUES
    (1,  NULL, 'Каталог товаров', 1),

        (2,  1,    'Мойки',         1),
            (3,  2,    'Ulgran',        1),
                (4,  3,    'Smth',          1),
                (5,  3,    'Smth',          2),
            (6,  2,    'Vigro Mramor',  2),
            (7,  2,    'Handmade',      3),
                (8,  7,    'Smth',          1),
                (9,  7,    'Smth',          2),
            (10, 2,    'Vigro Glass',   4),

        (11, 1,    'Фильтры',       2),
            (12, 11,   'Ulgran',        1),
                (13, 12,   'Smth',          1),
                (14, 12,   'Smth',          2),
            (15, 11,   'Vigro Mramor',  2);