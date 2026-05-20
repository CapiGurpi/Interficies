<?php
require_once __DIR__ . '/../../Model/NextLvlBase.php';
require_once __DIR__ . '/../../Controller/EventControler.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear evento</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: 'Oswald', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        main {
            width: min(1100px, 92%);
            margin: 0 auto;
            padding: 2rem 0;
        }

        .event-panel {
            background: #111;
            border-left: 6px solid red;
            border-radius: 8px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
            margin-bottom: 2rem;
            padding: 1.5rem;
        }
        
        .event-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        label {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.2px;
            line-height: 1.25;
        }

        input,
        select,
        textarea {
            border: 1px solid #555;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.4;
            padding: 0.75rem;
            width: 100%;
        }

        textarea,
        .full-row {
            grid-column: 1 / -1;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .button-link,
        button {
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            font-family: 'Oswald', Arial, sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            line-height: 1.2;
            margin-top: 0;
            padding: 0.8rem 1rem;
            text-align: center;
            text-decoration: none;
            width: auto;
        }

        .button-link {
            background: #333;
            color: white;
        }

        .danger-button {
            background: transparent;
            border: 1px solid red;
            color: red;
        }

        .message,
        .errors {
            border-radius: 5px;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .message {
            background: rgba(0, 128, 0, 0.22);
            border: 1px solid #26a826;
        }

        .errors {
            background: rgba(255, 0, 0, 0.16);
            border: 1px solid red;
        }
        .events-table {
            border-collapse: collapse;
            width: 100%;
        }
 
        .events-table th,
        .events-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 1rem;
            font-weight: 400;
            letter-spacing: 0.1px;
            line-height: 1.35;
            padding: 0.8rem;
            text-align: left;
            vertical-align: top;
        }

        .events-table th {
            color: red;
            font-weight: 600;
            text-transform: uppercase;
        }
 
        .table-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
 
        .inline-form {
            background: transparent;
            margin: 0;
            padding: 0;
            width: auto;
        }
        
        @media (max-width: 760px) {
            .event-grid {
                grid-template-columns: 1fr;
            }
 
            .events-table,
            .events-table tbody,
            .events-table tr,
            .events-table td {
                display: block;
                width: 100%;
            }
 
            .events-table thead {
                display: none;
            }
 
            .events-table tr {
                border-bottom: 1px solid rgba(255, 255, 255, 0.25);
                padding: 0.75rem 0;
            }
        }
    </style>
</head>
<body>
    <header>
    <h1>Gestionar eventos deportivos</h1>
</header>
 
<main>
    <?php if ($message !== '') { ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>
 
    <?php if ($errors) { ?>
        <div class="errors">
            <?php foreach ($errors as $error) { ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php } ?>
        </div>
    <?php } ?>
 
    <section class="event-panel">
        <h2><?php echo $editingEvent ? 'Editar evento' : 'Crear evento'; ?></h2>
        <form method="post" action="create-event.php">
            <input type="hidden" name="action" value="<?php echo $editingEvent ? 'update' : 'create'; ?>">
            <?php if ($editingEvent) { ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($formValues['Id']); ?>">
            <?php } ?>
 
            <div class="event-grid">
                <label>Nombre del evento
                    <input type="text" name="Name" maxlength="50" value="<?php echo htmlspecialchars($formValues['Name']); ?>" required>
                </label>
 
                <label>Deporte
                    <select name="Sport" required>
                        <option value="">Selecciona</option>
                        <?php
                        $sports = ['Futbol', 'Baloncesto', 'Tenis', 'Motor', 'Atletismo', 'Natacion', 'Ciclismo', 'Otro'];
                        foreach ($sports as $sport) {
                            $selected = ($formValues['Sport'] === $sport) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($sport) . '" ' . $selected . '>' . htmlspecialchars($sport) . '</option>';
                        }
                        ?>
                    </select>
                </label>
 
                <label>Fecha
                    <input type="date" name="Date" value="<?php echo htmlspecialchars($formValues['Date']); ?>" required>
                </label>
 
                <label>Ubicacion
                    <input type="text" name="Location" maxlength="100" value="<?php echo htmlspecialchars($formValues['Location']); ?>" required>
                </label>
 
                <label>Precio
                    <input type="number" name="Price" min="0" step="0.01" value="<?php echo htmlspecialchars($formValues['Price']); ?>" required>
                </label>
 
                <label class="full-row">Descripcion
                    <textarea name="Description" minlength="15" rows="4" required><?php echo htmlspecialchars($formValues['Description']); ?></textarea>
                </label>
            </div>
 
            <div class="actions">
                <button type="submit"><?php echo $editingEvent ? 'Actualizar evento' : 'Publicar evento'; ?></button>
                <?php if ($editingEvent) { ?>
                    <a class="button-link" href="create-event.php">Cancelar edicion</a>
                <?php } ?>
                <a class="button-link" href="../profile.php">Volver al perfil</a>
            </div>
        </form>
    </section>
</body>
</html>
