CREATE DATABASE IF NOT EXISTS catalog_shop
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE catalog_shop;

DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    image       VARCHAR(255) NOT NULL,
    price       DECIMAL(10, 2) NOT NULL,
    description TEXT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE feedback (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    author     VARCHAR(100) NOT NULL,
    rating     TINYINT NOT NULL,
    comment    TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO products (name, image, price, description) VALUES
('Arizona Green Tea, 680 мл',
 'img/products/arizona.jpg',
 249.00,
 'Та самая жестяная банка с цветущей сакурой. Зелёный чай с мёдом и женьшенем. Цена — $0.99. Пьётся холодной, желательно ночью на пустой парковке.'),

('Винил Yung Lean — Unknown Death 2002',
 'img/products/yunglean.jpg',
 4200.00,
 'Переиздание дебютного микстейпа 2013 года на лимитированном прозрачном виниле. Ginseng Strip 2002, Hennessy & Sailor Moon. Sad boys forever.'),

('Sony Walkman WM-EX194 (б/у)',
 'img/products/walkman.jpg',
 6800.00,
 'Кассетный плеер из Японии, конец 90-х. В рабочем состоянии, механика чистая, корпус со следами жизни. Батарейки и кассета Maxell в подарок.'),

('Плёночная камера Kodak FunSaver',
 'img/products/kodak.jpg',
 1490.00,
 'Одноразовая камера на 27 кадров, встроенная вспышка, ISO 800. Снимает ту самую зернистую плёнку, под которую настроены все пресеты в Lightroom.'),

('Набор косметических блёсток (6 оттенков)',
 'img/products/glitter.jpg',
 890.00,
 'Голографические блёстки для лица, тела и внутренних демонов. Холодный серебряный, розовое золото, лавандовый, индиго, мятный, медный. Гипоаллергенные.'),

('Свеча ароматическая «Basement»',
 'img/products/candle.jpg',
 1350.00,
 'Соевая свеча ручной работы. Ноты: сырой бетон, старые книги, озон после дождя, немного никотина (имитация). Горит 40 часов. Дом пахнет, как репетиция концерта в 2015.'),

('Zippo с тигром (реплика 2012)',
 'img/products/zippo.jpg',
 2400.00,
 'Бензиновая зажигалка с принтом «бенгальский тигр на фоне молний». Культовый дизайн с ларька у метро. Для свечей, костров и эстетики.'),

('Постер Lil Peep, А2',
 'img/products/peep.jpg',
 650.00,
 'Печать на матовой бумаге 250 г/м^2. Кадр из клипа Benz Truck. Идеально над кроватью или рядом с постером Cowboy Bebop.'),

('Проводные наушники-капельки',
 'img/products/earbuds.jpg',
 490.00,
 'Белые, с кнопкой на проводе, miniJack 3.5. Запутываются в кармане за 4 секунды. Без Bluetooth, без шумодава, без компромиссов.'),

('Футболка-сетка, чёрная',
 'img/products/fishnet.jpg',
 1790.00,
 'Fishnet top oversized. Надевается поверх белой майки или сама по себе, если смелость позволяет. Универсальный размер.'),

('VHS-кассета «Ghost in the Shell» (1995)',
 'img/products/vhs.jpg',
 3200.00,
 'Оригинальная видеокассета японского издания. Коробка потёрта, плёнка чистая. Воспроизведение — на ваш страх и риск и на ваш VHS-плеер.');