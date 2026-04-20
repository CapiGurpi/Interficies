<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Next Level Sports</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        @media (min-width: 1024px) {
            .registro-container {
                display: flex;
                gap: 2rem;
                justify-content: center;
                align-items: flex-start;
            }
        }
        .form-title {
            text-align: center;
            color: red;
            margin-bottom: 1rem;
            text-transform: uppercase;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<header>
    <h1>Únete a la Comunidad</h1>
</header>

<nav>
    <a href="index.php">Inicio</a>
    <a href="role-selection2.php">Ya tengo cuenta (Login)</a>
</nav>

<main>
    <div class="registro-container">
        
        <section>
            <form action="../Controller/UserController.php" method="post">
                <h2 class="form-title">Registro Aficionado</h2>
                <label>Nombre completo
                    <input type="text" name="FanName" placeholder="Tu nombre" required>
                </label>
                <label>Email
                    <input type="email" name="FanEmail" required>
                </label>
                <label>Contraseña
                    <input type="password" name="FanPwd" required minlength="6">
                </label>
                <label>Confirmar Contraseña
                    <input type="password" name="FanPwdCon" required minlength="6">
                </label>
                <label>Deporte favorito
                    <select name="FanSport">
                        <option>Fútbol</option>
                        <option>Baloncesto</option>
                        <option>Tenis</option>
                        <option>Críquet</option>
                        <option>Hockey</option>
                        <option>Voleibol</option>
                        <option>Ping Pong</option>
                        <option>Béisbol</option>
                        <option>Fútbol Americano</option>
                        <option>Rugby</option>
                        <option>Golf</option>
                        <option>Formula 1</option>
                        <option>Boxeo</option>
                        <option>MMA</option>
                        <option>Ciclismo</optioN>
                        <option>Natación</option>
                    </select>
                </label>
                <button type="submit" value="register" name="register">Crear cuenta Aficionado</button>
            </form>
        </section>
    </div>

    <p style="text-align: center; margin-top: 2rem;">
        <a href="role-selection2.php" style="color: white; text-decoration: none;">¿Ya tienes cuenta? Entra aquí</a>
    </p>
</main>

</body>
</html>
