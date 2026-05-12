<?php
// php/get_projects.php — Returns projects as JSON (AJAX endpoint)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/db.php';

$db = getDB();
$result = $db->query("SELECT * FROM projects ORDER BY sort_order ASC, created_at DESC");

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

echo json_encode($projects);
