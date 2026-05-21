<?php
/**
 * Diagnostic helper to verify password hash support and login hashing state.
 * Usage:
 *   php check_hash_login.php
 *   http://localhost/myweb/Interficies/Model/check_hash_login.php?email=test@example.com&userType=Aficionado&password=secret
 */

require_once 'NextLvlBase.php';

function safeGet(string $key): ?string {
    return isset($_GET[$key]) && trim($_GET[$key]) !== '' ? trim($_GET[$key]) : null;
}

$response = [
    'php_version' => phpversion(),
    'password_hash_available' => function_exists('password_hash'),
    'password_verify_available' => function_exists('password_verify'),
    'columns' => [],
    'exceptions' => [],
    'sample_check' => null,
];

try {
    $db = new Database();
    $conn = $db->getConnection();

    $tables = [
        'aficionado' => ['Pwd', 'PwdCon'],
        'promotor' => ['Pwd'],
        'Users' => ['Pwd'],
    ];

    foreach ($tables as $table => $columns) {
        foreach ($columns as $column) {
            $stmt = $conn->prepare("SHOW COLUMNS FROM {$table} LIKE :col");
            $stmt->execute([':col' => $column]);
            $info = $stmt->fetch(PDO::FETCH_ASSOC);
            $response['columns'][$table][$column] = $info ?: null;
        }
    }

    $checkEmail = safeGet('email');
    $checkType = safeGet('userType');
    $checkPassword = safeGet('password');

    if ($checkEmail && $checkType && $checkPassword) {
        $table = $checkType === 'Promotor' ? 'promotor' : 'aficionado';
        $stmt = $conn->prepare("SELECT Id, Email, Pwd FROM {$table} WHERE Email = :email");
        $stmt->execute([':email' => $checkEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $valid = password_verify($checkPassword, $user['Pwd']);
            $response['sample_check'] = [
                'table' => $table,
                'email' => $user['Email'],
                'id' => $user['Id'],
                'pwd_length' => strlen($user['Pwd']),
                'pwd_value' => $user['Pwd'],
                'password_verify' => $valid,
            ];
        } else {
            $response['sample_check'] = [
                'error' => 'Usuario no encontrado en la tabla ' . $table,
            ];
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    $response['exceptions'][] = $e->getMessage();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
