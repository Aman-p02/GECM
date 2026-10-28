-- ==============================================================
-- GEC MODASA — OFFICIAL DATABASE SCHEMA & SEED DATA
-- Project: Government Engineering College, Modasa (GECM)
-- File: gecm_db.sql
-- Charset: utf8mb4 (Full Unicode & Multilingual Support)
-- ==============================================================

CREATE DATABASE IF NOT EXISTS `gecm_db` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `gecm_db`;

-- --------------------------------------------------------------
-- 1. HERO CAROUSEL SLIDES TABLE
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hero_slides` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL DEFAULT 'Welcome to Government Engineering College, Modasa',
    `subtitle` VARCHAR(255) DEFAULT 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi',
    `image_url` VARCHAR(255) NOT NULL,
    `label` VARCHAR(150) DEFAULT NULL,
    `virtual_tour_url` VARCHAR(255) DEFAULT '#',
    `display_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_hero_status_order` (`is_active`, `display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Hero Slides Data
INSERT INTO `hero_slides` (`title`, `subtitle`, `image_url`, `label`, `display_order`, `is_active`) VALUES
('Welcome to <br> Government Engineering College, Modasa', 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi', 'images/hero_campus_1.webp', 'Main Campus & Admin Block', 1, 1),
('Welcome to <br> Government Engineering College, Modasa', 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi', 'images/hero_campus_2.jpg', 'Engineering Academic Complex', 2, 1),
('Welcome to <br> Government Engineering College, Modasa', 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi', 'images/hero_campus_3.jpg', 'Central Library & Auditorium', 3, 1),
('Welcome to <br> Government Engineering College, Modasa', 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi', 'images/hero_campus_4.jpg', 'Lush Green Campus Aerial View', 4, 1);


-- --------------------------------------------------------------
-- 2. NEWS TICKER (MARQUEE UPDATES) TABLE
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `news_ticker` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `message` TEXT NOT NULL,
    `link_url` VARCHAR(255) DEFAULT NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ticker_active` (`is_active`, `display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial News Ticker Data
INSERT INTO `news_ticker` (`message`, `link_url`, `display_order`, `is_active`) VALUES
('Admission open for BE First Year 2024-25.', '#', 1, 1),
('Mid-Semester Exams schedule has been released. Check notice board for details.', '#', 2, 1),
('State Level Hackathon 2024 registrations are now open!', '#', 3, 1);


-- --------------------------------------------------------------
-- 3. NOTICE BOARD TABLE
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notices` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `badge` ENUM('None', 'New', 'Urgent') DEFAULT 'None',
    `category` VARCHAR(50) DEFAULT 'General',
    `file_url` VARCHAR(255) DEFAULT NULL,
    `link_url` VARCHAR(255) DEFAULT '#',
    `publish_date` DATE NOT NULL,
    `expiry_date` DATE DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_notice_date_active` (`is_active`, `publish_date` DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Notice Board Data
INSERT INTO `notices` (`title`, `badge`, `category`, `publish_date`, `is_active`) VALUES
('Guidelines for AICTE Pragati & Saksham Scholarship Schemes 2024-25', 'New', 'Scholarship', '2026-10-15', 1),
('Timetable for B.E. Semester 5 Mid-Semester Examination', 'None', 'Exam', '2026-10-10', 1),
('Result Declaration: BE Sem-6 Regular Summer 2024', 'None', 'Exam', '2026-10-02', 1),
('Academic Calendar for Odd Semester 2024-25', 'None', 'Academic', '2026-09-28', 1),
('Submission of Scholarship Forms for SC/ST Students', 'Urgent', 'Scholarship', '2026-09-20', 1),
('Hostel Admission Merit List Announced for First Year Students', 'None', 'Hostel', '2026-09-15', 1),
('GTU TechFest 2024 Participation Registration Open', 'None', 'Events', '2026-09-10', 1),
('Revised Syllabus for Engineering Mechanics (Civil Dept)', 'None', 'Academic', '2026-09-05', 1);


-- --------------------------------------------------------------
-- 4. RECENT EVENTS TABLE
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `events` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `event_date` DATE DEFAULT NULL,
    `view_url` VARCHAR(255) DEFAULT '#',
    `display_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_events_active` (`is_active`, `display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Recent Events Data
INSERT INTO `events` (`title`, `description`, `image_url`, `display_order`, `is_active`) VALUES
('TechFest 2024', 'Annual Technical Symposium with 50+ inter-college events.', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, 1),
('Convocation Ceremony', 'Batch of 2020-2024 engineering graduation day.', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 2, 1),
('State Level Hackathon', '24-hour innovation sprint held at GEC Modasa campus.', 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 3, 1);


-- --------------------------------------------------------------
-- 5. LATEST SHOTS / CAMPUS GALLERY TABLE
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `latest_shots` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_shots_active` (`is_active`, `display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Latest Shots Data
INSERT INTO `latest_shots` (`title`, `description`, `image_url`, `display_order`, `is_active`) VALUES
('Robotics & Innovation', 'Students demonstrating autonomous robotics and IoT prototypes.', 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, 1),
('Annual Sports Meet', 'Inter-department athletics championship and cricket tournament.', 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 2, 1),
('Prarambh Youth Fest', 'Vibrant stage performances, music, drama, and celebrations.', 'https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 3, 1),
('Engineering Workshop', 'Hands-on practical machining and metal fabrication sessions.', 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 4, 1);


-- --------------------------------------------------------------
-- 6. DEPARTMENTS TABLE
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `departments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `code` VARCHAR(20) NOT NULL UNIQUE,
    `icon_class` VARCHAR(100) NOT NULL DEFAULT 'fas fa-graduation-cap',
    `learn_more_url` VARCHAR(255) DEFAULT '#',
    `display_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_dept_active` (`is_active`, `display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Departments Data
INSERT INTO `departments` (`name`, `code`, `icon_class`, `learn_more_url`, `display_order`, `is_active`) VALUES
('Computer Engineering', 'CE', 'fas fa-desktop', 'departments/computer/', 1, 1),
('Information Technology', 'IT', 'fas fa-network-wired', 'departments/information-technology/', 2, 1),
('Mechanical Engineering', 'ME', 'fas fa-cogs', 'departments/mechanical/', 3, 1),
('Automobile Engineering', 'AE', 'fas fa-car-side', '#', 4, 1),
('Civil Engineering', 'CIVIL', 'fas fa-building', '#', 5, 1),
('Electrical Engineering', 'EE', 'fas fa-bolt', '#', 6, 1),
('Electronics & Comm.', 'EC', 'fas fa-microchip', '#', 7, 1);


-- --------------------------------------------------------------
-- 7. OUR PROUD ALUMNI TABLE
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `alumni` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `branch` VARCHAR(100) NOT NULL,
    `graduation_year` INT NOT NULL,
    `company` VARCHAR(150) NOT NULL,
    `photo_url` VARCHAR(255) NOT NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_alumni_active` (`is_active`, `display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Alumni Data
INSERT INTO `alumni` (`name`, `branch`, `graduation_year`, `company`, `photo_url`, `display_order`, `is_active`) VALUES
('Rahul Sharma', 'Computer Engg.', 2015, 'Google, USA', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 1, 1),
('Priya Patel', 'IT Engg.', 2018, 'Microsoft, India', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 2, 1),
('Amit Kumar', 'Mechanical Engg.', 2012, 'Tata Motors', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 3, 1),
('Sneha Desai', 'Civil Engg.', 2016, 'L&T Construction', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 4, 1),
('Karan Singh', 'Electrical Engg.', 2019, 'Reliance Industries', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 5, 1),
('Pooja Mehta', 'Electronics & Comm.', 2017, 'Intel Corporation', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 6, 1),
('Darshan Joshi', 'Automobile Engg.', 2014, 'Mahindra R&D', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 7, 1),
('Riya Trivedi', 'Computer Engg.', 2021, 'Amazon AWS', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80', 8, 1);


-- --------------------------------------------------------------
-- 8. SITE SETTINGS TABLE (Contact, Address, General Info)
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_settings` (
    `setting_key` VARCHAR(50) PRIMARY KEY,
    `setting_value` TEXT NOT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Settings Data
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('college_name', 'Government Engineering College, Modasa'),
('college_location', 'Modasa, Gujarat'),
('phone_number', '+91 2774 242631'),
('contact_email', 'gec-modasa-dte@gujarat.gov.in'),
('address', 'Shamlaji Road, Modasa, Dist. Aravalli, Gujarat - 383315'),
('virtual_tour_url', '#');


-- --------------------------------------------------------------
-- 9. ADMIN USERS TABLE (CMS Management Panel)
-- Default Login: admin / admin123 (bcrypt hashed)
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('super_admin', 'editor', 'notice_publisher') DEFAULT 'super_admin',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default Admin user: username: admin / password: admin123
INSERT IGNORE INTO `admins` (`username`, `email`, `password_hash`, `role`, `is_active`) VALUES
('admin', 'admin@gecmodasa.ac.in', '$2y$10$XJEQB4BoIwqVzgXa5f.NVeN3MuCiwTHGl8jmofq2tS/FTIsztgJl2', 'super_admin', 1);
