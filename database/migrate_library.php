<?php
/**
 * GEC MODASA - Central Library Database Migration
 * Creates tables for Library Catalogues (XLSX uploads) & Library Team (Committee & Staff)
 */
require_once __DIR__ . '/../includes/db.php';

$pdo = getDBConnection();
if (!$pdo) {
    die("Database connection failed\n");
}

try {
    // 1. Create table library_catalogues
    $pdo->exec("CREATE TABLE IF NOT EXISTS library_catalogues (
        id INT AUTO_INCREMENT PRIMARY KEY,
        dept_name VARCHAR(255) NOT NULL,
        subtext TEXT NULL,
        titles_count VARCHAR(50) NOT NULL,
        volume_count VARCHAR(50) NOT NULL,
        file_path VARCHAR(255) DEFAULT NULL,
        file_size VARCHAR(50) DEFAULT NULL,
        display_order INT NOT NULL DEFAULT 0,
        is_active TINYINT(1) NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_active (is_active),
        INDEX idx_order (display_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Check if empty, seed initial 8 departments
    $stmt = $pdo->query("SELECT COUNT(*) FROM library_catalogues");
    if ($stmt->fetchColumn() == 0) {
        $initialCatalogues = [
            ['Mechanical & Automobile Engineering', 'Thermodynamics, Manufacturing, Automobile Systems, Machine Design', '1,110', '4,811', null, null, 1],
            ['Civil Engineering & Applied Mechanics', 'Structural Analysis, Surveying, Geotechnical, Fluid Mechanics, Concrete', '1,457', '3,873', null, null, 2],
            ['Computer Engineering & Information Technology', 'Algorithms, Operating Systems, Database, AI/ML, Networks, Cyber Security', '1,476', '5,178', null, null, 3],
            ['Electrical Engineering', 'Electrical Machines, Power Systems, Control Systems, High Voltage', '668', '2,312', null, null, 4],
            ['Electronics & Communication Engineering', 'Digital Communication, VLSI Design, Embedded Systems, Signal Processing', '1,347', '4,186', null, null, 5],
            ['General Sciences & Humanities', 'Engineering Mathematics, Physics, Chemistry, Professional English, Ethics', '901', '2,163', null, null, 6],
            ['RUSA Section', 'Rashtriya Uchchatar Shiksha Abhiyan Special Grant Volumes & Reference', '201', '290', null, null, 7],
            ['Bureau of Indian Standards (IS Code)', 'National Engineering Specifications, Testing Standards, Codes of Practice', '1,818', '2,049', null, null, 8]
        ];

        $insCat = $pdo->prepare("INSERT INTO library_catalogues (dept_name, subtext, titles_count, volume_count, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        foreach ($initialCatalogues as $cat) {
            $insCat->execute($cat);
        }
    }

    // 2. Create table library_team
    $pdo->exec("CREATE TABLE IF NOT EXISTS library_team (
        id INT AUTO_INCREMENT PRIMARY KEY,
        team_type ENUM('committee', 'staff') NOT NULL DEFAULT 'committee',
        name VARCHAR(255) NOT NULL,
        department_info VARCHAR(255) NULL,
        designation VARCHAR(255) NOT NULL,
        badge_class VARCHAR(50) DEFAULT 'dept-tag-ug',
        display_order INT NOT NULL DEFAULT 0,
        is_active TINYINT(1) NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_team_type (team_type),
        INDEX idx_active (is_active),
        INDEX idx_order (display_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Check if empty, seed initial faculty committee & staff
    $stmtTeam = $pdo->query("SELECT COUNT(*) FROM library_team");
    if ($stmtTeam->fetchColumn() == 0) {
        $initialTeam = [
            // Committee
            ['committee', 'Prof. Nirali V. Upadhyay', 'Assistant Professor, Electrical Engineering (AP.EE)', 'Library Incharge', 'dept-tag-incharge', 1],
            ['committee', 'Prof. Kunal V. Fadadu', 'Assistant Professor, Automobile Engineering (AP.AT)', 'Assistant Library Incharge', 'dept-tag-asst', 2],
            ['committee', 'Prof. A. B. Parmar', 'Assistant Professor, Computer Engineering (AP.CE)', 'Member', 'dept-tag-ug', 3],
            ['committee', 'Prof. N. S. Chowdhary', 'Assistant Professor, Computer Engineering (AP.CE)', 'Member', 'dept-tag-ug', 4],
            ['committee', 'Prof. R. N. Vaza', 'Assistant Professor, Computer Engineering (AP.CE)', 'Member', 'dept-tag-ug', 5],
            ['committee', 'Prof. C. K. Baria', 'Assistant Professor, Electrical Engineering (AP.EE)', 'Member', 'dept-tag-ug', 6],
            // Staff
            ['staff', 'Shri A. M. Patel', 'Learning Resource Centre (LRC)', 'In-charge (Librarian)', 'dept-tag-librarian', 1],
            ['staff', 'Shri J. N. Patel', 'Electronics & Communication Engineering (EC)', 'Member', 'dept-tag-ug', 2]
        ];

        $insTeam = $pdo->prepare("INSERT INTO library_team (team_type, name, department_info, designation, badge_class, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
        foreach ($initialTeam as $tm) {
            $insTeam->execute($tm);
        }
    }

    echo "LIBRARY_MIGRATION_SUCCESSFUL\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
