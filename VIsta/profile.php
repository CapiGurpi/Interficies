<?php
require_once __DIR__ . '/info/auth.php';

if (is_promotor()) {
    header('Location: profile_promotor.php');
    exit();
}

$user = current_user();
$userType = current_user_type();
$userInfo = current_user_info();
$maskedCard = null;

if (!$userInfo && $user) {
    require_once __DIR__ . '/../Model/NextLvlBase.php';
    $db = new Database();
    $conn = $db->getConnection();

    
    $email = $user; 

    if (is_aficionado()) {
        
        $stmt = $conn->prepare("SELECT Name AS nombre, Email AS email, Pwd AS pwd, PwdCon AS pwdcon, Sport AS deporte, 'Aficionado' AS tipo FROM aficionado WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        
       
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userInfo) {
            $_SESSION['user_info'] = $userInfo;
        }
    }
}

if ($userInfo && strtolower(trim($userInfo['tipo'])) === 'promotor' && !empty($userInfo['tarjeta'])) {
    $maskedCard = mask_credit_card($userInfo['tarjeta']);
}

if ($userInfo && strtolower(trim($userInfo['tipo'])) === 'promotor' && !empty($userInfo['tarjeta'])) {
    $cleanCard = preg_replace('/\D+/', '', $userInfo['tarjeta']);
    $maskedCard = str_repeat('*', max(0, strlen($cleanCard) - 4)) . substr($cleanCard, -4);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Next Level Sports</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Oswald', sans-serif;
            background: radial-gradient(circle, #5c0a0a 0%, #1a0202 60%, #000000 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header { background: #000; padding: 20px; text-align: center; border-bottom: 3px solid red; }
        header h1 { color: red; text-transform: uppercase; letter-spacing: 2px; }

        nav { background: rgba(0,0,0,0.8); padding: 15px; text-align: center; }
        nav a { color: white; text-decoration: none; margin: 0 15px; text-transform: uppercase; font-size: 14px; transition: 0.3s; }
        nav a:hover { color: red; }

        main { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }

        .profile-card {
            background: #111;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 15px;
            border-left: 8px solid red;
            box-shadow: 0 15px 50px rgba(0,0,0,0.9);
            position: relative;
        }

        .profile-header { text-align: center; margin-bottom: 30px; }

        .avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid red;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
        }

        .profile-header h2 { text-transform: uppercase; color: white; font-size: 1.8rem; }
        .profile-header p { color: red; font-weight: bold; letter-spacing: 1px; }

        .profile-info {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 0, 0, 0.1);
        }

        .input-field {
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 10px 12px;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
        }

        .input-field:focus {
            border-color: #ff3737;
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.12);
        }

        .message {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 10px;
            font-weight: bold;
        }

        .message.success {
            background: rgba(0, 128, 0, 0.16);
            color: #b7ffb7;
            border: 1px solid #39b739;
        }

        .message.error {
            background: rgba(255, 0, 0, 0.14);
            color: #ffb7b7;
            border: 1px solid #ff4d4d;
        }

        .info-item:last-child { border: none; }
        .label { color: #888; text-transform: uppercase; font-size: 0.8rem; }
        .value { color: #fff; font-weight: bold; }

        .password-input {
            width: 100%;
            background: transparent;
            border: none;
            color: white;
            font-size: 1rem;
            font-family: inherit;
            outline: none;
        }

        .btn-action {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 5px;
            transition: 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ff0000 0%, #b30000 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 0, 0, 0.5);
        }

        .btn-secondary {
            background: #333;
            color: #ccc;
        }

        .btn-secondary:hover { background: #444; color: white; }

        .btn-danger {
            background: #7a0000;
            color: white;
            border: 1px solid #ff4d4d;
        }

        .btn-danger:hover {
            background: #a00000;
            color: white;
        }

    </style>
</head>

<body>
    <header>
        <h1>Next Level Sports</h1>
    </header>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="profile.php">Mi Perfil</a>
        <a href="promotores-recurrentes.php">Promotores Recurrentes</a>
    </nav>

    <main>
        <div class="profile-card">
            <?php if (!empty($_SESSION['update_error'])) { ?>
                <div class="message error"><?php echo htmlspecialchars($_SESSION['update_error']); ?></div>
                <?php unset($_SESSION['update_error']); ?>
            <?php } elseif (!empty($_SESSION['update_success'])) { ?>
                <div class="message success"><?php echo htmlspecialchars($_SESSION['update_success']); ?></div>
                <?php unset($_SESSION['update_success']); ?>
            <?php } ?>

            <?php if (!$user || !$userInfo) { ?>
                <div class="profile-header">
                    <h2>No hay información de usuario.</h2>
                    <p>Por favor inicia sesión para ver tu perfil.</p>
                </div>
                <a href="fan-login.php" class="btn-action btn-primary">Iniciar Sesión</a>
            <?php } else { ?>
                <div class="profile-header">
                    <img src="assets/images/user-profile.jpg" alt="Usuario" class="avatar">
                    <h2>Nombre: <?php echo htmlspecialchars($userInfo['nombre']); ?></h2>
                    <p>Tipo de usuario: <?php echo htmlspecialchars($userInfo['tipo']); ?></p>
                </div>

                <form action="../Controller/UserController.php" method="post">
                    <div class="profile-info">
                        <div class="info-item">
                            <span class="label">Nombre:</span>
                            <span class="value"><input class="input-field" type="text" name="FanName" value="<?php echo htmlspecialchars($userInfo['nombre']); ?>" required></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Email:</span>
                            <span class="value"><input class="input-field" type="email" name="FanEmail" value="<?php echo htmlspecialchars($userInfo['email']); ?>" required></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Deporte favorito:</span>
                            <span class="value"><input class="input-field" type="text" name="FanSport" value="<?php echo htmlspecialchars($userInfo['deporte']); ?>" required></span>
                        </div>
                    </div>
                    <button type="submit" name="update" value="update" class="btn-action btn-primary">Actualizar perfil</button>
                </form>

                <a href="events/create-event.php" class="btn-action btn-primary">+ Crear Nuevo Evento</a>
                <form action="../Controller/UserController.php" method="post">
                    <button type="submit" name="logout" value="logout" class="btn-action btn-secondary">Cerrar Sesión</button>
                </form>
                <form action="../Controller/UserController.php" method="post" onsubmit="return confirm('Esta accion eliminara tu cuenta definitivamente. ¿Quieres continuar?');">
                    <button type="submit" name="delete" value="delete" class="btn-action btn-danger">Eliminar Cuenta</button>
                </form>
            <?php } ?>
        </div>
    </main>
</body>

</html>
