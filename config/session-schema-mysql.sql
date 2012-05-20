CREATE TABLE `sessions` (
`session_id` VARCHAR(24) NOT NULL,
`last_active` INT UNSIGNED NOT NULL,
`contents` TEXT NOT NULL,
PRIMARY KEY (`session_id`),
INDEX (`last_active`)
) ENGINE = InnoDB  DEFAULT CHARSET=utf8;
