<?php
// php/db.php — Database connection
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // XAMPP default
define('DB_PASS', '');           // XAMPP default (empty)
define('DB_NAME', 'portfolio_db');

function getDB(): mysqli {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            http_response_code(500);
            die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}
