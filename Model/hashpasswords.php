<?php
/**
 * Script to hash existing plain text passwords
 * Run this once after updating the database schema
 */

require_once 'NextLvlBase.php';

$db = new Database();
$conn = $db->getConnection();

try {
    $conn->exec("ALTER TABLE aficionado MODIFY COLUMN Pwd VARCHAR(255) NOT NULL");
    $conn->exec("ALTER TABLE aficionado MODIFY COLUMN PwdCon VARCHAR(255) NOT NULL");
    $conn->exec("ALTER TABLE promotor MODIFY COLUMN Pwd VARCHAR(255) NOT NULL");

    // Update aficionado passwords
    $stmt = $conn->query("SELECT Id, Pwd FROM aficionado");
    $aficionados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($aficionados as $user) {
        if (password_get_info($user['Pwd'])['algo'] !== 0) {
            continue;
        }

        $hashedPassword = password_hash($user['Pwd'], PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE aficionado SET Pwd = :pwd, PwdCon = :pwdcon WHERE Id = :id");
        $updateStmt->execute([
            ':pwd' => $hashedPassword,
            ':pwdcon' => $hashedPassword,
            ':id' => $user['Id']
        ]);
    }

    // Update promotor passwords
    $stmt = $conn->query("SELECT Id, Pwd FROM promotor");
    $promotors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($promotors as $user) {
        if (password_get_info($user['Pwd'])['algo'] !== 0) {
            continue;
        }

        $hashedPassword = password_hash($user['Pwd'], PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE promotor SET Pwd = :pwd WHERE Id = :id");
        $updateStmt->execute([
            ':pwd' => $hashedPassword,
            ':id' => $user['Id']
        ]);
    }

    echo "Hashing completed successfully! All passwords have been hashed.";

} catch (PDOException $e) {
    die("Hashing failed: " . $e->getMessage());
}
?>
