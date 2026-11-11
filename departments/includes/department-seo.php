<?php
/**
 * Structured Data Helper for Department Pages
 * Generates Schema.org EducationalOrganization / Department JSON-LD
 */
$deptSchema = [
    "@context" => "https://schema.org",
    "@type" => "EducationalOrganization",
    "name" => "Department of " . ($deptName ?? 'Engineering'),
    "parentOrganization" => [
        "@type" => "CollegeOrUniversity",
        "name" => "Government Engineering College, Modasa",
        "url" => "https://gecmodasa.ac.in"
    ],
    "description" => "Academic Department of " . ($deptName ?? '') . " offering undergraduate engineering degrees affiliated with Gujarat Technological University (GTU).",
    "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "Shamlaji Road",
        "addressLocality" => "Modasa",
        "addressRegion" => "Gujarat",
        "postalCode" => "383315",
        "addressCountry" => "IN"
    ]
];
?>
<script type="application/ld+json">
<?= json_encode($deptSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>

