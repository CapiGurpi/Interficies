<?php
session_start();
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    unset($_SESSION['user']);
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/index.css" />
    <title>Next Level Sports - Inicio</title>
</head>

<body>

    <header>
        <div class="header-gruop">
            <img src="./assets/images/imagen-logo.png" alt="Logotipo Next Level Sports">
            <h1>NEXT LEVEL SPORTS</h1>
            <div class="right-group">
                <form action="role-selection2.php">
                    <button class="btn btn-sesion" type="submit">Iniciar Sesión</button>
                </form>
                <form action="role-selection.php">
                    <button class="btn btn-register" type="submit">Registrarse</button>
                </form>
            </div>
        </div>
    </header>
    <nav class="sub-menu">
        <ul>
            <li><a href="./events/general-events.php">Eventos</a></li>
            <li><a href="news.php">Noticias</a></li>
            <li><a href="profile.php">Mi Perfil</a></li>
            <li><a href="role-selection.php">Registro</a></li>
            <li><a href="events/create-event.php">Publicar Evento</a></li>
        </ul>
    </nav>
</header>

    <main>
        <section class="hero" aria-labelledby="hero-title">
            <h2 id="hero-title">Lleva la emoción del deporte al siguiente nivel </h2>
            <p>La mejor app para seguir el deporte desde cualquier parte del mundo.</p>
        </section>

    </main>
  
<footer class="site-footer">
    <p>&copy; 2026 Next Level Sports - Accesibilidad Nivel AAA</p>
</footer>
</body>
</html>

