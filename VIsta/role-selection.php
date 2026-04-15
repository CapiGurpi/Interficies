<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo de Registro | Next Level Sports</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Únete a Next Level</h1>
    </header>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="profile.php">Mi Perfil</a>
    </nav>

    <main style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 60vh;">
        <h2 style="margin-bottom: 2rem; text-align: center;">¿Cómo quieres participar?</h2>
        
        <div class="cards seleccion-container">
            <article class="card" style="text-align: center; cursor: pointer;" onclick="window.location.href='fan-registration.php'">
                <h3 style="color: red;">AFICIONADO</h3>
                <p>
        Únete a la comunidad de Next Level Sports para vivir el deporte como nunca. 
        Al registrarte como aficionado, podrás explorar nuestro calendario exclusivo 
        de eventos, adquirir entradas de forma segura para las mejores competiciones 
        del mundo y recibir alertas personalizadas sobre tus deportes y atletas favoritos. 
        ¡No te pierdas ni un solo marcador y vive la emoción en directo!</p>
                <button>Elegir Aficionado</button>
            </article>

            <article class="card" style="text-align: center; cursor: pointer; border-left-color: white;" onclick="window.location.href='promoter-registration.php'">
                <h3 style="color: white;">PROMOTOR</h3>
                <p>
        ¿Eres organizador de eventos o periodista deportivo? Nuestra plataforma te ofrece 
        todas las herramientas necesarias para gestionar tus competiciones de principio a fin. 
        Como promotor, podrás publicar nuevos eventos en nuestra cartelera, gestionar la 
        venta de entradas de forma profesional, redactar noticias de última hora y conectar 
        directamente con miles de aficionados que buscan nuevas experiencias deportivas.</p>
                <button style="background-color: white; color: black;">Elegir Promotor</button>
            </article>
        </div>

        <p style="margin-top: 2rem;">
            <a href="role-selection2.php" style="color: gray; text-decoration: none;">Ya tengo cuenta, volver al Login</a>
        </p>
    </main>
</body>
</html>
