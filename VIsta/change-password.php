<?php
require_once __DIR__ . '/info/auth.php';

if (!is_logged_in()) {
    header('Location: fan-login.php');
    exit();
}

$backLink = is_promotor() ? 'profile_promotor.php' : 'profile.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña | Next Level Sports</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Oswald', sans-serif; background: radial-gradient(circle, #5c0a0a 0%, #1a0202 60%, #000 100%); color: white; min-height: 100vh; display: flex; flex-direction: column; }
        header { background: #000; padding: 20px; text-align: center; border-bottom: 3px solid red; }
        header h1 { color: red; text-transform: uppercase; letter-spacing: 2px; }
        main { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
        .card { width: 100%; max-width: 460px; background: rgba(17, 17, 17, 0.95); border-radius: 18px; border-left: 7px solid red; box-shadow: 0 20px 60px rgba(0,0,0,0.65); padding: 36px; }
        .card h2 { margin-bottom: 18px; color: #fff; font-size: 1.9rem; text-transform: uppercase; }
        .card p { margin-bottom: 24px; color: #d1d1d1; line-height: 1.5; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #c7c7c7; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input { width: 100%; padding: 14px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15); background: rgba(255,255,255,0.06); color: white; font-size: 1rem; }
        .form-group input:focus { outline: none; border-color: #ff3737; box-shadow: 0 0 0 4px rgba(255,0,0,0.12); }
        .message { margin-bottom: 24px; padding: 16px 18px; border-radius: 12px; font-weight: bold; }
        .message.success { background: rgba(0, 128, 0, 0.16); color: #b7ffb7; border: 1px solid #39b739; }
        .message.error { background: rgba(255, 0, 0, 0.16); color: #ffb7b7; border: 1px solid #ff4d4d; }
        .btn { width: 100%; padding: 15px; border: none; border-radius: 10px; color: white; font-weight: bold; text-transform: uppercase; cursor: pointer; transition: 0.25s ease; }
        .btn-primary { background: linear-gradient(90deg, #ff0000 0%, #b30000 100%); box-shadow: 0 10px 25px rgba(255,0,0,0.25); }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-secondary { margin-top: 14px; background: transparent; border: 1px solid #fff; color: #fff; }
        .btn-secondary:hover { background: #333; }
        .back-link { display: inline-block; margin-top: 20px; color: #fff; text-decoration: none; font-size: 0.95rem; }
    </style>
</head>
<body>
    <header>
        <h1>Cambiar Contraseña</h1>
    </header>
    <main>
        <div class="card">
            <?php if (!empty($_SESSION['password_error'])) { ?>
                <div class="message error"><?php echo htmlspecialchars($_SESSION['password_error']); ?></div>
                <?php unset($_SESSION['password_error']); ?>
            <?php } elseif (!empty($_SESSION['password_success'])) { ?>
                <div class="message success"><?php echo htmlspecialchars($_SESSION['password_success']); ?></div>
                <?php unset($_SESSION['password_success']); ?>
            <?php } ?>

            <h2>Establece una nueva contraseña</h2>
            <p>Ingresa una contraseña segura y confírmala. La contraseña se guardará cifrada en la base de datos.</p>

            <form action="../Controller/UserController.php" method="post">
                <div class="form-group">
                    <label for="new_password">Nueva contraseña</label>
                    <input id="new_password" name="new_password" type="password" required minlength="6" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar contraseña</label>
                    <input id="confirm_password" name="confirm_password" type="password" required minlength="6" autocomplete="new-password">
                </div>
                <button type="submit" name="change_password" value="change_password" class="btn btn-primary">Guardar nueva contraseña</button>
            </form>

            <a href="<?php echo $backLink; ?>" class="btn btn-secondary">Volver al perfil</a>
        </div>
    </main>
</body>
</html>
