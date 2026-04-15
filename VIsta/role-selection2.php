<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo de Inicio | Next Level Sports</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/role-selection.css">
</head>
<body>
    <header>
        <h1>¿Eres parte de Next Level?</h1>
    </header>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="profile.php">Mi Perfil</a>
    </nav>

    <main style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 60vh;">
        <h2 style="margin-bottom: 2rem; text-align: center;">¿Qué tipo de cuenta posees?</h2>
        
        <div class="cards seleccion-container">
            <article class="card" style="text-align: center; cursor: pointer;" onclick="window.location.href='fan-login.php'">
                <h3 style="color: red;">AFICIONADO</h3>
                <p> Tengo una cuenta de tipo Aficionado</p>
                <button>Soy Aficionado</button>
            </article>

            <article class="card" style="text-align: center; cursor: pointer; border-left-color: white;" onclick="window.location.href='promoter-login.php'">
                <h3 style="color: white;">PROMOTOR</h3>
                <p> Tengo una cuenta de tipo Promotor</p>
                <button style="background-color: white; color: black;">Soy Promotor</button>
            </article>
        </div>

        <p style="margin-top: 2rem;">
            <a href="role-selection.php" style="color: gray; text-decoration: none;">No tengo cuenta, volver al registro</a>
        </p>
    </main>
</body>
</html>
