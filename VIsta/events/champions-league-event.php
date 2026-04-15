<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Evento</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header><h1>Información del Evento</h1></header>
    <nav><a href="../index.php">Volver al Inicio</a></nav>
    <main>
        <article class="card" style="max-width: 800px; margin: auto;">
            <img src="../assets/images/champions-league-stadium.avif" alt="Cartel publicitario de la Final de Champions">

            <h2>Final Champions League 2026</h2>
            <p><strong>Deporte:</strong> Fútbol</p>
            <p><strong>Ubicación:</strong> Estadio Olímpico</p>
            <p><strong>Descripción:</strong> El evento más esperado del año donde los dos mejores equipos de Europa se disputan la gloria eterna. No te pierdas la fan zone previa al partido.</p>
            <section class="multimedia">
                <div class="video-container">
                    <h3>Anuncio de la Champions League de 2026</h3>
                    <video controls width="100%" aria-label="Vídeo promocional con Marc Márquez">
                        <source src="../assets/videos/champions-promo-video.mp4" type="video/mp4">
                        Tu navegador no soporta el formato de vídeo.
                    </video>
                </div>

                <div class="audio-container">
                    <h3>Audio Descripción para Personas con Discapacidad Visual</h3>
                    <audio controls aria-label="Audio descriptivo del evento">
                        <source src="../assets/audio/champions-audio-description.m4a" type="audio/mpeg">
                        Tu navegador no soporta el formato de audio.
                    </audio>
                </div>
            </section>
            <a href="../purchase/champions-ticket-purchase.php" style="text-decoration: none;">
                <button>Comprar Entradas</button>
            </a>
            <div style="display: flex; justify-content: space-between; margin-top: 2rem; border-top: 1px solid #333; padding-top: 1rem;">
                <a href="./general-events.php" style="color: gray; text-decoration: none;">← Volver al listado</a>
                
                <a href="motogp-event.php" style="color: white; text-decoration: none;">
                    Ver siguiente evento (Moto GP) →
                </a>
            </div>
        </article>
    </main>
</body>
</html>
