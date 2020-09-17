CREATE DATABASE mySmurll;
USE mySmurll;

CREATE TABLE IF NOT EXISTS `urls` (
  `org_url` varchar(500) CHARACTER SET ascii NOT NULL,
  `url_code` varchar(8) CHARACTER SET ascii NOT NULL,
  `nb_visited` int NOT NULL DEFAULT 0
);
