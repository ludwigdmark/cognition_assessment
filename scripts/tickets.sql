USE `cognition`;

DROP TABLE IF EXISTS `cognition`.`tickets`;

CREATE TABLE `cognition`.`tickets` (
    `id` int(11) AUTO_INCREMENT,
    `ticket_type` varchar(50),
    `ticket_status` varchar(50) DEFAULT 'Opened',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `logged_by` varchar(260),
    `logged_location` varchar(50),
    `created_for` varchar(260),
    `ticket_details` JSON,
    `ticket_token` varchar(128),
    UNIQUE KEY `id` (`id`)
);
 
INSERT INTO `cognition`.`tickets`(`ticket_type`, `ticket_status`, `logged_by`, `logged_location`, `created_for`, `ticket_details`, `ticket_token`) VALUES ('Accounts', 'Opened', 'luis.fisher@cognitionholdings.co.za', '-26.2240197,28.0207338', 'jamie.morris@gmail.com', '{"text":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."}', '4fce9efd97564b027c161961c7200f70205eaa29723675f626100e3df4154f26aadeac04eb20d0b0a7bc2296ad76825195282d3b2bf1a5a31b5e4e39d3237fdd');


SELECT * FROM `cognition`.`tickets`;