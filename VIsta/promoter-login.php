<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Next Level Sports</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header>
    <h1>Iniciar Sesión - Promotor</h1>
</header>
    <main>
        <form action="../Controller/UserController.php" method="post">
            <label>Email
                <input type="email" name="emailp" required>
            </label>

            <label>Contraseña
                <input type="password" name="passwordp"  required minlength="6">
            </label>

        <button type="submit" value="loginp" name="loginp">Iniciar Sesión como promotor</button>
    
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                ¿No tienes cuenta? <a href="role-selection.php" style="color: red; text-decoration: none;">Regístrate aquí</a>
            </p>

            <p style="text-align: center; margin-top: 0.5rem;">
                <a href="index.php" style="color: gray; text-decoration: none; font-size: 0.8rem;">← Volver al Inicio</a>
            </p>
        </form>
    </main>
</body>
</html>
