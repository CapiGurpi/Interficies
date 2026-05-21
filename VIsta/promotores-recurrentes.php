<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Level Sports | Highlights</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css">

<link rel="stylesheet" href="css/jquery-utilities.css">
<link rel="stylesheet" href="css/gallery.css">
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <nav class="main-nav">
        <div class="nav-logo">
            NEXT LEVEL <span>SPORTS</span>
        </div>
    <ul class="nav-links">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="news.php">Noticias</a></li>
        <li><a href="../Vista/events/general-events.php">Eventos</a></li>
    </ul>
</nav>
<section style="margin-top: 3rem; margin-bottom: 3rem;">
            <div class="slider-promoters">
                <div class="slider-item">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #cc0000, #660000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                        <img src="assets/images/user-profile.jpg" alt="Juan García" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid red;">
                    </div>
                    <div class="slider-item-title">Juan García</div>
                    <div class="slider-item-desc">Organizador de eventos deportivos con 10 años de experiencia</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #660000, #330000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                        <img src="assets/images/user-profile.jpg" alt="María López" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid red;">
                    </div>
                    <div class="slider-item-title">María López</div>
                    <div class="slider-item-desc">Especialista en eventos de música y entretenimiento</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #990000, #330000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                        <img src="assets/images/user-profile.jpg" alt="Carlos Rodríguez" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid red;">
                    </div>
                    <div class="slider-item-title">Carlos Rodríguez</div>
                    <div class="slider-item-desc">Productor de eventos internacionales de alto nivel</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #cc0000, #330000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                        <img src="assets/images/user-profile.jpg" alt="Ana Martínez" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid red;">
                    </div>
                    <div class="slider-item-title">Ana Martínez</div>
                    <div class="slider-item-desc">Coordinadora de eventos culturales y deportivos</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #660000, #000000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                        <img src="assets/images/user-profile.jpg" alt="Pedro Silva" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid red;">
                    </div>
                    <div class="slider-item-title">Pedro Silva</div>
                    <div class="slider-item-desc">Gestor de grandes competiciones deportivas</div>
                </div>
            </div>
</section>
<footer class="site-footer" style="margin-top: 10rem;">
    <div class="footer-links">
        <h3>Información útil</h3>
        <ul>
            <li><a href="./info/about.php">Sobre Nosotros</a></li>
            <li><a href="./info/team.php">Equipo</a></li>
            <li><a href="./info/help.php">Ayuda</a></li>
            <li><a href="./info/promoter-guidelines.php">Guía de Promotores</a></li>
            <li><a href="./info/policies.php">Políticas</a></li>
            <li><a href="./info/newsletter.php">Newsletter</a></li>
        </ul>
    </div>
    <p>&copy; 2026 Next Level Sports - Accesibilidad Nivel AAA</p>
</footer>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- jQuery Utilities JS -->
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