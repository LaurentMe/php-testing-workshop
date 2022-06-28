DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `customer_since` datetime NOT NULL,
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
  `description` varchar(255) NOT NULL,
  `amount` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`order_id`,`description`),
  CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `customer` (`id`, `name`, `customer_since`) VALUES
('55943c45-a597-4c34-9a26-83f48fa659c6', 'Bruce', '2022-05-01 12:00:00'),
('7fe8d7bb-5935-4e12-a5cf-45c281f7af00', 'Tina', '2022-06-01 12:00:00'),
('a231f5fa-b781-4b79-9aea-85840ce71911', 'John', '2021-04-25 12:00:00'),
('b874a8fe-2f00-40e7-b68a-ed368c3ef12b', 'Jane', '2020-02-03 12:00:00');

INSERT INTO `order` (`id`, `customer_id`) VALUES
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', '55943c45-a597-4c34-9a26-83f48fa659c6'),
    ('fd707e52-1ae3-4deb-9fdc-f81360e48d9e', 'b874a8fe-2f00-40e7-b68a-ed368c3ef12b');

INSERT INTO `order_line` (`order_id`, `description`, `amount`, `price`) VALUES
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', 'Angle Connectors', 20, 100),
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', 'M4 Bolt', 80, 50),
    ('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926', 'M4 Nut', 80, 50),
    ('fd707e52-1ae3-4deb-9fdc-f81360e48d9e', 'Screwdriver', 1, 1500);
