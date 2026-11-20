<?php
/**
 * Migration script for Hostel Management Module in GECM Database
 */
require_once __DIR__ . '/../includes/db.php';

$pdo = getDBConnection();
if (!$pdo) {
    die("Database connection failed\n");
}

try {
    // 1. Table: form_status (controls whether online admission is open or closed)
    $pdo->exec("CREATE TABLE IF NOT EXISTS form_status (
        id INT PRIMARY KEY DEFAULT 1,
        is_open TINYINT(1) NOT NULL DEFAULT 0,
        academic_year VARCHAR(20) DEFAULT '2024-2025',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $stmt = $pdo->query("SELECT COUNT(*) FROM form_status WHERE id = 1");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO form_status (id, is_open, academic_year) VALUES (1, 0, '2024-2025')");
    }

    // 2. Table: hostels (Hostel blocks, capacity, round, and branch seat limits)
    $pdo->exec("CREATE TABLE IF NOT EXISTS hostels (
        id INT AUTO_INCREMENT PRIMARY KEY,
        block_name VARCHAR(50) NOT NULL,
        capacity INT NOT NULL DEFAULT 0,
        round INT NOT NULL DEFAULT 1,
        ce_seats INT NOT NULL DEFAULT 0,
        it_seats INT NOT NULL DEFAULT 0,
        ec_seats INT NOT NULL DEFAULT 0,
        mechanical_seats INT NOT NULL DEFAULT 0,
        civil_seats INT NOT NULL DEFAULT 0,
        electrical_seats INT NOT NULL DEFAULT 0,
        automobile_seats INT NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Seed default blocks if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM hostels");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO hostels (block_name, capacity, round, ce_seats, it_seats, ec_seats, mechanical_seats, civil_seats, electrical_seats, automobile_seats) VALUES
        ('A Block', 132, 1, 25, 25, 20, 22, 15, 15, 10),
        ('B Block', 132, 1, 25, 25, 20, 22, 15, 15, 10),
        ('C Block', 132, 1, 25, 25, 20, 22, 15, 15, 10),
        ('D Block', 48, 1, 10, 10, 6, 8, 6, 5, 3),
        ('E Block', 366, 1, 70, 70, 50, 60, 45, 45, 26),
        ('F Block', 96, 1, 20, 20, 14, 14, 12, 10, 6)");
    }

    // 3. Table: hostel_applications (Student submitted admission applications)
    $pdo->exec("CREATE TABLE IF NOT EXISTS hostel_applications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_name VARCHAR(150) NOT NULL,
        current_sem VARCHAR(20) NOT NULL DEFAULT '1',
        branch VARCHAR(50) NOT NULL,
        acpc_merit_rank VARCHAR(20) NOT NULL,
        admission_year VARCHAR(10) NOT NULL,
        gender VARCHAR(20) NOT NULL DEFAULT 'Male',
        category VARCHAR(50) NOT NULL DEFAULT 'Open',
        father_name VARCHAR(150) NOT NULL,
        district VARCHAR(100) NOT NULL,
        taluka VARCHAR(100) NOT NULL,
        perm_address TEXT,
        contact_number VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL,
        local_address TEXT,
        annual_income VARCHAR(50),
        last_exam VARCHAR(50),
        passing_year VARCHAR(10),
        result_percent VARCHAR(20),
        photo_path VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_acpc_rank (acpc_merit_rank),
        INDEX idx_branch (branch),
        INDEX idx_category (category)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // 4. Table: allocation_list (Allocated / shortlisted candidates list)
    $pdo->exec("CREATE TABLE IF NOT EXISTS allocation_list (
        id INT PRIMARY KEY,
        student_name VARCHAR(150) NOT NULL,
        current_sem VARCHAR(20) NOT NULL,
        branch VARCHAR(50) NOT NULL,
        acpc_merit_rank VARCHAR(20) NOT NULL,
        admission_year VARCHAR(10) NOT NULL,
        gender VARCHAR(20) NOT NULL,
        category VARCHAR(50) NOT NULL,
        father_name VARCHAR(150) NOT NULL,
        district VARCHAR(100) NOT NULL,
        taluka VARCHAR(100) NOT NULL,
        perm_address TEXT,
        contact_number VARCHAR(20) NOT NULL,
        local_address TEXT,
        hostel_block VARCHAR(50) NOT NULL,
        annual_income VARCHAR(50),
        last_exam VARCHAR(50),
        passing_year VARCHAR(10),
        result_percent VARCHAR(20),
        photo_path VARCHAR(255),
        created_at DATETIME,
        round INT NOT NULL DEFAULT 1,
        reference_no VARCHAR(50) DEFAULT '',
        status ENUM('pending', 'Confirm', 'Cancelled') NOT NULL DEFAULT 'pending',
        reporting_deadline DATE,
        hostel_room VARCHAR(20) DEFAULT NULL,
        INDEX idx_status (status),
        INDEX idx_block_round (hostel_block, round)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // 5. Table: location (Gujarat Districts, Talukas & distance from Modasa in KM)
    $pdo->exec("CREATE TABLE IF NOT EXISTS location (
        id INT AUTO_INCREMENT PRIMARY KEY,
        District VARCHAR(100) NOT NULL,
        Taluka VARCHAR(100) NOT NULL,
        Distance_From_Modasa INT NOT NULL DEFAULT 0,
        INDEX idx_dist_tal (District, Taluka)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Seed location data if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM location");
    if ($stmt->fetchColumn() == 0) {
        $locations = [
            ['Aravalli', 'Modasa', 0],
            ['Aravalli', 'Bayad', 45],
            ['Aravalli', 'Dhansura', 18],
            ['Aravalli', 'Malpur', 22],
            ['Aravalli', 'Meghraj', 35],
            ['Aravalli', 'Bhiloda', 30],
            ['Sabarkantha', 'Himatnagar', 42],
            ['Sabarkantha', 'Idar', 58],
            ['Sabarkantha', 'Prantij', 52],
            ['Sabarkantha', 'Talod', 40],
            ['Sabarkantha', 'Khedbrahma', 85],
            ['Sabarkantha', 'Vadali', 70],
            ['Sabarkantha', 'Vijaynagar', 65],
            ['Sabarkantha', 'Poshina', 105],
            ['Gandhinagar', 'Gandhinagar', 85],
            ['Gandhinagar', 'Kalol', 105],
            ['Gandhinagar', 'Dahegam', 65],
            ['Gandhinagar', 'Mansa', 80],
            ['Ahmedabad', 'Ahmedabad City', 105],
            ['Ahmedabad', 'Daskroi', 110],
            ['Ahmedabad', 'Sanand', 130],
            ['Ahmedabad', 'Dholka', 145],
            ['Ahmedabad', 'Bavla', 140],
            ['Ahmedabad', 'Viramgam', 165],
            ['Ahmedabad', 'Mandal', 170],
            ['Ahmedabad', 'Detroj-Rampura', 150],
            ['Ahmedabad', 'Dhandhuka', 210],
            ['Mehsana', 'Mehsana', 115],
            ['Mehsana', 'Visnagar', 95],
            ['Mehsana', 'Kadi', 125],
            ['Mehsana', 'Vadnagar', 85],
            ['Mehsana', 'Kheralu', 90],
            ['Mehsana', 'Satlasana', 80],
            ['Mehsana', 'Unjha', 120],
            ['Mehsana', 'Becharaji', 155],
            ['Patan', 'Patan', 150],
            ['Patan', 'Sidhpur', 135],
            ['Patan', 'Chanasma', 155],
            ['Patan', 'Radhanpur', 225],
            ['Patan', 'Harij', 175],
            ['Patan', 'Sami', 195],
            ['Banaskantha', 'Palanpur', 130],
            ['Banaskantha', 'Deesa', 155],
            ['Banaskantha', 'Dhanera', 185],
            ['Banaskantha', 'Tharad', 220],
            ['Banaskantha', 'Vav', 250],
            ['Banaskantha', 'Danta', 105],
            ['Banaskantha', 'Vadgam', 115],
            ['Banaskantha', 'Amirgadh', 160],
            ['Banaskantha', 'Dantiwada', 150],
            ['Banaskantha', 'Kankrej', 180],
            ['Banaskantha', 'Deodar', 190],
            ['Banaskantha', 'Bhabhar', 215],
            ['Mahisagar', 'Lunawada', 48],
            ['Mahisagar', 'Santrampur', 72],
            ['Mahisagar', 'Balasinor', 60],
            ['Mahisagar', 'Virpur', 45],
            ['Mahisagar', 'Khanpur', 65],
            ['Mahisagar', 'Kadana', 80],
            ['Panchmahal', 'Godhra', 85],
            ['Panchmahal', 'Halol', 125],
            ['Panchmahal', 'Kalol', 105],
            ['Panchmahal', 'Shehera', 75],
            ['Panchmahal', 'Morva Hadaf', 95],
            ['Panchmahal', 'Ghoghamba', 115],
            ['Panchmahal', 'Jambughoda', 140],
            ['Dahod', 'Dahod', 135],
            ['Dahod', 'Jhalod', 110],
            ['Dahod', 'Fatepura', 95],
            ['Dahod', 'Limkheda', 115],
            ['Dahod', 'Garbada', 150],
            ['Dahod', 'Devgadbaria', 130],
            ['Dahod', 'Dhanpur', 145],
            ['Dahod', 'Sanjeli', 105],
            ['Kheda', 'Nadiad', 98],
            ['Kheda', 'Kapadvanj', 40],
            ['Kheda', 'Kathlal', 55],
            ['Kheda', 'Mahudha', 75],
            ['Kheda', 'Thasra', 68],
            ['Kheda', 'Dakor', 72],
            ['Kheda', 'Mehmedabad', 90],
            ['Kheda', 'Kheda', 105],
            ['Kheda', 'Matar', 120],
            ['Kheda', 'Vaso', 110],
            ['Anand', 'Anand', 115],
            ['Anand', 'Umreth', 85],
            ['Anand', 'Petlad', 135],
            ['Anand', 'Khambhat', 170],
            ['Anand', 'Borsad', 145],
            ['Anand', 'Anklav', 140],
            ['Anand', 'Tarapur', 155],
            ['Anand', 'Sojitra', 130],
            ['Vadodara', 'Vadodara City', 150],
            ['Vadodara', 'Padra', 165],
            ['Vadodara', 'Karjan', 185],
            ['Vadodara', 'Dabhoi', 175],
            ['Vadodara', 'Waghodia', 155],
            ['Vadodara', 'Savli', 120],
            ['Vadodara', 'Desar', 105],
            ['Vadodara', 'Shinshin', 190],
            ['Bharuch', 'Bharuch', 225],
            ['Bharuch', 'Ankleshwar', 235],
            ['Bharuch', 'Jambusar', 200],
            ['Bharuch', 'Amod', 210],
            ['Bharuch', 'Vagra', 240],
            ['Bharuch', 'Hansot', 255],
            ['Bharuch', 'Valia', 260],
            ['Bharuch', 'Jhagadia', 250],
            ['Narmada', 'Rajpipla', 230],
            ['Narmada', 'Dediapada', 270],
            ['Narmada', 'Tilakwada', 210],
            ['Narmada', 'Garudeshwar', 225],
            ['Narmada', 'Sagbara', 290],
            ['Surat', 'Surat City', 295],
            ['Surat', 'Olpad', 285],
            ['Surat', 'Kamrej', 280],
            ['Surat', 'Bardoli', 310],
            ['Surat', 'Choryasi', 305],
            ['Surat', 'Palsana', 305],
            ['Surat', 'Mahuva', 335],
            ['Surat', 'Mandvi', 290],
            ['Surat', 'Mangrol', 270],
            ['Surat', 'Umarpada', 300],
            ['Navsari', 'Navsari', 330],
            ['Navsari', 'Gandevi', 345],
            ['Navsari', 'Chikhli', 355],
            ['Navsari', 'Jalalpore', 335],
            ['Navsari', 'Vansda', 380],
            ['Navsari', 'Khergam', 365],
            ['Valsad', 'Valsad', 370],
            ['Valsad', 'Pardi', 385],
            ['Valsad', 'Vapi', 400],
            ['Valsad', 'Umbergaon', 425],
            ['Valsad', 'Dharampur', 390],
            ['Valsad', 'Kaprada', 415],
            ['Tapi', 'Vyara', 330],
            ['Tapi', 'Songadh', 320],
            ['Tapi', 'Valod', 325],
            ['Tapi', 'Uchchhal', 355],
            ['Tapi', 'Nizar', 375],
            ['Tapi', 'Kukurmunda', 390],
            ['Tapi', 'Dolvan', 345],
            ['Dang', 'Ahwa', 405],
            ['Dang', 'Waghai', 385],
            ['Dang', 'Subir', 415],
            ['Surendranagar', 'Surendranagar', 215],
            ['Surendranagar', 'Wadhwan', 215],
            ['Surendranagar', 'Dhrangadhra', 230],
            ['Surendranagar', 'Limbdi', 195],
            ['Surendranagar', 'Chotila', 255],
            ['Surendranagar', 'Dasada (Patdi)', 180],
            ['Surendranagar', 'Lakhtar', 190],
            ['Surendranagar', 'Sayla', 235],
            ['Surendranagar', 'Muli', 235],
            ['Surendranagar', 'Thangadh', 255],
            ['Rajkot', 'Rajkot City', 315],
            ['Rajkot', 'Gondal', 345],
            ['Rajkot', 'Jetpur', 375],
            ['Rajkot', 'Dhoraji', 395],
            ['Rajkot', 'Upleta', 415],
            ['Rajkot', 'Jasdan', 300],
            ['Rajkot', 'Kotda Sangani', 340],
            ['Rajkot', 'Lodhika', 330],
            ['Rajkot', 'Paddhari', 335],
            ['Rajkot', 'Vinchhiya', 285],
            ['Morbi', 'Morbi', 285],
            ['Morbi', 'Wankaner', 275],
            ['Morbi', 'Halvad', 240],
            ['Morbi', 'Tankara', 300],
            ['Morbi', 'Maliya Miyana', 290],
            ['Jamnagar', 'Jamnagar City', 400],
            ['Jamnagar', 'Dhrol', 360],
            ['Jamnagar', 'Jodiya', 345],
            ['Jamnagar', 'Kalavad', 365],
            ['Jamnagar', 'Lalpur', 425],
            ['Jamnagar', 'Jamjodhpur', 440],
            ['Devbhumi Dwarka', 'Khambhalia', 450],
            ['Devbhumi Dwarka', 'Kalyanpur', 490],
            ['Devbhumi Dwarka', 'Bhanvad', 430],
            ['Devbhumi Dwarka', 'Dwarka (Okhamandal)', 525],
            ['Porbandar', 'Porbandar', 485],
            ['Porbandar', 'Ranavav', 465],
            ['Porbandar', 'Kutiyana', 445],
            ['Junagadh', 'Junagadh City', 415],
            ['Junagadh', 'Keshod', 450],
            ['Junagadh', 'Mangrol', 480],
            ['Junagadh', 'Manavadar', 435],
            ['Junagadh', 'Vanthali', 425],
            ['Junagadh', 'Visavadar', 395],
            ['Junagadh', 'Bhesan', 375],
            ['Junagadh', 'Mendarda', 435],
            ['Junagadh', 'Malia Hatina', 465],
            ['Gir Somnath', 'Veraval (Patan)', 470],
            ['Gir Somnath', 'Talala', 450],
            ['Gir Somnath', 'Kodinar', 445],
            ['Gir Somnath', 'Sutrapada', 465],
            ['Gir Somnath', 'Una', 440],
            ['Gir Somnath', 'Gir Gadhada', 430],
            ['Amreli', 'Amreli', 340],
            ['Amreli', 'Dhari', 375],
            ['Amreli', 'Bagasara', 355],
            ['Amreli', 'Savarkundla', 365],
            ['Amreli', 'Rajula', 405],
            ['Amreli', 'Jafrabad', 430],
            ['Amreli', 'Lathi', 320],
            ['Amreli', 'Lilia', 335],
            ['Amreli', 'Babra', 305],
            ['Amreli', 'Khambha', 395],
            ['Amreli', 'Kunkavav Vadia', 345],
            ['Bhavnagar', 'Bhavnagar City', 265],
            ['Bhavnagar', 'Sihor', 270],
            ['Bhavnagar', 'Palitana', 300],
            ['Bhavnagar', 'Gariadhar', 325],
            ['Bhavnagar', 'Talaja', 315],
            ['Bhavnagar', 'Mahuva', 355],
            ['Bhavnagar', 'Vallabhipur', 235],
            ['Bhavnagar', 'Umrala', 250],
            ['Bhavnagar', 'Ghogha', 280],
            ['Bhavnagar', 'Jesar', 335],
            ['Botad', 'Botad', 230],
            ['Botad', 'Gadhada', 255],
            ['Botad', 'Barwala', 205],
            ['Botad', 'Ranpur', 195],
            ['Kutch', 'Bhuj', 415],
            ['Kutch', 'Gandhidham', 365],
            ['Kutch', 'Anjar', 375],
            ['Kutch', 'Mandvi', 465],
            ['Kutch', 'Mundra', 420],
            ['Kutch', 'Nakhatrana', 460],
            ['Kutch', 'Abdasa (Naliya)', 510],
            ['Kutch', 'Lakhpat', 545],
            ['Kutch', 'Rapar', 305],
            ['Kutch', 'Bhachau', 335],
            ['Chhotaudepur', 'Chhotaudepur', 195],
            ['Chhotaudepur', 'Bodeli', 170],
            ['Chhotaudepur', 'Jetpur Pavi', 180],
            ['Chhotaudepur', 'Kavant', 215],
            ['Chhotaudepur', 'Nasvadi', 190],
            ['Chhotaudepur', 'Sankheda', 165]
        ];

        $insLoc = $pdo->prepare("INSERT INTO location (District, Taluka, Distance_From_Modasa) VALUES (?, ?, ?)");
        foreach ($locations as $loc) {
            $insLoc->execute($loc);
        }
    }

    // 6. Ensure 'hostel' user exists in 'admins' table with role 'hostel_admin'
    // First, verify columns of admins table
    $stmt = $pdo->query("SHOW COLUMNS FROM admins LIKE 'role'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE admins ADD COLUMN role VARCHAR(50) DEFAULT 'super_admin'");
    }

    $passHash = password_hash('123', PASSWORD_BCRYPT);
    $checkHostel = $pdo->prepare("SELECT id FROM admins WHERE username = 'hostel'");
    $checkHostel->execute();
    if ($checkHostel->rowCount() == 0) {
        $ins = $pdo->prepare("INSERT INTO admins (username, email, password_hash, role, is_active, created_at) VALUES ('hostel', 'hostel@gecmodasa.ac.in', ?, 'hostel_admin', 1, NOW())");
        $ins->execute([$passHash]);
    } else {
        $upd = $pdo->prepare("UPDATE admins SET password_hash = ?, role = 'hostel_admin', is_active = 1 WHERE username = 'hostel'");
        $upd->execute([$passHash]);
    }

    echo "MIGRATION_SUCCESSFUL\n";
} catch (Exception $e) {
    echo "MIGRATION_ERROR: " . $e->getMessage() . "\n";
}
