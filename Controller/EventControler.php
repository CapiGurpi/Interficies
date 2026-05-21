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
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    $postedEvent = [
        'Id' => filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT),
        'Name' => clean_text(filter_input(INPUT_POST, 'Name', FILTER_UNSAFE_RAW)),
        'Sport' => clean_text(filter_input(INPUT_POST, 'Sport', FILTER_UNSAFE_RAW)),
        'Date' => clean_text(filter_input(INPUT_POST, 'Date', FILTER_UNSAFE_RAW)),
        'Location' => clean_text(filter_input(INPUT_POST, 'Location', FILTER_UNSAFE_RAW)),
        'Price' => clean_text(filter_input(INPUT_POST, 'Price', FILTER_UNSAFE_RAW)),
        'Description' => clean_text(filter_input(INPUT_POST, 'Description', FILTER_UNSAFE_RAW)),
    ];
 
    if ($action === 'create' || $action === 'update') {
        if ($postedEvent['Name'] === '') {
            $errors[] = 'El nombre del evento es obligatorio.';
        }
        if ($postedEvent['Sport'] === '') {
            $errors[] = 'El deporte es obligatorio.';
        }
        if ($postedEvent['Date'] === '') {
            $errors[] = 'La fecha del evento es obligatoria.';
        }
        if ($postedEvent['Location'] === '') {
            $errors[] = 'La ubicación es obligatoria.';
        }
        if ($postedEvent['Price'] === '') {
            $errors[] = 'El precio es obligatorio.';
        } elseif (!is_numeric($postedEvent['Price']) || (float) $postedEvent['Price'] < 0) {
            $errors[] = 'El precio debe ser un número válido mayor o igual a 0.';
        }
        if ($postedEvent['Description'] === '') {
            $errors[] = 'La descripción es obligatoria.';
        }
 
        if (empty($errors)) {
            try {
                if ($action === 'create') {
                    $stmt = $conn->prepare(
                        'INSERT INTO evento (Name, Sport, `Date`, Location, Price, Description)
                         VALUES (:Name, :Sport, :Date, :Location, :Price, :Description)'
                    );
                    $stmt->execute([
                        ':Name' => $postedEvent['Name'],
                        ':Sport' => $postedEvent['Sport'],
                        ':Date' => $postedEvent['Date'],
                        ':Location' => $postedEvent['Location'],
                        ':Price' => $postedEvent['Price'],
                        ':Description' => $postedEvent['Description'],
                    ]);
                    redirect_with_message('Evento creado correctamente.');
                }
 
                if ($action === 'update') {
                    if (!$postedEvent['Id']) {
                        $errors[] = 'ID de evento inválido para actualizar.';
                    } else {
                        $stmt = $conn->prepare(
                            'UPDATE evento
                             SET Name = :Name,
                                 Sport = :Sport,
                                 `Date` = :Date,
                                 Location = :Location,
                                 Price = :Price,
                                 Description = :Description
                             WHERE Id = :Id'
                        );
                        $stmt->execute([
                            ':Name' => $postedEvent['Name'],
                            ':Sport' => $postedEvent['Sport'],
                            ':Date' => $postedEvent['Date'],
                            ':Location' => $postedEvent['Location'],
                            ':Price' => $postedEvent['Price'],
                            ':Description' => $postedEvent['Description'],
                            ':Id' => $postedEvent['Id'],
                        ]);
                        redirect_with_message('Evento actualizado correctamente.');
                    }
                }
            } catch (PDOException $e) {
                $errors[] = 'Error al guardar el evento: ' . $e->getMessage();
            }
        }
    }
 
    if ($action === 'delete') {
        $deleteId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
 
        if (!$deleteId) {
            $errors[] = 'ID de evento inválido para eliminar.';
        } else {
            try {
                $stmt = $conn->prepare('DELETE FROM evento WHERE Id = :id');
                $stmt->execute([':id' => $deleteId]);
                redirect_with_message('Evento eliminado correctamente.');
            } catch (PDOException $e) {
                $errors[] = 'Error al eliminar el evento: ' . $e->getMessage();
            }
        }
    }
}
 
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