CREATE TABLE
    `revoked_tokens_service` (
        `id` INT(10) NOT NULL AUTO_INCREMENT,
        `token` TEXT NOT NULL COLLATE 'utf8mb4_bin',
        `identifier` VARCHAR(50) NOT NULL DEFAULT '' COLLATE 'utf8mb4_bin',
        PRIMARY KEY (`id`) USING BTREE
    ) COLLATE = 'utf8mb4_bin' ENGINE = InnoDB;