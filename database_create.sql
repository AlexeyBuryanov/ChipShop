-- Script written by Alexey Bur'yanov
-- Создание базы и таблиц
-- 02.05.2018


-- -----------------------------------------------------
-- Database `chip`
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `chip`;

CREATE DATABASE IF NOT EXISTS `chip` DEFAULT CHARACTER SET utf8mb4;
USE `chip`;


-- -----------------------------------------------------
-- Table `chip`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`users`;

CREATE TABLE IF NOT EXISTS `chip`.`users`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `enabled` INT(1) UNSIGNED NOT NULL,
  `first_name` VARCHAR(50) NULL DEFAULT NULL,
  `last_name` VARCHAR(50) NULL DEFAULT NULL,
  `mobile_phone` VARCHAR(15) NULL DEFAULT NULL,
  `image_url` VARCHAR(255) NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `last_login` DATETIME NULL DEFAULT NULL,
  `role` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `enabled` (`enabled` ASC),
  INDEX `role` (`role` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`adresses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`adresses`;

CREATE TABLE IF NOT EXISTS `chip`.`adresses`(
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_adress` VARCHAR(255) NOT NULL,
  `is_personal` INT(1) UNSIGNED NOT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC),
  INDEX `full_adress` (`full_adress`(191) ASC),
  CONSTRAINT `adresses_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `chip`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`supercategories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`supercategories`;

CREATE TABLE IF NOT EXISTS `chip`.`supercategories`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  INDEX `name` (`name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`categories`;

CREATE TABLE IF NOT EXISTS `chip`.`categories`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `supercategory_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `categories_ibfk_1` (`supercategory_id` ASC),
  INDEX `name` (`name` ASC),
  CONSTRAINT `categories_ibfk_1`
    FOREIGN KEY (`supercategory_id`)
    REFERENCES `chip`.`supercategories` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`subcategories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`subcategories`;

CREATE TABLE IF NOT EXISTS `chip`.`subcategories`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `category_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `category_id` (`category_id` ASC),
  INDEX `name` (`name` ASC),
  CONSTRAINT `subcategories_ibfk_1`
    FOREIGN KEY (`category_id`)
    REFERENCES `chip`.`categories` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`products`;

CREATE TABLE IF NOT EXISTS `chip`.`products`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `price` FLOAT UNSIGNED NULL DEFAULT NULL,
  `quantity` INT(11) UNSIGNED NOT NULL,
  `visible` TINYINT(1) UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL,
  `subcategory_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `subcategory_id` (`subcategory_id` ASC),
  INDEX `title` (`title` ASC),
  INDEX `price` (`price` ASC),
  INDEX `quantity` (`quantity` ASC),
  INDEX `visible` (`visible` ASC),
  INDEX `created_at` (`created_at` ASC),
  CONSTRAINT `products_ibfk_1`
    FOREIGN KEY (`subcategory_id`)
    REFERENCES `chip`.`subcategories` (`id`)
    ON DELETE SET NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`favourites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`favourites`;

CREATE TABLE IF NOT EXISTS `chip`.`favourites`(
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `favourites_ibfk_1` (`user_id` ASC),
  INDEX `favourites_ibfk_2` (`product_id` ASC),
  CONSTRAINT `favourites_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `chip`.`users` (`id`),
  CONSTRAINT `favourites_ibfk_2`
    FOREIGN KEY (`product_id`)
    REFERENCES `chip`.`products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`images`;

CREATE TABLE IF NOT EXISTS `chip`.`images`(
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `image_url` VARCHAR(255) NOT NULL DEFAULT '',
  `product_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `product_id` (`product_id` ASC),
  INDEX `image_url` (`image_url`(191) ASC),
  CONSTRAINT `images_ibfk_1`
    FOREIGN KEY (`product_id`)
    REFERENCES `chip`.`products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`orders`;

CREATE TABLE IF NOT EXISTS `chip`.`orders`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `status` INT(1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC),
  INDEX `created_at` (`created_at` ASC),
  INDEX `status` (`status` ASC),
  CONSTRAINT `orders_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `chip`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`order_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`order_products`;

CREATE TABLE IF NOT EXISTS `chip`.`order_products`(
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity` INT(11) NOT NULL,
  `order_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `order_id` (`order_id` ASC),
  INDEX `product_id` (`product_id` ASC),
  INDEX `quantity` (`quantity` ASC),
  CONSTRAINT `order_products_ibfk_1`
    FOREIGN KEY (`order_id`)
    REFERENCES `chip`.`orders` (`id`),
  CONSTRAINT `order_products_ibfk_2`
    FOREIGN KEY (`product_id`)
    REFERENCES `chip`.`products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`promotions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`promotions`;

CREATE TABLE IF NOT EXISTS `chip`.`promotions`(
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `percent` INT(11) UNSIGNED NOT NULL,
  `start_date` DATETIME NOT NULL,
  `end_date` DATETIME NOT NULL,
  `product_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `product_id` (`product_id` ASC),
  INDEX `percent` (`percent` ASC),
  INDEX `start_date` (`start_date` ASC),
  INDEX `end_date` (`end_date` ASC),
  CONSTRAINT `promotions_ibfk_1`
    FOREIGN KEY (`product_id`)
    REFERENCES `chip`.`products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`reviews`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`reviews`;

CREATE TABLE IF NOT EXISTS `chip`.`reviews`(
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(15) NOT NULL,
  `comment` VARCHAR(255) NOT NULL,
  `rating` INT(1) UNSIGNED NOT NULL,
  `user_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC),
  INDEX `product_id` (`product_id` ASC),
  INDEX `rating` (`rating` ASC),
  CONSTRAINT `reviews_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `chip`.`users` (`id`),
  CONSTRAINT `reviews_ibfk_2`
    FOREIGN KEY (`product_id`)
    REFERENCES `chip`.`products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`subcat_specifications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`subcat_specifications`;

CREATE TABLE IF NOT EXISTS `chip`.`subcat_specifications`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `subcategory_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `subcat_spec_ibfk_1` (`subcategory_id` ASC),
  INDEX `name` (`name` ASC),
  CONSTRAINT `subcat_spec_ibfk_1`
    FOREIGN KEY (`subcategory_id`)
    REFERENCES `chip`.`subcategories` (`id`)
    ON DELETE SET NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `chip`.`subcat_specification_value`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `chip`.`subcat_specification_value`;

CREATE TABLE IF NOT EXISTS `chip`.`subcat_specification_value`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `value` TEXT NOT NULL DEFAULT '',
  `subcat_spec_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `subcat_spec_val_ibfk_1` (`subcat_spec_id` ASC),
  INDEX `subcat_spec_val_ibfk_2` (`product_id` ASC),
  INDEX `value` (`value`(191) ASC),
  CONSTRAINT `subcat_spec_val_ibfk_1`
    FOREIGN KEY (`subcat_spec_id`)
    REFERENCES `chip`.`subcat_specifications` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `subcat_spec_val_ibfk_2`
    FOREIGN KEY (`product_id`)
    REFERENCES `chip`.`products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;