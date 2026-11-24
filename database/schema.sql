-- UCA Nutrition – MVP schema
-- Import in phpMyAdmin or: mysql -u root < database/schema.sql

CREATE DATABASE IF NOT EXISTS uca_nutrition
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE uca_nutrition;

-- Users & Auth
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(120) NOT NULL,
  role ENUM('student','admin') NOT NULL DEFAULT 'student',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  onboarding_done TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE user_profiles (
  user_id INT UNSIGNED PRIMARY KEY,
  birth_date DATE NOT NULL,
  gender ENUM('male','female') NOT NULL,
  height_cm SMALLINT UNSIGNED NOT NULL CHECK (height_cm BETWEEN 100 AND 250),
  activity_level ENUM('sedentary','light','moderate','active','very_active') NOT NULL,
  fitness_goal ENUM('weight_loss','maintenance','weight_gain','muscle_gain') NOT NULL,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE nutrition_goals (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  fitness_goal VARCHAR(20) NOT NULL,
  bmr SMALLINT UNSIGNED NOT NULL,
  tdee SMALLINT UNSIGNED NOT NULL,
  calories SMALLINT UNSIGNED NOT NULL,
  protein_g SMALLINT UNSIGNED NOT NULL,
  carbs_g SMALLINT UNSIGNED NOT NULL,
  fat_g SMALLINT UNSIGNED NOT NULL,
  valid_from DATE NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_goal_user_date (user_id, valid_from)
) ENGINE=InnoDB;

-- Food catalog

CREATE TABLE food_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  sort_order SMALLINT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE allergens (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE food_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  name VARCHAR(120) NOT NULL,
  description TEXT NULL,
  image_path VARCHAR(255) NULL,
  portion_label VARCHAR(60) NOT NULL,
  portion_grams SMALLINT UNSIGNED NULL,
  calories SMALLINT UNSIGNED NOT NULL,
  protein_g DECIMAL(6,1) NOT NULL,
  carbs_g DECIMAL(6,1) NOT NULL,
  fat_g DECIMAL(6,1) NOT NULL,
  base_price DECIMAL(8,2) NOT NULL CHECK (base_price >= 0),
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES food_categories(id),
  INDEX idx_food_cat (category_id, is_active)
) ENGINE=InnoDB;

CREATE TABLE food_allergens (
  food_item_id INT UNSIGNED NOT NULL,
  allergen_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (food_item_id, allergen_id),
  FOREIGN KEY (food_item_id) REFERENCES food_items(id) ON DELETE CASCADE,
  FOREIGN KEY (allergen_id) REFERENCES allergens(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE user_allergens (
  user_id INT UNSIGNED NOT NULL,
  allergen_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (user_id, allergen_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (allergen_id) REFERENCES allergens(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Daily menu

CREATE TABLE daily_menus (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  menu_date DATE NOT NULL UNIQUE,
  is_published TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE daily_menu_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  menu_id INT UNSIGNED NOT NULL,
  food_item_id INT UNSIGNED NOT NULL,
  price DECIMAL(8,2) NOT NULL CHECK (price >= 0),
  quantity_left SMALLINT UNSIGNED NULL,
  is_available TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY uq_menu_food (menu_id, food_item_id),
  FOREIGN KEY (menu_id) REFERENCES daily_menus(id) ON DELETE CASCADE,
  FOREIGN KEY (food_item_id) REFERENCES food_items(id)
) ENGINE=InnoDB;

-- Food diary (with snapshots)

CREATE TABLE meal_logs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  log_date DATE NOT NULL,
  meal_type ENUM('breakfast','lunch','dinner','snack') NOT NULL,
  UNIQUE KEY uq_user_day_meal (user_id, log_date, meal_type),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE meal_log_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  meal_log_id INT UNSIGNED NOT NULL,
  food_item_id INT UNSIGNED NULL,
  food_name VARCHAR(120) NOT NULL,
  servings DECIMAL(4,2) NOT NULL CHECK (servings > 0),
  calories DECIMAL(7,1) NOT NULL,
  protein_g DECIMAL(6,1) NOT NULL,
  carbs_g DECIMAL(6,1) NOT NULL,
  fat_g DECIMAL(6,1) NOT NULL,
  price_paid DECIMAL(8,2) NOT NULL,
  FOREIGN KEY (meal_log_id) REFERENCES meal_logs(id) ON DELETE CASCADE,
  FOREIGN KEY (food_item_id) REFERENCES food_items(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Weight tracking
CREATE TABLE weight_logs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  log_date DATE NOT NULL,
  weight_kg DECIMAL(5,2) NOT NULL CHECK (weight_kg BETWEEN 25 AND 300),
  UNIQUE KEY uq_user_weight_day (user_id, log_date),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;