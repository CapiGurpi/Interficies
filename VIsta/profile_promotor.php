<?php
require_once __DIR__ . '/auth.php';

$user = current_user();
$userType = current_user_type();
$userInfo = current_user_info();
$maskedCard = null;

if (!$userInfo && $user && is_promotor()) {
    require_once __DIR__ . '/../Model/NextLvlBase.php';
    $db = new Database();
    $conn = $db->getConnection();
    $email = $conn->real_escape_string($user);

    $result = $conn->query("SELECT Name AS nombre, Email AS email, Pwd AS pwd, Pwd AS pwdcon, Direction AS direccion, CreditCard AS tarjeta, 'Promotor' AS tipo FROM promotor WHERE Email = '$email'");

    if ($result && $result->num_rows === 1) {
        $userInfo = $result->fetch_assoc();
        $_SESSION['user_info'] = $userInfo;
    }
}

if ($userInfo && strtolower(trim($userInfo['tipo'])) === 'promotor' && !empty($userInfo['tarjeta'])) {
    $maskedCard = mask_credit_card($userInfo['tarjeta']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Promotor | Next Level Sports</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Oswald', sans-serif; background: radial-gradient(circle, #5c0a0a 0%, #1a0202 60%, #000000 100%); color: white; min-height: 100vh; display: flex; flex-direction: column; }
        header { background: #000; padding: 18px 20px; text-align: center; border-bottom: 3px solid red; }
        header h1 { color: red; text-transform: uppercase; letter-spacing: 2px; }
        nav { background: rgba(0,0,0,0.8); padding: 14px; text-align: center; }
        nav a { color: white; text-decoration: none; margin: 0 14px; text-transform: uppercase; font-size: 13px; transition: 0.3s; }
        nav a:hover { color: red; }
        main { flex: 1; display: flex; align-items: center; justify-content: center; padding: 36px 20px; }
        .profile-card { background: #111; width: 100%; max-width: 520px; padding: 36px; border-radius: 15px; border-left: 8px solid red; box-shadow: 0 15px 50px rgba(0,0,0,0.9); }
        .profile-header { text-align: center; margin-bottom: 28px; }
        .avatar { width: 120px; height: 120px; border-radius: 50%; border: 4px solid red; object-fit: cover; margin-bottom: 15px; }
        .profile-header h2 { text-transform: uppercase; color: white; font-size: 1.8rem; }
        .profile-header p { color: red; font-weight: bold; letter-spacing: 1px; }
        .profile-info { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 10px; margin-bottom: 26px; }
        .info-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(255, 0, 0, 0.12); }
        .info-item:last-child { border: none; }
        .label { color: #888; text-transform: uppercase; font-size: 0.8rem; }
        .value { color: #fff; font-weight: bold; }
        .password-input { width: 100%; background: transparent; border: none; color: white; font-size: 1rem; font-family: inherit; outline: none; }
        .btn-action { display: block; width: 100%; padding: 14px; margin-top: 14px; text-align: center; text-decoration: none; font-weight: bold; text-transform: uppercase; border-radius: 5px; transition: 0.3s; cursor: pointer; border: none; }
        .btn-primary { background: linear-gradient(90deg, #ff0000 0%, #b30000 100%); color: white; box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3); }
        .btn-secondary { background: transparent; color: white; border: 1px solid #fff; }
        .btn-secondary:hover { background: #444; color: white; }
        .message { text-align: center; padding: 28px; color: white; }
    </style>
</head>
<body>
    <header>
        <h1>Perfil Promotor</h1>
    </header>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="profile.php">Mi Perfil</a>
    </nav>
    <main>
        <div class="profile-card">
            <?php if (!$user || strtolower(trim($userType)) !== 'promotor') { ?>
                <div class="message">
                    <h2>No tienes acceso a este perfil.</h2>
                    <p>Inicia sesión como promotor para ver tu información.</p>
                    <a href="fan-login.php" class="btn-action btn-primary">Iniciar Sesión</a>
                </div>
            <?php } elseif (!$userInfo) { ?>
                <div class="message">
                    <h2>No se encontró la información del promotor.</h2>
                    <p>Por favor, inténtalo de nuevo o contacta con soporte.</p>
                    <a href="index.php" class="btn-action btn-secondary">Volver</a>
                </div>
            <?php } else { ?>
                <div class="profile-header">
                    <img src="assets/images/user-profile.jpg" alt="Promotor" class="avatar">
                    <h2><?php echo htmlspecialchars($userInfo['nombre']); ?></h2>
                    <p>Promotor registrado</p>
                </div>
                <div class="profile-info">
                    <div class="info-item"><span class="label">Email:</span><span class="value"><?php echo htmlspecialchars($userInfo['email']); ?></span></div>
                    <div class="info-item"><span class="label">Contraseña:</span><span class="value"><input class="password-input" type="password" value="<?php echo htmlspecialchars($userInfo['pwd']); ?>" readonly></span></div>
                    <div class="info-item"><span class="label">Confirmar contraseña:</span><span class="value"><input class="password-input" type="password" value="<?php echo htmlspecialchars($userInfo['pwdcon']); ?>" readonly></span></div>
                    <div class="info-item"><span class="label">Dirección:</span><span class="value"><?php echo htmlspecialchars($userInfo['direccion']); ?></span></div>
                    <div class="info-item"><span class="label">Tarjeta:</span><span class="value"><?php echo htmlspecialchars($maskedCard ?? $userInfo['tarjeta']); ?></span></div>
                </div>
                <form action="../Controller/UserController.php" method="post">
                    <button type="submit" name="logout" value="logout" class="btn-action btn-secondary">Cerrar Sesión</button>
                </form>
            <?php } ?>
        </div>
    </main>
</body>
</html>
