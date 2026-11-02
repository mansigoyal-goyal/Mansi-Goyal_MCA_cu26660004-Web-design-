<?php
// Q17: Stream a CSV download; no HTML output should be sent before headers.
require_once 'includes/db.php';
try {
    $rows = getPDO()->query('SELECT id, name, email, enrollment_date FROM students ORDER BY id')->fetchAll();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="students.csv"');
    $output = fopen('php://output', 'w');
    // UTF-8 BOM helps spreadsheet applications detect encoding.
    fwrite($output, "\xEF\xBB\xBF");
    fputcsv($output, ['ID', 'Name', 'Email', 'Enrollment Date']);
    foreach ($rows as $row) fputcsv($output, $row);
    fclose($output);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo 'CSV export failed. Check the database connection and students table.';
}
