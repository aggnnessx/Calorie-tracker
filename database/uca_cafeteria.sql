-- UCA Cafeteria Calorie Tracker: database schema + demo data
-- Import in phpMyAdmin (Laragon: Menu > MySQL > phpMyAdmin) or: mysql -u root < database/uca_cafeteria.sql
-- Re-importing resets everything to the demo state.

CREATE DATABASE IF NOT EXISTS uca_cafeteria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE uca_cafeteria;

DROP TABLE IF EXISTS meal_log;
DROP TABLE IF EXISTS menu_items;
DROP TABLE IF EXISTS dishes;
DROP TABLE IF EXISTS users;

-- 1) Who can log in
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('student','admin') NOT NULL DEFAULT 'student',
  daily_goal INT NOT NULL DEFAULT 2000
);

-- 2) Dish library: every dish the cafeteria can cook, with nutrition per ONE portion
CREATE TABLE dishes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL UNIQUE,
  category VARCHAR(20)  NOT NULL,
  serving_size VARCHAR(40) NOT NULL,
  calories INT NOT NULL,
  protein DECIMAL(5,1) NOT NULL DEFAULT 0,
  fat DECIMAL(5,1) NOT NULL DEFAULT 0,
  carbs DECIMAL(5,1) NOT NULL DEFAULT 0
);

-- 3) Weekly menu: which dish is served on which date (junction table, many-to-many)
CREATE TABLE menu_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  menu_date DATE NOT NULL,
  dish_id INT NOT NULL,
  UNIQUE KEY one_dish_per_day (menu_date, dish_id),
  FOREIGN KEY (dish_id) REFERENCES dishes(id) ON DELETE CASCADE
);

-- 4) What a student ate (or plans to eat) on a given day
CREATE TABLE meal_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  dish_id INT NOT NULL,
  eaten_on DATE NOT NULL,
  servings DECIMAL(3,1) NOT NULL DEFAULT 1.0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)  ON DELETE CASCADE,
  FOREIGN KEY (dish_id) REFERENCES dishes(id) ON DELETE RESTRICT
);

-- Demo accounts: admin@uca.edu / admin123, student@uca.edu / student123
INSERT INTO users (name, email, password_hash, role, daily_goal) VALUES
('Cafeteria Admin', 'admin@uca.edu', '$2y$10$AliYR3//rfwj9I8XDTwq2OJQFdbFN8APPbNptTMyOidoCGUkWBjsq', 'admin', 2000),
('Demo Student', 'student@uca.edu', '$2y$10$v77V0.zuEGvk3TKRSSMaveiuqIYVRUdyrJtbl1mCtsgoIOK7pmQGa', 'student', 2200);

-- Demo dishes (approximate values: replace with the cafeteria's real data) 
INSERT INTO dishes (name, category, serving_size, calories, protein, fat, carbs) VALUES
('Borscht', 'Soup', '300 ml', 150,  6.0,  7.0, 15.0),
('Lagman soup', 'Soup', '350 g', 380, 18.0, 14.0, 45.0),
('Shorpo', 'Soup', '350 ml', 290, 20.0, 17.0, 14.0),
('Chicken noodle soup', 'Soup', '300 ml', 160, 10.0,  5.0, 18.0),
('Plov (beef)', 'Main', '300 g', 560, 22.0, 24.0, 62.0),
('Manty (4 pcs)', 'Main', '280 g', 520, 24.0, 26.0, 46.0),
('Chicken cutlet', 'Main', '120 g',  270, 18.0, 17.0, 11.0),
('Baked fish fillet', 'Main', '150 g',  210, 28.0,  9.0,  3.0),
('Beef goulash', 'Main', '150 g',  260, 20.0, 17.0,  6.0),
('Omelette', 'Main', '150 g',  240, 14.0, 19.0,  3.0),
('Syrniki (3 pcs)', 'Main', '180 g', 390, 19.0, 14.0, 45.0),
('Samsa', 'Main', '150 g', 420, 13.0, 24.0, 39.0),
('Boiled rice', 'Side', '180 g',  235,  5.0,  1.0, 51.0),
('Buckwheat', 'Side', '180 g',  220,  8.0,  3.0, 42.0),
('Mashed potatoes', 'Side', '200 g', 210,  4.0,  9.0, 29.0),
('Pasta', 'Side', '200 g', 310, 11.0,  2.0, 62.0),
('Oatmeal porridge', 'Side', '250 g', 230,  8.0,  6.0, 36.0),
('Cucumber & tomato salad', 'Salad', '150 g', 90,  2.0,  6.0,  8.0),
('Olivier salad', 'Salad', '150 g', 250,  6.0, 19.0, 14.0),
('Cabbage salad', 'Salad', '120 g', 80,  2.0,  4.0,  9.0),
('Apple', 'Dessert', '150 g', 70,  0.0,  0.0, 16.0),
('Blini with jam (2 pcs)', 'Dessert', '120 g', 280,  6.0,  8.0, 45.0),
('Cake slice', 'Dessert', '100 g', 340,  4.0, 17.0, 43.0),
('Black tea with sugar', 'Drink', '200 ml', 25,  0.0,  0.0,  6.0),
('Compote', 'Drink', '200 ml', 90,  0.0,  0.0, 22.0),
('Kefir', 'Drink', '250 ml', 110,  7.0,  5.0,  9.0),
('Coffee with milk', 'Drink', '200 ml', 70,  3.0,  3.0,  7.0);

-- Demo menus, always relative to today so the demo never goes stale 
-- This week: Mon-Fri. Next week: Mon-Thu (Friday left empty on purpose: it shows the "menu not confirmed" fallback).
SET @mon = DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY);

INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 0 DAY), id FROM dishes WHERE name IN ('Borscht','Plov (beef)','Chicken cutlet','Buckwheat','Cabbage salad','Apple','Compote','Black tea with sugar');
INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 1 DAY), id FROM dishes WHERE name IN ('Lagman soup','Baked fish fillet','Boiled rice','Cucumber & tomato salad','Blini with jam (2 pcs)','Kefir','Black tea with sugar');
INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 2 DAY), id FROM dishes WHERE name IN ('Shorpo','Manty (4 pcs)','Chicken cutlet','Mashed potatoes','Olivier salad','Apple','Compote','Coffee with milk');
INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 3 DAY), id FROM dishes WHERE name IN ('Chicken noodle soup','Beef goulash','Pasta','Buckwheat','Cabbage salad','Cake slice','Kefir','Black tea with sugar');
INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 4 DAY), id FROM dishes WHERE name IN ('Borscht','Samsa','Omelette','Boiled rice','Cucumber & tomato salad','Apple','Compote');

INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 7 DAY),  id FROM dishes WHERE name IN ('Shorpo','Plov (beef)','Baked fish fillet','Cabbage salad','Apple','Compote','Black tea with sugar');
INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 8 DAY),  id FROM dishes WHERE name IN ('Borscht','Chicken cutlet','Mashed potatoes','Olivier salad','Syrniki (3 pcs)','Kefir');
INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 9 DAY),  id FROM dishes WHERE name IN ('Lagman soup','Manty (4 pcs)','Cucumber & tomato salad','Blini with jam (2 pcs)','Coffee with milk');
INSERT INTO menu_items (menu_date, dish_id) SELECT DATE_ADD(@mon, INTERVAL 10 DAY), id FROM dishes WHERE name IN ('Chicken noodle soup','Beef goulash','Buckwheat','Cabbage salad','Cake slice','Compote');

-- Demo history for the student (so the 7-day chart is not empty)
INSERT INTO meal_log (user_id, dish_id, eaten_on, servings)
SELECT 2, id, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 1.0 FROM dishes WHERE name IN ('Lagman soup','Baked fish fillet','Boiled rice','Compote');
INSERT INTO meal_log (user_id, dish_id, eaten_on, servings)
SELECT 2, id, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 1.0 FROM dishes WHERE name IN ('Borscht','Plov (beef)','Apple');
INSERT INTO meal_log (user_id, dish_id, eaten_on, servings)
SELECT 2, id, DATE_SUB(CURDATE(), INTERVAL 3 DAY), 1.5 FROM dishes WHERE name IN ('Omelette','Black tea with sugar');
