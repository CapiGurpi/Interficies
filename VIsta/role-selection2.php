<?php
session_start();
// Reset session if requested
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    unset($_SESSION['user']);
    header('Location: role-selection2.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Level Sports | Login</title>
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
        header h1 { color: red; text-transform: uppercase; }
        nav { background: rgba(0,0,0,0.8); padding: 15px; text-align: center; }
        nav a { color: white; text-decoration: none; margin: 0 15px; text-transform: uppercase; font-size: 14px; }
        main { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; }
        .main-title { margin-bottom: 40px; text-align: center; text-decoration: underline; text-underline-offset: 10px; }
        
        .card {
            background: #111;
            width: 320px;
            padding: 50px 30px;
            border-radius: 12px;
            border-left: 6px solid red;
            cursor: pointer;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 10px 40px rgba(0,0,0,0.8);
        }
        .card:hover { transform: translateY(-10px); }
        .card h3 { color: red; margin-bottom: 15px; font-size: 1.6rem; }

        .btn-visual { 
            background: linear-gradient(90deg, #ff0000 0%, #b30000 100%); 
            height: 45px; 
            width: 100%; 
            margin-top: 25px; 
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        .btn-visual::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }

        .card:hover .btn-visual {
            background: #ff0000;
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.5);
        }

        .card:hover .btn-visual::after {
            left: 100%;
        }

        .footer-link { margin-top: 40px; }
        .footer-link a { color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <header><h1>¿Eres parte de Next Level?</h1></header>
    <nav><a href="index.php">Inicio</a><a href="profile.php">Mi Perfil</a></nav>
    <main>
        <?php 

        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { 
        ?>
        <h2 class="main-title">Ya estás conectado</h2>
        <p style="text-align: center; color: #ccc; margin-top: 20px;">Accede a tu perfil desde el menú principal.</p>
        <div style="text-align: center; margin-top: 30px;">
            <form action="../Controller/UserController.php" method="post">
                <button type="submit" name="logout" value="logout" style="background: #ff0000; color: white; padding: 10px 30px; border: none; cursor: pointer; font-size: 16px;">Cerrar Sesión</button>
            </form>
        </div>
        <?php } else { ?>
        <h2 class="main-title">Clica aquí abajo para iniciar sesión</h2>
        <div class="seleccion-container">
            <article class="card" onclick="window.location.href='fan-login.php'">
                <h3>INICIAR SESIÓN</h3>
                <p>Ya tengo una cuenta de Next Level Sports</p>
                <div class="btn-visual">ENTRAR</div>
            </article>
        </div>
        <?php } ?>
        <div class="footer-link">
            <a href="role-selection.php">No tengo cuenta, volver al registro</a>
            <br><br>
            <a href="?reset=1" style="color: #999; text-decoration: none; font-size: 0.9rem;">Reset Session</a>
        </div>
    </main>
</body>
</html>