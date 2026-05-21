<?php
$events = [
    [
        'name' => 'Final Champions League 2026',
        'sport' => 'Futbol',
        'date' => '01/06/2026',
        'image' => 'assets/images/champions-league-final.jpg',
        'markets' => [
            ['label' => 'Gana local', 'odd' => 1.85],
            ['label' => 'Empate', 'odd' => 3.20],
            ['label' => 'Gana visitante', 'odd' => 2.10],
        ],
    ],
    [
        'name' => 'Gran Premio MotoGP',
        'sport' => 'Motor',
        'date' => '15/07/2026',
        'image' => 'assets/images/motogp-grand-prix.avif',
        'markets' => [
            ['label' => 'Pole position', 'odd' => 2.40],
            ['label' => 'Podio favorito', 'odd' => 1.70],
            ['label' => 'Vuelta rapida', 'odd' => 3.60],
        ],
    ],
    [
        'name' => 'Open de Tenis',
        'sport' => 'Tenis',
        'date' => '20/08/2026',
        'image' => 'assets/images/tennis-open-tournament.jpg',
        'markets' => [
            ['label' => 'Gana jugador 1', 'odd' => 1.65],
            ['label' => 'Gana jugador 2', 'odd' => 2.25],
            ['label' => 'Mas de 3 sets', 'odd' => 2.95],
        ],
    ],
    [
        'name' => 'Liga Nacional de Basket',
        'sport' => 'Baloncesto',
        'date' => '12/09/2026',
        'image' => 'assets/images/national-basketball-league.webp',
        'markets' => [
            ['label' => 'Victoria local', 'odd' => 1.90],
            ['label' => 'Victoria visitante', 'odd' => 2.05],
            ['label' => 'Mas de 160 puntos', 'odd' => 1.78],
        ],
    ],
];

$message = '';
$errors = [];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $eventIndex = filter_input(INPUT_POST, 'event', FILTER_VALIDATE_INT);
    $marketIndex = filter_input(INPUT_POST, 'market', FILTER_VALIDATE_INT);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $terms = isset($_POST['terms']);

    if ($eventIndex === false || $eventIndex === null || !isset($events[$eventIndex])) {
        $errors[] = 'Selecciona un evento valido.';
    }

    if (!$errors && ($marketIndex === false || $marketIndex === null || !isset($events[$eventIndex]['markets'][$marketIndex]))) {
        $errors[] = 'Selecciona una apuesta valida.';
    }

    if ($amount === false || $amount === null || $amount < 1) {
        $errors[] = 'El importe minimo de apuesta es 1 EUR.';
    }

    if (!$terms) {
        $errors[] = 'Debes confirmar que aceptas las condiciones.';
    }

    if (!$errors) {
        $selectedEvent = $events[$eventIndex];
        $selectedMarket = $selectedEvent['markets'][$marketIndex];
        $potentialWin = $amount * $selectedMarket['odd'];
        $message = 'Apuesta preparada: ' . $selectedEvent['name'] . ' - ' . $selectedMarket['label'] . '. Posible premio: ' . number_format($potentialWin, 2, ',', '.') . ' EUR.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apuestas | Next Level Sports</title>
    <link rel="stylesheet" href="./css/styles.css">
    <style>
        main {
            width: min(1180px, 94%);
            margin: 0 auto;
            padding: 2rem 0 3rem;
        }

        .bet-form {
            background: transparent;
            border-radius: 0;
            margin: 0;
            max-width: none;
            padding: 0;
            width: 100%;
        }

        .bet-layout {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.65fr);
            align-items: start;
        }

        .bet-panel,
        .bet-slip {
            background: #111;
            border-left: 6px solid red;
            border-radius: 10px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.55);
            padding: 1.5rem;
        }

        .bet-panel h2,
        .bet-slip h2 {
            border-bottom: 3px solid rgba(255, 255, 255, 0.3);
            margin-top: 0;
            color: red;
            line-height: 1.15;
        }

        .bet-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .bet-card {
            background: #1a1a1a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.25s ease, border-color 0.25s ease;
        }

        .bet-card:hover {
            border-color: red;
            transform: translateY(-3px);
        }

        .bet-card img {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }

        .bet-card-content {
            padding: 1rem;
        }

        .bet-card h3 {
            color: red;
            font-size: 1.05rem;
            line-height: 1.25;
            margin: 0 0 0.45rem;
            text-transform: uppercase;
        }

        .market-list {
            display: grid;
            gap: 0.6rem;
            margin-top: 1rem;
        }

        .market-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            background: #000;
            border: 1px solid #333;
            border-radius: 6px;
            cursor: pointer;
            padding: 0.75rem;
        }

        .market-option input {
            width: auto;
            margin: 0;
            accent-color: red;
        }

        .market-option span {
            color: #f2f2f2;
            line-height: 1.25;
        }

        .odd {
            color: red;
            font-weight: 700;
            white-space: nowrap;
        }

        .slip-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            padding: 0.75rem 0;
        }

        .slip-row strong {
            color: red;
            text-align: right;
        }

        .notice,
        .errors {
            border-radius: 6px;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .notice {
            background: rgba(0, 128, 0, 0.22);
            border: 1px solid #26a826;
        }

        .errors {
            background: rgba(255, 0, 0, 0.16);
            border: 1px solid red;
        }

        .terms {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            margin-top: 1rem;
            line-height: 1.35;
        }

        .terms input {
            width: auto;
            margin-top: 0.35rem;
            accent-color: red;
        }

        .secondary-button {
            display: inline-block;
            margin-top: 0.8rem;
            padding: 0.8rem 1rem;
            width: 100%;
            border: 1px solid red;
            border-radius: 6px;
            color: red;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
        }

        @media (max-width: 900px) {
            .bet-layout,
            .bet-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            main {
                width: min(100% - 1rem, 1180px);
            }

            .bet-panel,
            .bet-slip {
                padding: 1rem;
            }

            .slip-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .slip-row strong {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Apuestas deportivas</h1>
    </header>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="events/general-events.php">Eventos</a>
        <a href="profile.php">Mi Perfil</a>
        <a href="news.php">Noticias</a>
    </nav>

    <main>
        <?php if ($message !== '') { ?>
            <div class="notice"><?php echo htmlspecialchars($message); ?></div>
        <?php } ?>

        <?php if ($errors) { ?>
            <div class="errors">
                <?php foreach ($errors as $error) { ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php } ?>
            </div>
        <?php } ?>

        <form class="bet-form" method="post" action="bets.php" id="betForm">
            <div class="bet-layout">
                <section class="bet-panel">
                    <h2>Elige tu pronostico</h2>
                    <div class="bet-grid">
                        <?php foreach ($events as $eventIndex => $event) { ?>
                            <article class="bet-card">
                                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['name']); ?>">
                                <div class="bet-card-content">
                                    <h3><?php echo htmlspecialchars($event['name']); ?></h3>
                                    <p><strong><?php echo htmlspecialchars($event['sport']); ?></strong> · <?php echo htmlspecialchars($event['date']); ?></p>
                                    <div class="market-list">
                                        <?php foreach ($event['markets'] as $marketIndex => $market) { ?>
                                            <label class="market-option">
                                                <span>
                                                    <input
                                                        type="radio"
                                                        name="selection"
                                                        value="<?php echo $eventIndex . '-' . $marketIndex; ?>"
                                                        data-event="<?php echo $eventIndex; ?>"
                                                        data-market="<?php echo $marketIndex; ?>"
                                                        data-event-name="<?php echo htmlspecialchars($event['name']); ?>"
                                                        data-market-name="<?php echo htmlspecialchars($market['label']); ?>"
                                                        data-odd="<?php echo htmlspecialchars($market['odd']); ?>"
                                                        required
                                                    >
                                                    <?php echo htmlspecialchars($market['label']); ?>
                                                </span>
                                                <span class="odd"><?php echo number_format($market['odd'], 2); ?></span>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                </section>

                <aside class="bet-slip">
                    <h2>Tu boleto</h2>
                    <input type="hidden" name="event" id="eventInput">
                    <input type="hidden" name="market" id="marketInput">

                    <div class="slip-row">
                        <span>Evento</span>
                        <strong id="eventName">Sin seleccionar</strong>
                    </div>
                    <div class="slip-row">
                        <span>Apuesta</span>
                        <strong id="marketName">Sin seleccionar</strong>
                    </div>
                    <div class="slip-row">
                        <span>Cuota</span>
                        <strong id="oddValue">0.00</strong>
                    </div>

                    <label>Importe
                        <input type="number" name="amount" id="amountInput" min="1" step="0.50" value="5" required>
                    </label>

                    <div class="slip-row">
                        <span>Posible premio</span>
                        <strong id="potentialWin">0.00 EUR</strong>
                    </div>

                    <label class="terms">
                        <input type="checkbox" name="terms" required>
                        <span>Confirmo que soy mayor de edad y acepto las condiciones de la apuesta.</span>
                    </label>

                    <button type="submit">Confirmar apuesta</button>
                    <a class="secondary-button" href="events/general-events.php">Ver eventos</a>
                </aside>
            </div>
        </form>
    </main>

    <script>
        const form = document.getElementById('betForm');
        const eventInput = document.getElementById('eventInput');
        const marketInput = document.getElementById('marketInput');
        const eventName = document.getElementById('eventName');
        const marketName = document.getElementById('marketName');
        const oddValue = document.getElementById('oddValue');
        const amountInput = document.getElementById('amountInput');
        const potentialWin = document.getElementById('potentialWin');

        function updateSlip() {
            const selected = form.querySelector('input[name="selection"]:checked');
            const amount = Number(amountInput.value) || 0;

            if (!selected) {
                potentialWin.textContent = '0.00 EUR';
                return;
            }

            const odd = Number(selected.dataset.odd);
            eventInput.value = selected.dataset.event;
            marketInput.value = selected.dataset.market;
            eventName.textContent = selected.dataset.eventName;
            marketName.textContent = selected.dataset.marketName;
            oddValue.textContent = odd.toFixed(2);
            potentialWin.textContent = (amount * odd).toFixed(2) + ' EUR';
        }

        form.addEventListener('change', updateSlip);
        amountInput.addEventListener('input', updateSlip);
        updateSlip();
    </script>
</body>
</html>
