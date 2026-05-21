<?php
session_start();

if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    unset($_SESSION['user']);
    header('Location: fan-login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Next Level Sports</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.min.css">
    <!-- jQuery Utilities CSS -->
    <link rel="stylesheet" href="css/jquery-utilities2.css">
</head>

<body>
    <header>
        <h1>Iniciar Sesión</h1>
    </header>
    <main>        <?php if (!empty($_SESSION['user'])) { ?>
        <div style="text-align: center; padding: 40px; color: white;">
            <h2>Ya estás conectado</h2>
            <p>Tu sesión es activa. Accede a <a href="index.php" style="color: red;">la página principal</a>.</p>
        </div>
        <?php } else { ?>        <?php if (!empty($_SESSION['login_error']) && is_array($_SESSION['login_error'])) { ?>
            <div class="error-container">
                <span class="error-icon">ⓘ</span>
                <span>
                    <?php
                    foreach ($_SESSION['login_error'] as $error) {
                        echo htmlspecialchars($error) . "<br>";
                    }
                    ?>
                </span>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php } ?>
        <form action="../Controller/UserController.php" method="post">
            <label>Email
                <input type="email" name="email" required>
            </label>

            <label>Contraseña
                <input type="password" name="password" required minlength="6">
            </label>

            <label>Tipo de usuario
                <select name="userType" value="userType" required>
                    <option value="Aficionado">Aficionado</option>
                    <option value="Promotor">Promotor</option>
                </select>
            </label>

            <input type="submit" name="login" value="Iniciar Sesión">

            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                ¿No tienes cuenta? <a href="role-selection.php" style="color: red; text-decoration: none;">Regístrate aquí</a>
            </p>

            <p style="text-align: center; margin-top: 0.5rem;">
                <a href="index.php" style="color: gray; text-decoration: none; font-size: 0.8rem;">← Volver al Inicio</a>
            </p>
        </form>

        <!-- Botón de demostración de modal -->
        <div style="text-align: center; margin-top: 2rem;">
            <button id="demo-modal-btn" style="padding: 0.8rem 1.5rem; background: #333; color: red; border: 2px solid red; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Ver Ejemplo de Modal
            </button>
        </div>

        
        <section style="margin-top: 3rem;">
            <h3 style="text-align: center; color: red; margin-bottom: 2rem;">Eventos Próximos</h3>
            <div class="slider-events">
                <div class="slider-item">
                    <img src="assets/images/champions-league-stadium.avif" alt="Champions League">
                    <div class="slider-item-title">Champions League</div>
                    <div class="slider-item-desc">Competencia internacional de fútbol</div>
                </div>
                <div class="slider-item">
                    <img src="assets/images/f1-spanish-grand-prix.avif" alt="F1 Spanish GP">
                    <div class="slider-item-title">F1 Spanish Grand Prix</div>
                    <div class="slider-item-desc">Gran premio de Fórmula 1</div>
                </div>
                <div class="slider-item">
                    <img src="assets/images/motogp-grand-prix.avif" alt="MotoGP">
                    <div class="slider-item-title">MotoGP Grand Prix</div>
                    <div class="slider-item-desc">Campeonato mundial de motociclismo</div>
                </div>
                <div class="slider-item">
                    <img src="assets/images/champions-league-stadium.avif" alt="Event 4">
                    <div class="slider-item-title">Torneo de Tenis</div>
                    <div class="slider-item-desc">Campeonato internacional de tenis</div>
                </div>
                <div class="slider-item">
                    <img src="assets/images/f1-spanish-grand-prix.avif" alt="Event 5">
                    <div class="slider-item-title">Maratón de Ciclismo</div>
                    <div class="slider-item-desc">Competencia de resistencia</div>
                </div>
            </div>
        </section>
        <?php } ?>
    </main>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    
    <script src="js/jquery-utilities.js"></script>
    
    <script>
        $(document).ready(function() {
            
            initCookiesAlert();

            
            initSlider('.slider-events', {
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }
                ],
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                speed: 500,
                autoplay: true,
                autoplaySpeed: 5000,
                dots: true,
                arrows: true
            });

            initSlider('.slider-promoters', {
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }
                ],
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                speed: 500,
                autoplay: true,
                autoplaySpeed: 6000,
                dots: true,
                arrows: true
            });

            
            addImageHoverMessage('.slider-events .slider-item img', 'Haz clic para más información');

            // Demo de modal
            $('#demo-modal-btn').click(function() {
                openModal(
                    'Bienvenido a Next Level Sports',
                    'Esta es una demostración de un modal con jQuery. Puedes hacer clic en el fondo o en la X para cerrarlo.',
                    [
                        {
                            text: 'Cerrar',
                            class: 'modal-btn-primary',
                            action: 'close',
                            callback: closeModal
                        }
                    ]
                );
            });

            
            $('form').submit(function(e) {
                const STORAGE_KEY = 'cookies_accepted';
                if (!localStorage.getItem(STORAGE_KEY)) {
                    e.preventDefault();
                    openModal(
                        'Cookies Requeridas',
                        'Debes aceptar el uso de cookies para continuar. Por favor, acepta las cookies en la parte inferior de la página.',
                        [
                            {
                                text: 'Entendido',
                                class: 'modal-btn-primary',
                                action: 'ok',
                                callback: closeModal
                            }
                        ]
                    );
                    return false;
                }
            });
        });
    </script>
</body>

</html>