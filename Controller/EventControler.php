<?php
require_once __DIR__ . '/../Model/NextLvlBase.php';

$db = new Database();
$conn = $db->getConnection();
$errors = [];
$message = $_GET['message'] ?? '';
$editingEvent = null;
$postedEvent = null;

function clean_text($value)
{
    return trim((string) $value);
}

function redirect_with_message($message)
{
    header('Location: create-event.php?message=' . urlencode($message));
    exit();
}

function ensure_event_table_schema($conn)
{
    $conn->exec(
        'CREATE TABLE IF NOT EXISTS evento (
            Id int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            Name varchar(50) NOT NULL,
            Sport varchar(60) NOT NULL,
            `Date` date NULL,
            Location varchar(100) NULL,
            Price decimal(10,2) NULL,
            Description text
        )'
    );

    $requiredColumns = [
        'Name' => 'ALTER TABLE evento ADD COLUMN Name varchar(50) NOT NULL',
        'Sport' => 'ALTER TABLE evento ADD COLUMN Sport varchar(60) NOT NULL',
        'Date' => 'ALTER TABLE evento ADD COLUMN `Date` date NULL',
        'Location' => 'ALTER TABLE evento ADD COLUMN Location varchar(100) NULL',
        'Price' => 'ALTER TABLE evento ADD COLUMN Price decimal(10,2) NULL',
        'Description' => 'ALTER TABLE evento ADD COLUMN Description text',
    ];

    $stmt = $conn->prepare(
        'SELECT COUNT(*)
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = "evento"
           AND COLUMN_NAME = :column_name'
    );

    foreach ($requiredColumns as $columnName => $alterSql) {
        $stmt->execute([':column_name' => $columnName]);

        if ((int) $stmt->fetchColumn() === 0) {
            $conn->exec($alterSql);
        }
    }
}
ensure_event_table_schema($conn);

$editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
 
if ($editId) {
    $stmt = $conn->prepare('SELECT * FROM evento WHERE Id = :id');
    $stmt->execute([':id' => $editId]);
    $editingEvent = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $conn->query('SELECT * FROM evento ORDER BY `Date` DESC, Id DESC');
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
$formValues = [
    'Id' => $editingEvent['Id'] ?? '',
    'Name' => $postedEvent['Name'] ?? $editingEvent['Name'] ?? '',
    'Sport' => $postedEvent['Sport'] ?? $editingEvent['Sport'] ?? '',
    'Date' => $postedEvent['Date'] ?? $editingEvent['Date'] ?? '',
    'Location' => $postedEvent['Location'] ?? $editingEvent['Location'] ?? '',
    'Price' => $postedEvent['Price'] ?? $editingEvent['Price'] ?? '',
    'Description' => $postedEvent['Description'] ?? $editingEvent['Description'] ?? '',
];