-- Demo accounts for UCA Nutrition.
-- Import after schema.sql. Passwords: admin123 / student123
-- Re-importing updates the three demo rows in place.

USE uca_nutrition;

INSERT INTO users (email, password_hash, full_name, role, is_active, onboarding_done) VALUES
(
  'admin@uca.edu',
  '$2y$10$kw1gdZIjr/rvLFIvzqq3xerJPriwuovushj8FDiLRLAdr4NhUunci',
  'Cafeteria Admin',
  'admin',
  1,
  1
),
(
  'aida@uca.edu',
  '$2y$10$1pVu9QtktrtHE9YB3hs4.Ob337ByN00BDVkAtXnHsORGf2Mzoer.y',
  'Aida Student',
  'student',
  1,
  0
),
(
  'bekzat@uca.edu',
  '$2y$10$6jkbrYjqZQuuzzysXCqfbeC.ZP12CCkpx3WOVhFDkiE/yOfXdjf7e',
  'Bekzat Student',
  'student',
  1,
  0
)
ON DUPLICATE KEY UPDATE
  password_hash = VALUES(password_hash),
  full_name = VALUES(full_name),
  role = VALUES(role),
  is_active = VALUES(is_active);
