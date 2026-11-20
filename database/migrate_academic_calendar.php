<?php
/**
 * Migration script for Academic Calendar Module
 */
require_once __DIR__ . '/../includes/db.php';

$pdo = getDBConnection();
if (!$pdo) {
    die("Database connection failed\n");
}

try {
    // 1. Create table academic_calendars
    $pdo->exec("CREATE TABLE IF NOT EXISTS academic_calendars (
        id INT AUTO_INCREMENT PRIMARY KEY,
        academic_year VARCHAR(20) NOT NULL,
        semester_type ENUM('Odd', 'Even', 'Full Year') NOT NULL DEFAULT 'Odd',
        title VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) DEFAULT NULL,
        file_size VARCHAR(50) DEFAULT NULL,
        circular_no VARCHAR(100) DEFAULT NULL,
        effective_date DATE DEFAULT NULL,
        display_order INT NOT NULL DEFAULT 0,
        is_active TINYINT(1) NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_year (academic_year),
        INDEX idx_sem (semester_type),
        INDEX idx_active (is_active)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Check if empty, seed initial records as requested from institutional archive
    $stmt = $pdo->query("SELECT COUNT(*) FROM academic_calendars");
    if ($stmt->fetchColumn() == 0) {
        $initialData = [
            // [year, sem, title, file_path, file_size, display_order]
            ['2026-27', 'Odd',  'Academic Calendar 2026-27 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2026_27_odd.pdf',  '245 KB', 1],
            ['2025-26', 'Odd',  'Academic Calendar 2025-26 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2025_26_odd.pdf',  '230 KB', 2],
            ['2025-26', 'Even', 'Academic Calendar 2025-26 (Even Semesters)', 'uploads/academic_calendar/academic_calendar_2025_26_even.pdf', '215 KB', 3],
            ['2024-25', 'Odd',  'Academic Calendar 2024-25 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2024_25_odd.pdf',  '280 KB', 4],
            ['2024-25', 'Even', 'Academic Calendar 2024-25 (Even Semesters)', 'uploads/academic_calendar/academic_calendar_2024_25_even.pdf', '265 KB', 5],
            ['2023-24', 'Odd',  'Academic Calendar 2023-24 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2023_24_odd.pdf',  '310 KB', 6],
            ['2023-24', 'Even', 'Academic Calendar 2023-24 (Even Semesters)', 'uploads/academic_calendar/academic_calendar_2023_24_even.pdf', '290 KB', 7],
            ['2022-23', 'Odd',  'Academic Calendar 2022-23 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2022_23_odd.pdf',  '250 KB', 8],
            ['2022-23', 'Even', 'Academic Calendar 2022-23 (Even Semesters)', 'uploads/academic_calendar/academic_calendar_2022_23_even.pdf', '240 KB', 9],
            ['2021-22', 'Odd',  'Academic Calendar 2021-22 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2021_22_odd.pdf',  '210 KB', 10],
            ['2021-22', 'Even', 'Academic Calendar 2021-22 (Even Semesters)', 'uploads/academic_calendar/academic_calendar_2021_22_even.pdf', '205 KB', 11],
            ['2020-21', 'Odd',  'Academic Calendar 2020-21 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2020_21_odd.pdf',  '195 KB', 12],
            ['2020-21', 'Even', 'Academic Calendar 2020-21 (Even Semesters)', 'uploads/academic_calendar/academic_calendar_2020_21_even.pdf', '190 KB', 13],
            ['2019-20', 'Odd',  'Academic Calendar 2019-20 (Odd Semesters)',  'uploads/academic_calendar/academic_calendar_2019_20_odd.pdf',  '220 KB', 14],
            ['2019-20', 'Even', 'Academic Calendar 2019-20 (Even Semesters)', 'uploads/academic_calendar/academic_calendar_2019_20_even.pdf', '215 KB', 15],
        ];

        $ins = $pdo->prepare("INSERT INTO academic_calendars (academic_year, semester_type, title, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
        foreach ($initialData as $row) {
            $ins->execute($row);
        }
    }

    echo "ACADEMIC_CALENDAR_MIGRATION_SUCCESSFUL\n";
} catch (Exception $e) {
    echo "MIGRATION_ERROR: " . $e->getMessage() . "\n";
}
