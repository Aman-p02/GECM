<?php
/**
 * GEC MODASA - Cells & Initiatives Activities Helper
 * Handles database queries, schema migration, and fallback datasets for institutional cells
 */

require_once __DIR__ . '/db.php';

/**
 * Ensure cell_activities table exists in database
 */
function initCellActivitiesTable($pdo) {
    if (!$pdo) return;
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `cell_activities` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `category` VARCHAR(50) NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `activity_date` DATE DEFAULT NULL,
                `image_url` VARCHAR(255) DEFAULT NULL,
                `description` TEXT DEFAULT NULL,
                `external_url` VARCHAR(255) DEFAULT NULL,
                `display_order` INT DEFAULT 0,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX (`category`),
                INDEX (`is_active`),
                INDEX (`activity_date`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    } catch (Exception $e) {
        error_log("Cell activities table init error: " . $e->getMessage());
    }
}

/**
 * Returns comprehensive fallback data for all institutional cells and initiatives
 */
function getCellActivitiesFallbackData() {
    return [
        'ssip' => [
            [
                'id' => 101,
                'category' => 'ssip',
                'title' => 'SSIP 2.0 State-Level Innovation & Ideation Bootcamp',
                'activity_date' => '2026-09-18',
                'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'A premier 2-day intensive innovation bootcamp guiding over 150 student innovators across North Gujarat through design thinking, business model canvas, and proof-of-concept development under the Student Startup & Innovation Policy (SSIP 2.0).',
                'external_url' => '#'
            ],
            [
                'id' => 102,
                'category' => 'ssip',
                'title' => 'Prototype Grant Sanction & Mentorship Sprint',
                'activity_date' => '2025-11-10',
                'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Sanction of prototype funding and milestone grants to 14 multidisciplinary student startup projects evaluated by an expert industry scrutiny committee, enabling patent-ready hardware and software builds.',
                'external_url' => '#'
            ],
            [
                'id' => 103,
                'category' => 'ssip',
                'title' => 'IPR & Patent Drafting Awareness Workshop',
                'activity_date' => '2024-08-22',
                'image_url' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Comprehensive capacity-building workshop on Intellectual Property Rights (IPR), prior-art patent searching techniques, and provisional patent drafting procedures for engineering innovators.',
                'external_url' => '#'
            ]
        ],
        'dic' => [
            [
                'id' => 201,
                'category' => 'dic',
                'title' => 'Design Thinking & Rapid Prototyping Challenge',
                'activity_date' => '2026-08-25',
                'image_url' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Design Innovation Centre (DIC) Modasa Spoke conducted a 36-hour design sprint focused on smart automation, assistive devices, and frugal engineering solutions for regional agrarian and industrial challenges.',
                'external_url' => '#'
            ],
            [
                'id' => 202,
                'category' => 'dic',
                'title' => 'Hands-on Workshop on 3D Printing & Additive Fabrication',
                'activity_date' => '2025-07-14',
                'image_url' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Intensive technical training on 3D CAD modeling, slicing algorithms, and additive fabrication utilizing high-precision DIC 3D printers, CNC milling units, and rapid prototype fabrication tools.',
                'external_url' => '#'
            ],
            [
                'id' => 203,
                'category' => 'dic',
                'title' => 'Industrial Problem Identification & Solution Exhibition',
                'activity_date' => '2024-09-05',
                'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Exhibition showcasing student design prototypes addressing real manufacturing challenges faced by ceramic, textile, and agricultural processing enterprises in Sabarkantha and Aravalli districts.',
                'external_url' => '#'
            ]
        ],
        'rusa' => [
            [
                'id' => 301,
                'category' => 'rusa',
                'title' => 'Smart Classrooms & Digital Infrastructure Upgrade under RUSA',
                'activity_date' => '2026-06-10',
                'image_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Modernization of institutional classrooms and seminar halls with interactive smart flat panels, acoustic audio systems, and high-speed campus networking funded under RUSA Component 9 grants.',
                'external_url' => '#'
            ],
            [
                'id' => 302,
                'category' => 'rusa',
                'title' => 'Advanced Research Instrumentation & Lab Modernization',
                'activity_date' => '2025-04-22',
                'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Commissioning of precision testing instruments, high-temperature furnace units, and advanced computational workstations supported by RUSA institutional development funding.',
                'external_url' => '#'
            ],
            [
                'id' => 303,
                'category' => 'rusa',
                'title' => 'Faculty Quality Improvement & Research Capacity Building FDP',
                'activity_date' => '2024-11-18',
                'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'A state-level Faculty Development Programme aimed at enhancing research publication quality, sponsored project drafting, and emerging technology pedagogical methods.',
                'external_url' => '#'
            ]
        ],
        'gymkhana' => [
            [
                'id' => 401,
                'category' => 'gymkhana',
                'title' => 'Annual Inter-Department Sports Championship 2026',
                'activity_date' => '2026-02-14',
                'image_url' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Grand annual college athletic meet and inter-branch tournaments across Cricket, Football, Volleyball, Kabaddi, Badminton, Table Tennis, and Chess with over 600 student participants.',
                'external_url' => '#'
            ],
            [
                'id' => 402,
                'category' => 'gymkhana',
                'title' => 'GTU Zonal Inter-College Volleyball Tournament',
                'activity_date' => '2025-10-08',
                'image_url' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'GEC Modasa proudly hosted the GTU Ahmedabad-Gandhinagar Zone Inter-College Volleyball Tournament, with 16 engineering colleges competing in high-intensity matches.',
                'external_url' => '#'
            ],
            [
                'id' => 403,
                'category' => 'gymkhana',
                'title' => 'International Yoga Day & Campus Health Carnival',
                'activity_date' => '2024-06-21',
                'image_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Mass yoga demonstration, pranayama session, and fitness wellness challenge held at campus grounds promoting mental clarity, physical fitness, and holistic lifestyle for students and faculty.',
                'external_url' => '#'
            ]
        ],
        'finishing_school' => [
            [
                'id' => 501,
                'category' => 'finishing_school',
                'title' => 'Finishing School Life Skills & Employability Training (Set A & B)',
                'activity_date' => '2026-03-05',
                'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Flagship skill enhancement initiative by Knowledge Consortium of Gujarat (KCG) empowering pre-final and final-year students with professional etiquette, emotional intelligence, and corporate culture readiness.',
                'external_url' => '#'
            ],
            [
                'id' => 502,
                'category' => 'finishing_school',
                'title' => 'English Communication & Professional Presentation Bootcamp',
                'activity_date' => '2025-09-12',
                'image_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Interactive 40-hour communicative English training covering public speaking, listening skills, group discussion leadership, and elevator pitching conducted by certified KCG master trainers.',
                'external_url' => '#'
            ],
            [
                'id' => 503,
                'category' => 'finishing_school',
                'title' => 'Corporate Mock Interview & Aptitude Readiness Camp',
                'activity_date' => '2024-10-20',
                'image_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Rigorous training camp preparing students for placement recruitment drives featuring quantitative aptitude drills, technical viva simulations, and individualized HR interview feedback.',
                'external_url' => '#'
            ]
        ],
        'wdc' => [
            [
                'id' => 601,
                'category' => 'wdc',
                'title' => 'International Women\'s Day Celebration & Leadership Conclave',
                'activity_date' => '2026-03-08',
                'image_url' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Institutional celebration recognizing female engineering leaders, researchers, and student innovators. Included an inspiring keynote panel on women entrepreneurship in tech and digital economy.',
                'external_url' => '#'
            ],
            [
                'id' => 602,
                'category' => 'wdc',
                'title' => 'Self-Defense & Personal Safety Training Workshop',
                'activity_date' => '2025-12-04',
                'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Practical workshop covering physical self-defense techniques, situational risk awareness, and emergency safety protocols conducted in collaboration with District Police safety specialists.',
                'external_url' => '#'
            ],
            [
                'id' => 603,
                'category' => 'wdc',
                'title' => 'Health, Nutrition & Mental Wellbeing Seminar',
                'activity_date' => '2024-09-15',
                'image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Interactive session by medical practitioners on adolescent healthcare, balanced nutrition for academic stress management, and preventative health practices for young engineers.',
                'external_url' => '#'
            ]
        ],
        'uba' => [
            [
                'id' => 701,
                'category' => 'uba',
                'title' => 'Gram Swachhata & Village Development Baseline Survey',
                'activity_date' => '2026-01-28',
                'image_url' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Under Unnat Bharat Abhiyan (UBA 2.0), student and faculty teams visited 5 adopted villages in Modasa taluka to carry out household socio-economic surveys, sanitation audits, and basic amenity mapping.',
                'external_url' => '#'
            ],
            [
                'id' => 702,
                'category' => 'uba',
                'title' => 'Renewable Solar Energy & Water Conservation Awareness Drive',
                'activity_date' => '2025-08-19',
                'image_url' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Community outreach campaign demonstrating rooftop rainwater harvesting prototypes, solar water heaters, and agricultural water conservation techniques for village farmers.',
                'external_url' => '#'
            ],
            [
                'id' => 703,
                'category' => 'uba',
                'title' => 'Digital Literacy & Government Welfare Schemes Camp',
                'activity_date' => '2024-12-10',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Assisting rural citizens and village youth with mobile digital payments, cyber safety precautions, and online registration for PM Kisan and state agricultural welfare portals.',
                'external_url' => '#'
            ]
        ],
        'anchor_nodal' => [
            [
                'id' => 801,
                'category' => 'anchor_nodal',
                'title' => 'Advanced Skill Certification in Industrial Automation & PLC',
                'activity_date' => '2026-07-16',
                'image_url' => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Anchor Nodal Institute accredited certification program providing specialized training on Programmable Logic Controllers (PLC), SCADA integration, and electro-pneumatic drives for faculty and engineering students.',
                'external_url' => '#'
            ],
            [
                'id' => 802,
                'category' => 'anchor_nodal',
                'title' => 'Technical Capacity Building Workshop on Industry 4.0',
                'activity_date' => '2025-05-20',
                'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Upskilling technical educators and diploma teachers across North Gujarat on Industrial IoT protocols, sensor networks, and smart factory predictive maintenance concepts.',
                'external_url' => '#'
            ],
            [
                'id' => 803,
                'category' => 'anchor_nodal',
                'title' => 'Industry-Academia Collaborative Conclave & MoUs',
                'activity_date' => '2024-10-11',
                'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Strategic conclave bridging engineering academics with Gujarat manufacturing enterprises, finalizing bilateral internship partnerships, live student projects, and advanced laboratory equipment access.',
                'external_url' => '#'
            ]
        ]
    ];
}

/**
 * Fetch activities for a specific category
 */
function getCellActivities($category, $pdo = null) {
    if ($pdo) {
        initCellActivitiesTable($pdo);
        try {
            $stmt = $pdo->prepare("
                SELECT * FROM cell_activities 
                WHERE category = ? AND is_active = 1 
                ORDER BY activity_date DESC, id DESC
            ");
            $stmt->execute([$category]);
            $dbRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($dbRows)) {
                return $dbRows;
            }
        } catch (Exception $e) {
            error_log("Cell activities query error for {$category}: " . $e->getMessage());
        }
    }

    $allFallbacks = getCellActivitiesFallbackData();
    return $allFallbacks[$category] ?? [];
}

/**
 * Fetch activities for multiple combined categories (e.g. ['ssip', 'dic'] or ['wdc', 'uba'])
 */
function getCombinedCellActivities($categories, $pdo = null) {
    $result = [];
    if ($pdo) {
        initCellActivitiesTable($pdo);
        try {
            $placeholders = implode(',', array_fill(0, count($categories), '?'));
            $stmt = $pdo->prepare("
                SELECT * FROM cell_activities 
                WHERE category IN ($placeholders) AND is_active = 1 
                ORDER BY activity_date DESC, id DESC
            ");
            $stmt->execute($categories);
            $dbRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($dbRows)) {
                return $dbRows;
            }
        } catch (Exception $e) {
            error_log("Combined cell activities error: " . $e->getMessage());
        }
    }

    $allFallbacks = getCellActivitiesFallbackData();
    foreach ($categories as $cat) {
        if (!empty($allFallbacks[$cat])) {
            $result = array_merge($result, $allFallbacks[$cat]);
        }
    }

    // Sort by activity_date DESC
    usort($result, function($a, $b) {
        return strcmp($b['activity_date'] ?? '', $a['activity_date'] ?? '');
    });

    return $result;
}
