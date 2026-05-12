-- ============================================================
-- portfolio_db.sql
-- Portfolio Database — Full Export
-- Import this file via phpMyAdmin or MySQL CLI:
--   mysql -u root -p < portfolio_db.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS `portfolio_db`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `portfolio_db`;

-- ---- PROJECTS TABLE ----
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id`          INT          NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(200) NOT NULL,
  `description` TEXT         NOT NULL,
  `tags`        VARCHAR(300) DEFAULT '',
  `github_url`  VARCHAR(500) DEFAULT '',
  `demo_url`    VARCHAR(500) DEFAULT '',
  `image_url`   VARCHAR(500) DEFAULT '',
  `sort_order`  INT          NOT NULL DEFAULT 0,
  `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---- CONTACTS TABLE ----
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id`          INT          NOT NULL AUTO_INCREMENT,
  `first_name`  VARCHAR(100) NOT NULL,
  `last_name`   VARCHAR(100) NOT NULL,
  `email`       VARCHAR(200) NOT NULL,
  `subject`     VARCHAR(300) NOT NULL,
  `message`     TEXT         NOT NULL,
  `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---- SAMPLE PROJECTS ----
INSERT INTO `projects` (`title`, `description`, `tags`, `github_url`, `demo_url`, `image_url`, `sort_order`) VALUES
('E-Commerce Platform',
 'A modern shopping experience with real-time inventory management, secure payments, and an admin dashboard built with PHP and MySQL.',
 'PHP, MySQL, JavaScript, CSS3',
 'https://github.com/alexmorgan/ecommerce',
 '#',
 'https://images.unsplash.com/photo-1557821552-17105176677c?w=800&h=450&fit=crop',
 1),

('Portfolio Website',
 'This very portfolio — a full-stack PHP/MySQL web application with dynamic project loading via AJAX, a contact form, and an admin dashboard.',
 'HTML5, CSS3, PHP, MySQL, AJAX',
 'https://github.com/alexmorgan/portfolio',
 '#',
 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=450&fit=crop',
 2),

('Task Management App',
 'Collaborative project management tool with real-time updates, team assignments, and progress tracking built on a PHP REST API.',
 'PHP, MySQL, JavaScript, REST API',
 'https://github.com/alexmorgan/taskapp',
 '#',
 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=450&fit=crop',
 3),

('Blog CMS',
 'A lightweight content management system with Markdown support, category management, and SEO-friendly URLs built in pure PHP.',
 'PHP, MySQL, HTML5, CSS3',
 'https://github.com/alexmorgan/blog-cms',
 '#',
 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=800&h=450&fit=crop',
 4),

('Analytics Dashboard',
 'Business intelligence dashboard with dynamic charts, date filtering, and CSV export built with PHP and Chart.js.',
 'PHP, MySQL, JavaScript, Chart.js',
 'https://github.com/alexmorgan/analytics',
 '#',
 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=450&fit=crop',
 5),

('Student Registration System',
 'A full-stack student enrollment and grade tracking system with role-based access (admin/teacher/student) using PHP sessions.',
 'PHP, MySQL, Sessions, HTML5',
 'https://github.com/alexmorgan/student-sys',
 '#',
 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=450&fit=crop',
 6);
