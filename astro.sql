CREATE TABLE `admin` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL DEFAULT '',
    `password` VARCHAR(100) NOT NULL DEFAULT '',
    `support_email` VARCHAR(300) NOT NULL DEFAULT '',
    `support_phone` VARCHAR(300) NOT NULL DEFAULT '',
    `minimum_amount` VARCHAR(100) NOT NULL DEFAULT '',
    `bitcoin_address` VARCHAR(100) NOT NULL DEFAULT '',
    `ethereum_address` VARCHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
    `admin` (
        `id`,
        `username`,
        `password`,
        `support_email`,
        `minimum_amount`,
        `bitcoin_address`,
        `ethereum_address`,
        `support_phone`
    )
VALUES
    (
        '1',
        'astroadmin',
        '977302936afc03b7637c7e0acd6273fd80a9898e01733251fa589d058206ee88',
        'support@astrofxcinvestment.com',
        '20',
        'btc-infinspfinsif',
        'eth-sufbuosbfousjbfoujs',
        '+1 (913) 276-0376'
    );

CREATE TABLE `admin` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL DEFAULT '',
    `password` VARCHAR(100) NOT NULL DEFAULT '',
    `support_email` VARCHAR(300) NOT NULL DEFAULT '',
    `support_phone` VARCHAR(300) NOT NULL DEFAULT '',
    `minimum_amount` VARCHAR(100) NOT NULL DEFAULT '',
    `bitcoin_address` VARCHAR(100) NOT NULL DEFAULT '',
    `ethereum_address` VARCHAR(100) NOT NULL DEFAULT '',
    `bnb_address` VARCHAR(100) NOT NULL DEFAULT '',
    `ada_address` VARCHAR(100) NOT NULL DEFAULT '',
    `xrp_address` VARCHAR(100) NOT NULL DEFAULT '',
    `doge_address` VARCHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
    `admin` (
        `id`,
        `username`,
        `password`,
        `support_email`,
        `minimum_amount`,
        `support_phone`,
        `support_phone`,
        `minimum_amount`,
        `support_phone`,
        `minimum_amount`,
        `support_phone`,
        `bitcoin_address`,
        `ethereum_address`,
        `bnb_address`,
        `ada_address`,
        `xrp_address`,
        `doge_address`
    )
VALUES
    (
        '1',
        'astroadmin',
        '54a66ba7d582eea6ebc9d5bdd257eea95a597079853408545e7afd22ba89c905',
        'support@astrofxctrades.com',
        '20',
        '+1 (765)Â 325-5529',
        '1CcXysaicrBmGbP7u2JZPGKdndbLB452jk',
        '0xeb440bdeb55d9e05e20be0ad3e716258a2722c8a',
        '0xeb440bdeb55d9e05e20be0ad3e716258a2722c8a',
        '0xeb440bdeb55d9e05e20be0ad3e716258a2722c8a',
        '0xeb440bdeb55d9e05e20be0ad3e716258a2722c8a',
        '0xeb440bdeb55d9e05e20be0ad3e716258a2722c8a'
    );

CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `full_name` VARCHAR(100) NOT NULL DEFAULT '',
    `username` VARCHAR(100) NOT NULL DEFAULT '',
    `email` VARCHAR(100) NOT NULL DEFAULT '',
    `phone` VARCHAR(100) NOT NULL DEFAULT '',
    `password` VARCHAR(100) NOT NULL DEFAULT '',
    `country` VARCHAR(100) NOT NULL DEFAULT '',
    `account_balance` VARCHAR(100) NOT NULL DEFAULT '',
    `earned_total` VARCHAR(100) NOT NULL DEFAULT '',
    `total_withdrawal` VARCHAR(100) NOT NULL DEFAULT '',
    `last_withdrawal` VARCHAR(100) NOT NULL DEFAULT '',
    `pending_withdrawal` VARCHAR(100) NOT NULL DEFAULT '',
    `active_deposit` VARCHAR(100) NOT NULL DEFAULT '',
    `last_deposit` VARCHAR(100) NOT NULL DEFAULT '',
    `total_deposit` VARCHAR(100) NOT NULL DEFAULT '',
    `bitcoin_wallet_address` VARCHAR(100) NOT NULL DEFAULT '',
    `ethereum_wallet_address` VARCHAR(100) NOT NULL DEFAULT '',
    `ip_address` VARCHAR(100) NOT NULL DEFAULT '',
    `ref` VARCHAR(100) NOT NULL DEFAULT '',
    `account_status` VARCHAR(2000) NOT NULL DEFAULT '',
    `detect_ip` VARCHAR(50) NOT NULL DEFAULT '',
    `detect_browser` VARCHAR(50) NOT NULL DEFAULT '',
    `agree` VARCHAR(20) NOT NULL DEFAULT '',
    `login_count` INT(20) NOT NULL DEFAULT 0,
    `registered_at` VARCHAR(100) NOT NULL DEFAULT '',
    `last_seen` VARCHAR(100) NOT NULL DEFAULT '',
    `no_of_referals` INT(50) NOT NULL DEFAULT 0,
    `active_referals` INT(50) NOT NULL DEFAULT 0,
    `total_referal_commission` VARCHAR(100) NOT NULL DEFAULT '',
    `count_down` VARCHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `feedback` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL DEFAULT '',
    `email` VARCHAR(100) NOT NULL DEFAULT '',
    `time` VARCHAR(100) NOT NULL DEFAULT '',
    `message` VARCHAR(3000) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `history` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `u_id` INT(11) NOT NULL,
    `username` VARCHAR(100) NOT NULL DEFAULT '',
    `type` VARCHAR(100) NOT NULL DEFAULT '',
    `amount` VARCHAR(100) NOT NULL DEFAULT '',
    `date` VARCHAR(100) NOT NULL DEFAULT '',
    `status` VARCHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `deposit_list` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `u_id` INT(11) NOT NULL,
    `username` VARCHAR(100) NOT NULL DEFAULT '',
    `type` VARCHAR(100) NOT NULL DEFAULT '',
    `amount` VARCHAR(100) NOT NULL DEFAULT '',
    `total_amount` VARCHAR(100) NOT NULL DEFAULT '',
    `date` VARCHAR(100) NOT NULL DEFAULT '',
    `create_timestamp` VARCHAR(100) NOT NULL DEFAULT '',
    `last_update_timestamp` VARCHAR(100) NOT NULL DEFAULT '',
    `status` VARCHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `withdrawal` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `u_id` INT(11) NOT NULL,
    `username` VARCHAR(100) NOT NULL DEFAULT '',
    `type` VARCHAR(100) NOT NULL DEFAULT '',
    `currency` VARCHAR(1000) NOT NULL DEFAULT '',
    `withdrawal_amount` VARCHAR(100) NOT NULL DEFAULT '',
    `btc_address` VARCHAR(100) NOT NULL DEFAULT '',
    `date` VARCHAR(100) NOT NULL DEFAULT '',
    `ip` VARCHAR(100) NOT NULL DEFAULT '',
    `status` VARCHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `payments` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `u_id` INT(11) NOT NULL,
    `username` VARCHAR(100) NOT NULL DEFAULT '',
    `type` VARCHAR(100) NOT NULL DEFAULT '',
    `from_currency` VARCHAR(100) NOT NULL DEFAULT '',
    `entered_amount` VARCHAR(100) NOT NULL DEFAULT '',
    `to_currency` VARCHAR(100) NOT NULL DEFAULT '',
    `amount` VARCHAR(100) NOT NULL DEFAULT '',
    `gateway_id` VARCHAR(1000) NOT NULL DEFAULT '',
    `gateway_url` VARCHAR(500) NOT NULL DEFAULT '',
    `hashcode` VARCHAR(500) NOT NULL DEFAULT '',
    `status` VARCHAR(100) NOT NULL DEFAULT '',
    `created_at` VARCHAR(100) NOT NULL DEFAULT '',
    `update_at` VARCHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `password_recovery` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `sr` VARCHAR(100) NOT NULL,
    `elapse_time` VARCHAR(100) NOT NULL,
    `count` INT(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `payment_errors` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `$debug_email` VARCHAR(100) NOT NULL,
    `$report` VARCHAR(3000) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
    `deposit_list` (
        `id`,
        `u_id`,
        `username`,
        `type`,
        `amount`,
        `total_amount`,
        `date`,
        `create_timestamp`,
        `last_update_timestamp`,
        `status`
    )
VALUES
    (
        NULL,
        '8',
        'jontorres',
        '2',
        '18000',
        '18000',
        '27/11/2020',
        '1606431600',
        '1606431600',
        'pending'
    ),
    (
        NULL,
        '10',
        'sou',
        '1',
        '12000',
        '12000',
        '05/12/2020',
        '1607122800',
        '1607122800',
        'pending'
    ),
    (
        NULL,
        '11',
        'king',
        '4',
        '20000',
        '20000',
        '17/11/2020',
        '1605567600',
        '1605567600',
        'pending'
    ),
    (
        NULL,
        '12',
        'maru',
        '3',
        '50000',
        '50000',
        '25/11/2020',
        '1606258800',
        '1606258800',
        'pending'
    );

INSERT INTO
    `history` (
        `id`,
        `u_id`,
        `username`,
        `type`,
        `amount`,
        `date`,
        `status`
    )
VALUES
    (
        NULL,
        '8',
        'jontorres',
        'Deposit',
        '18000',
        '27-11-2020',
        'pending'
    ),
    (
        NULL,
        '10',
        'sou',
        'Deposit',
        '12000',
        '05-12-2020',
        'pending'
    ),
    (
        NULL,
        '11',
        'king',
        'Deposit',
        '20000',
        '17-11-2020',
        'pending'
    ),
    (
        NULL,
        '12',
        'maru',
        'Deposit',
        '50000',
        '25-11-2020',
        'pending'
    );