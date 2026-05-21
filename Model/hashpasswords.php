<?php
/**
 * Script to hash existing plain text passwords
 * Run this once after updating the database schema
 */

require_once 'NextLvlBase.php';

$db = new Database();
$conn = $db->getConnection();

try {
    // Update aficionado passwords
    $stmt = $conn->query("SELECT Id, Pwd FROM aficionado WHERE LENGTH(Pwd) < 60"); // Plain text passwords are shorter than hashes
    $aficionados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($aficionados as $user) {
        $hashedPassword = password_hash($user['Pwd'], PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE aficionado SET Pwd = :pwd, PwdCon = :pwdcon WHERE Id = :id");
        $updateStmt->execute([
            ':pwd' => $hashedPassword,
            ':pwdcon' => $hashedPassword,
            ':id' => $user['Id']
        ]);
    }

    // Update promotor passwords
    $stmt = $conn->query("SELECT Id, Pwd FROM promotor WHERE LENGTH(Pwd) < 60");
    $promotors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($promotors as $user) {
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
