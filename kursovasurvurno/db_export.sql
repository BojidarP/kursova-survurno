CREATE DATABASE car_rental
CREATE USER 'car_rental_user'@'localhost' IDENTIFIED BY '123456';
SHOW GRANTS FOR 'car_rental_user'@'localhost';

GRANT ALL PRIVILEGES ON car_rental.* TO 'car_rental_user' @'localhost' IDENTIFIED BY '123456';

SHOW GRANTS FOR 'car_rental_user'@'localhost';
-- 10000 refresh-a po kusno raboti 
FLUSH PRIVILEGES;


CREATE TABLE `favorite_cars_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `cars` (
  `id` int(11) NOT NULL, 
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `cars` (`id`, `title`, `image`, `price_per_day`) VALUES
(1, 'BMW 3 Series', 'https://www.bmw.in/content/dam/bmw/marketIN/bmw_in/all-models/3-series/gl/2023/navigation.png/jcr:content/renditions/cq5dam.resized.img.585.low.time1673330685738.png', '49.99'),
(2, 'Audi A4', 'https://upload.wikimedia.org/wikipedia/commons/3/35/Audi_A4_B9_sedans_%28FL%29_1X7A2441.jpg', '59.99'),
(3, 'Mercedes-Benz C-Class', 'https://media.ed.edmunds-media.com/mercedes-benz/c-class/2025/oem/2025_mercedes-benz_c-class_sedan_amg-c-43_fq_oem_1_815.jpg', '69.99'),
(4, 'Toyota Corolla', 'https://images.carexpert.com.au/resize/3000/-/app/uploads/2024/02/Toyota-Corolla-Sedan-ZR-Hybrid-MY23-Stills-20.jpg?_gl=1*1re4dj3*_gcl_au*MTMxMDE5Mjg1MS4xNzM0MDI1OTIx', '29.99'),
(5, 'Honda Civic', 'https://www.carscoops.com/wp-content/uploads/2019/06/5e0ea901-honda-civic-type-r-james-may-1024x555.jpg', '39.99'),
(6, 'Ford Mustang', 'https://static1.hotcarsimages.com/wordpress/wp-content/uploads/2022/09/CE7HlbbUsAA-uTubbc.jpg?q=50&fit=crop&w=1140&h=&dpr=1.5', '99.99'),
(7, 'Chevrolet Camaro', 'https://www.motortrend.com/uploads/sites/5/2010/07/2010-chevrolet-camaro-synergy-special-edition-front-passenger-three-quarters.jpg', '89.99'),
(8, 'Tesla Model 3', 'https://i0.wp.com/eurica.me/wp-content/uploads/2023/09/nuova-tesla-model-3-1.jpg?resize=1024%2C576&ssl=1', '119.99'),
(9, 'Volkswagen Golf', 'https://media.ed.edmunds-media.com/volkswagen/golf-gti/2024/oem/2024_volkswagen_golf-gti_4dr-hatchback_380-autobahn_fq_oem_2_1600x1067.jpg', '49.99');



CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





ALTER TABLE `favorite_cars_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `favorite_cars_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;


ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

CREATE INDEX idx_user_id ON favorite_cars_users(user_id);
CREATE INDEX idx_car_id ON favorite_cars_users(car_id);

COMMIT;


