<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Evento - Open de Tenis</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header><h1>Información del Evento</h1></header>
    
    <nav>
        <a href="../index.php">Inicio</a>
        <a href="../profile.php">Mi Perfil</a>
    </nav>

    <main>
        <article class="card" style="max-width: 800px; margin: auto;">
            <img src="../assets/images/tennis-stadium-seats.jpg" alt="Información del Open de Tenis.">
            <h2>Open de Tenis 2026</h2>
            
            <p><strong>Deporte:</strong> Tenis</p>
            <p><strong>Ubicación:</strong> Real Club de Tenis, Barcelona </p>
            
            <p><strong>Descripción:</strong> 
                Presencia los mejores saques y jugadas en tierra batida. Un torneo clasificatorio para el ranking mundial con los mejores tenistas del momento.
            </p>
            
            <a href="../purchase/tennis-ticket-purchase.php" style="text-decoration: none;">
                <button>Comprar Entradas</button>
            </a>

            <div style="display: flex; justify-content: space-between; margin-top: 2rem; border-top: 1px solid #333; padding-top: 1rem;">
                <a href="./general-events.php" style="color: gray; text-decoration: none;">← Volver al listado</a>
                
                <a href="basketball-league-event.php" style="color: white; text-decoration: none;">
                    Ver siguiente evento (Basket) →
                </a>
            </div>
        </article>
    </main>
</body>
</html>
