DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
                           `id` char(36) NOT NULL,
                           `name` varchar(255) NOT NULL,
                           `price` int NOT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` char(36) NOT NULL,
  `customer_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `refunded_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `order_line`;
CREATE TABLE `order_line` (
  `order_id` char(36) NOT NULL,
  `product_id` char(36) NOT NULL,
  `amount` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  CONSTRAINT `order_line_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `customer` (`id`, `name`) VALUES
('55943c45-a597-4c34-9a26-83f48fa659c6', 'Bruce'),
('7fe8d7bb-5935-4e12-a5cf-45c281f7af00', 'Tina'),
('a231f5fa-b781-4b79-9aea-85840ce71911', 'John'),
('b874a8fe-2f00-40e7-b68a-ed368c3ef12b', 'Jane');

INSERT INTO `product` (`id`, `name`, `price`) VALUES
('626ff8c7-f332-4a18-8de3-905daf32be0d', 'Angle Connector', 100),
('693c56c3-144c-477a-9eed-c68d7b6aa701', 'Box of nails', 1000),
('a42dc873-9bef-4d41-871d-c5a26e4cadb8', 'M4 Nut', 50),
('b6ab6c71-654a-4726-a3e0-c1915fb413ea', 'Screw Driver', 1500),
('ccfc79f3-2be1-47cf-95b7-513a6eed9de0', 'M4 Bolt', 50);

INSERT INTO `order` (`id`, `customer_id`) VALUES
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', '55943c45-a597-4c34-9a26-83f48fa659c6'),
    ('fd707e52-1ae3-4deb-9fdc-f81360e48d9e', 'b874a8fe-2f00-40e7-b68a-ed368c3ef12b');

INSERT INTO `order_line` (`order_id`, `product_id`, `amount`, `price`) VALUES
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', '626ff8c7-f332-4a18-8de3-905daf32be0d', 20, 100),
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', 'a42dc873-9bef-4d41-871d-c5a26e4cadb8', 80, 50),
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', 'ccfc79f3-2be1-47cf-95b7-513a6eed9de0', 80, 50),
    ('fd707e52-1ae3-4deb-9fdc-f81360e48d9e', 'b6ab6c71-654a-4726-a3e0-c1915fb413ea', 1, 1500);
