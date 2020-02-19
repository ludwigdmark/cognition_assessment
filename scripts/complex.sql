USE `cognition`;

DROP TABLE IF EXISTS `cognition`.`people`;

CREATE TABLE `cognition`.`people` (
    `id` int(11) AUTO_INCREMENT,
    `fullname` varchar(100),
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `id` (`id`)
);
 
DROP TABLE IF EXISTS `cognition`.`interests`;

CREATE TABLE `cognition`.`interests` (
    `id` int(11) AUTO_INCREMENT,
    `interest_name` varchar(100),
    `multiple_docs_allowed` bit(1),
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `id` (`id`)
);
 
DROP TABLE IF EXISTS `cognition`.`interests_rel`;

CREATE TABLE `cognition`.`interests_rel` (
    `id` int(11) AUTO_INCREMENT,
    `person_pk` int(11),
    `interest_pk` int(11),
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `id` (`id`)
);
 
DROP TABLE IF EXISTS `cognition`.`documents`;

CREATE TABLE `cognition`.`documents` (
    `id` int(11) AUTO_INCREMENT,
    `filename` varchar(100),
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `id` (`id`)
);
 
DROP TABLE IF EXISTS `cognition`.`documents_rel`;

CREATE TABLE `cognition`.`documents_rel` (
    `id` int(11) AUTO_INCREMENT,
    `person_pk` int(11),
    `interest_pk` int(11),
    `document_pk` int(11),
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `id` (`id`)
);



            SELECT pe.id, pe.fullname, it.interest_name, it.multiple_docs_allowed FROM `cognition`.`people` AS pe
            LEFT JOIN `cognition`.`interests_rel` AS ir ON pe.id = ir.person_pk
            LEFT JOIN `cognition`.`interests` AS it ON it.id = ir.interest_pk
            LEFT JOIN `cognition`.`documents_rel` AS dr ON pe.id = dr.person_pk AND it.id = dr.interest_pk
            LEFT JOIN `cognition`.`documents` AS dc ON dc.id = ir.document_pk;