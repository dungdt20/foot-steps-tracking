CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active' COMMENT 'active, inactive',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `foot_steps_daily` (
  `user_id` bigint unsigned NOT NULL,
  `value_date` date NOT NULL,
  `steps` int unsigned NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`value_date`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`), 
  KEY `idx_value_date` (`value_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `foot_steps_monthly` (
  `user_id` bigint unsigned NOT NULL,
  `value_month` varchar(7) NOT NULL DEFAULT 'yyyy-mm',
  `steps` int unsigned NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`value_month`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  KEY `idx_value_month` (`value_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `users` (`name`)
VALUES
('user_01'),
('user_02'),
('user_03'),
('user_04'),
('user_05'),
('user_06'),
('user_07'),
('user_08');