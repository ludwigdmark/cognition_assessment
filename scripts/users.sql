USE `cognition`;

DROP TABLE IF EXISTS `cognition`.`users`;

CREATE TABLE `cognition`.`users` (
    `id` int(11) AUTO_INCREMENT,
    `email` varchar(260),
    `firstname` varchar(100),
    `lastname` varchar(100),
    `fullname` varchar(201) AS (CONCAT(`firstname`,' ',`lastname`)),
    `cellno` varchar(15),   
    `person_data` JSON,
    `usertype` varchar(50) DEFAULT 'Guest',
    `passhash` varchar(128),
    `hashsalt` varchar(32),     
    `user_token` varchar(128), 
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
);

/* Managers who view reports */
INSERT INTO `cognition`.`users`(`usertype`, `email`, `firstname`, `lastname`, `cellno`, `passhash`, `hashsalt`) VALUES ('Management', 'tristan.welch@cognitionholdings.co.za','Tristan','Welch','0783790245','$2y$10$d466f6834cae8ae6b876cuS6a6nMmx6x4oyXDk2wuNL5i36tOqzwu','d466f6834cae8ae6b876c64342bbfcc1');
INSERT INTO `cognition`.`users`(`usertype`, `email`, `firstname`, `lastname`, `cellno`, `passhash`, `hashsalt`) VALUES ('Management', 'vicky.moore@cognitionholdings.co.za','Vicky','Moore','0876790245','$2y$10$1ffe63f17b05575d24b89u.206GF.DzVgaXBQqx0VXq/yssEubwGO','1ffe63f17b05575d24b892f4d99657f2');

/* Support agents who created and update support tickets */
INSERT INTO `cognition`.`users`(`usertype`, `email`, `firstname`, `lastname`, `cellno`, `passhash`, `hashsalt`) VALUES ('Support', 'luis.fisher@cognitionholdings.co.za','Luis','Fisher','0613790245','$2y$10$01d2c44dd8d8080a14cb8uA55hnn1qR7D.fU90iUqKDPYKrQfjqPW','01d2c44dd8d8080a14cb86e8720cbcc1');
INSERT INTO `cognition`.`users`(`usertype`, `email`, `firstname`, `lastname`, `cellno`, `passhash`, `hashsalt`) VALUES ('Support', 'julio.morris@cognitionholdings.co.za','Julio','Morris','0613230202','$2y$10$4c72c61f7b0d177372de9uO/6zzYRO2Wv0.RZk3hyMDSYTURTnfE.','4c72c61f7b0d177372de9062e1510d2f');
INSERT INTO `cognition`.`users`(`usertype`, `email`, `firstname`, `lastname`, `cellno`, `passhash`, `hashsalt`) VALUES ('Support', 'jamie.gomez@cognitionholdings.co.za','Jamie','Gomez','0613796703','$2y$10$f10fc37e6602827da1e0euIung6P1Z2k6HYBMuA7Nqrdf9x1hhmgG','f10fc37e6602827da1e0e4e24118e5d8');

/* Clients for whom tickets are logged */
INSERT INTO `cognition`.`users`(`usertype`, `email`, `firstname`, `lastname`, `cellno`, `person_data`, `user_token`) VALUES ('Guest', 'jamie.morris@gmail.com','Jamie','Morris','0613790204','{}', '586d05ccd434cea574d7319e1ad5ea78343e724aa549ec6ac1737bf062d8ccded7ff9311a025a11c0dcaa8ee009aeae5df6ea12410defcf2858b012262109b2e');


SELECT * FROM `cognition`.`users`;