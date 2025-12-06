<?php
session_start();
require_once("../backend/db.php");

// Check if logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Force CSV download
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=admissions_export_" . date("Y-m-d") . ".csv");

$output = fopen("php://output", "w");

// CSV column titles (match your DB structure)
fputcsv($output, [
    'ID', 'Student Name', 'Class', 'Date of Birth', 'Gender',
    'Parent Name', 'Relationship', 'Contact Number', 'Email',
    'Address', 'Previous School', 'Status', 'Date Applied', 'Updated At'
]);

// Fetch all records
$query = mysqli_query($conn, "SELECT * FROM admissions ORDER BY id DESC");

// Write each row into CSV
while ($row = mysqli_fetch_assoc($query)) {
    fputcsv($output, [
        $row['id'],
        $row['student_name'],
        $row['class'],
        $row['dob'],
        $row['gender'],
        $row['parent_name'],
        $row['relationship'],
        $row['contact'],
        $row['email'],
        $row['address'],
        $row['previous_school'],
        $row['status'],
        $row['date_applied'],
        $row['updated_at']
    ]);
}

fclose($output);
exit;
?>
