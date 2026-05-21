<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demostración de jQuery Utilities | Next Level Sports</title>
    <link rel="stylesheet" href="css/styles.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.min.css">
    
    <link rel="stylesheet" href="css/jquery-utilities.css">
    <style>
        .demo-section {
            margin: 2rem 0;
            padding: 1.5rem;
            background: #1a1a1a;
            border: 2px solid red;
            border-radius: 8px;
        }

        .demo-section h2 {
            color: red;
            margin-top: 0;
        }

        .demo-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .demo-btn {
            padding: 0.8rem 1.5rem;
            background: red;
            color: black;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .demo-btn:hover {
            background: #cc0000;
            transform: scale(1.05);
        }

        .demo-code {
            background: #000;
            border: 1px solid #333;
            padding: 1rem;
            border-radius: 4px;
            overflow-x: auto;
            margin-top: 1rem;
        }

        .demo-code code {
            color: #0f0;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>Demostración jQuery Utilities</h1>
    </header>

    <main>
        
        <section class="demo-section">
            <h2>1. Modal Message (Mensaje Modal)</h2>
            <p>Crea un mensaje modal que aparece sobre un fondo transparente. Al hacer clic en el fondo se oculta.</p>

            <div class="demo-buttons">
                <button class="demo-btn" id="modal-demo-1">Modal Simple</button>
                <button class="demo-btn" id="modal-demo-2">Modal con Acciones</button>
                <button class="demo-btn" id="modal-demo-3">Modal de Confirmación</button>
            </div>

            <div class="demo-code">
                <code>
// Llamar a la función openModal<br>
openModal('Título', 'Mensaje', [<br>
&nbsp;&nbsp;{text: 'Aceptar', class: 'modal-btn-primary', action: 'ok', callback: closeModal}<br>
]);
                </code>
            </div>
        </section>

        
        <section class="demo-section">
            <h2>2. Image Hover Message (Mensaje sobre Imagen)</h2>
            <p>Muestra un mensaje flotante al pasar el ratón sobre una imagen.</p>

            <div class="grid-2">
                <div class="image-container">
                    <img src="assets/images/champions-league-stadium.avif" alt="Champions League" 
                         style="width: 100%; border-radius: 8px; cursor: pointer;">
                    <div class="image-tooltip">Haz clic para más info</div>
                </div>
                <div class="image-container">
                    <img src="assets/images/f1-spanish-grand-prix.avif" alt="F1 Spanish GP"
                         style="width: 100%; border-radius: 8px; cursor: pointer;">
                    <div class="image-tooltip">Ver detalles del evento</div>
                </div>
                <div class="image-container">
                    <img src="assets/images/motogp-grand-prix.avif" alt="MotoGP"
                         style="width: 100%; border-radius: 8px; cursor: pointer;">
                    <div class="image-tooltip">Comprar entradas</div>
                </div>
            </div>

            <div class="demo-code">
                <code>
// Añadir mensaje a imágenes<br>
addImageHoverMessage('.selector-imagenes', 'Tu mensaje aquí');
                </code>
            </div>
        </section>

        
        <section class="demo-section">
            <h2>3. Cookies Alert (Aviso de Cookies)</h2>
            <p>Aviso de cookies con localStorage. El usuario debe aceptar para hacer login.</p>

            <div class="demo-buttons">
                <button class="demo-btn" id="cookies-demo-1">Restablecer Aviso de Cookies</button>
                <button class="demo-btn" id="cookies-demo-2">Ver Estado (localStorage)</button>
            </div>

            <p style="color: #999; font-size: 0.9rem;">
                <strong>Funcionalidades:</strong>
                <ul>
                    <li>✓ Aparece automáticamente si no ha sido aceptado</li>
                    <li>✓ Guarda en localStorage si fue aceptado</li>
                    <li>✓ El usuario puede mostrar el aviso nuevamente</li>
                    <li>✓ Bloquea el login si no se aceptan cookies</li>
                </ul>
            </p>

            <div class="demo-code">
                <code>
// Inicializar aviso de cookies<br>
initCookiesAlert();
                </code>
            </div>
        </section>

        
        <section class="demo-section">
            <h2>4. Slider 1 - Eventos/Conciertos</h2>
            <p>Carrusel responsivo de eventos con imágenes y títulos. Se adapta a 3 resoluciones diferentes.</p>

            <div class="slider-demo-events">
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
                    <img src="assets/images/champions-league-stadium.avif" alt="Tenis">
                    <div class="slider-item-title">Torneo de Tenis</div>
                    <div class="slider-item-desc">Campeonato internacional de tenis</div>
                </div>
                <div class="slider-item">
                    <img src="assets/images/f1-spanish-grand-prix.avif" alt="Ciclismo">
                    <div class="slider-item-title">Maratón de Ciclismo</div>
                    <div class="slider-item-desc">Competencia de resistencia</div>
                </div>
                <div class="slider-item">
                    <img src="assets/images/motogp-grand-prix.avif" alt="Natación">
                    <div class="slider-item-title">Campeonato de Natación</div>
                    <div class="slider-item-desc">Copa internacional de natación</div>
                </div>
            </div>

            <div class="demo-code">
                <code>
// Inicializar slider<br>
initSlider('.slider-events', {<br>
&nbsp;&nbsp;responsive: [{breakpoint: 1024, settings: {...}}, ...],<br>
&nbsp;&nbsp;autoplay: true,<br>
&nbsp;&nbsp;autoplaySpeed: 5000<br>
});
                </code>
            </div>
        </section>

        
        <section class="demo-section">
            <h2>5. Slider 2 - Promotores Destacados</h2>
            <p>Carrusel responsivo de promotores con información. Se adapta a 3 resoluciones diferentes.</p>

            <div class="slider-demo-promoters">
                <div class="slider-item">
                    <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #cc0000, #660000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                        Promotor 1
                    </div>
                    <div class="slider-item-title">Juan García</div>
                    <div class="slider-item-desc">Organizador de eventos deportivos con 10 años de experiencia en el sector</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #660000, #330000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                        Promotor 2
                    </div>
                    <div class="slider-item-title">María López</div>
                    <div class="slider-item-desc">Especialista en eventos de música y entretenimiento de nivel internacional</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #990000, #330000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                        Promotor 3
                    </div>
                    <div class="slider-item-title">Carlos Rodríguez</div>
                    <div class="slider-item-desc">Productor de eventos internacionales de alto nivel y gran experiencia</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #cc0000, #330000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                        Promotor 4
                    </div>
                    <div class="slider-item-title">Ana Martínez</div>
                    <div class="slider-item-desc">Coordinadora de eventos culturales y deportivos con trayectoria comprobada</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #660000, #000000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                        Promotor 5
                    </div>
                    <div class="slider-item-title">Pedro Silva</div>
                    <div class="slider-item-desc">Gestor de grandes competiciones deportivas a nivel mundial y europeo</div>
                </div>
                <div class="slider-item">
                    <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #990000, #660000); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                        Promotor 6
                    </div>
                    <div class="slider-item-title">Sofia Ruiz</div>
                    <div class="slider-item-desc">Productora de eventos artísticos y culturales con presencia internacional</div>
                </div>
            </div>

            <div class="demo-code">
                <code>
// Configurar slider responsivo<br>
initSlider('.slider-promoters', {<br>
&nbsp;&nbsp;responsive: [{<br>
&nbsp;&nbsp;&nbsp;&nbsp;breakpoint: 768,<br>
&nbsp;&nbsp;&nbsp;&nbsp;settings: {slidesToShow: 2}<br>
&nbsp;&nbsp;}],<br>
&nbsp;&nbsp;autoplay: true<br>
});
                </code>
            </div>
        </section>

        
        <section class="demo-section">
            <h2>Configuración Responsiva de los Sliders</h2>
            <p>Los sliders se adaptan automáticamente según la resolución de pantalla:</p>

            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <tr style="background: #333;">
                    <th style="border: 1px solid red; padding: 1rem; text-align: left;">Resolución</th>
                    <th style="border: 1px solid red; padding: 1rem; text-align: left;">Ancho de Pantalla</th>
                    <th style="border: 1px solid red; padding: 1rem; text-align: left;">Columnas a Mostrar</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #555; padding: 1rem;">Desktop</td>
                    <td style="border: 1px solid #555; padding: 1rem;">≥ 1025px</td>
                    <td style="border: 1px solid #555; padding: 1rem;">3-4 elementos</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #555; padding: 1rem;">Tablet</td>
                    <td style="border: 1px solid #555; padding: 1rem;">768px - 1024px</td>
                    <td style="border: 1px solid #555; padding: 1rem;">2 elementos</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #555; padding: 1rem;">Mobile</td>
                    <td style="border: 1px solid #555; padding: 1rem;">< 768px</td>
                    <td style="border: 1px solid #555; padding: 1rem;">1 elemento</td>
                </tr>
            </table>
        </section>

        <p style="text-align: center; margin-top: 2rem; color: #999;">
            <a href="fan-login.php" style="color: red; text-decoration: none;">← Volver a Login</a>
        </p>
    </main>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    
    <script src="js/jquery-utilities.js"></script>

    <script>
        $(document).ready(function() {
            
            initSlider('.slider-demo-events', {
                slidesToShow: 4,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {slidesToShow: 3}
                    },
                    {
                        breakpoint: 768,
                        settings: {slidesToShow: 2}
                    },
                    {
                        breakpoint: 480,
                        settings: {slidesToShow: 1}
                    }
                ],
                autoplay: true,
                autoplaySpeed: 4000
            });

            initSlider('.slider-demo-promoters', {
                slidesToShow: 3,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {slidesToShow: 3}
                    },
                    {
                        breakpoint: 768,
                        settings: {slidesToShow: 2}
                    },
                    {
                        breakpoint: 480,
                        settings: {slidesToShow: 1}
                    }
                ],
                autoplay: true,
                autoplaySpeed: 5000
            });

            
            $('#modal-demo-1').click(function() {
                openModal(
                    'Modal Simple',
                    'Este es un modal básico. Haz clic en el fondo o en la X para cerrarlo.'
                );
            });

            $('#modal-demo-2').click(function() {
                openModal(
                    'Modal con Acciones',
                    '¿Deseas continuar con esta acción?',
                    [
                        {
                            text: 'Aceptar',
                            class: 'modal-btn-primary',
                            action: 'accept',
                            callback: function() {
                                alert('¡Aceptado!');
                                closeModal();
                            }
                        },
                        {
                            text: 'Cancelar',
                            class: 'modal-btn-secondary',
                            action: 'cancel',
                            callback: closeModal
                        }
                    ]
                );
            });

            $('#modal-demo-3').click(function() {
                openModal(
                    'Confirmación Importante',
                    '¿Estás seguro de que deseas continuar? Esta acción no puede deshacerse.',
                    [
                        {
                            text: 'Sí, continuar',
                            class: 'modal-btn-primary',
                            action: 'confirm',
                            callback: function() {
                                openModal(
                                    'Confirmado',
                                    '¡La acción ha sido completada exitosamente!'
                                );
                            }
                        },
                        {
                            text: 'No, cancelar',
                            class: 'modal-btn-secondary',
                            action: 'cancel',
                            callback: closeModal
                        }
                    ]
                );
            });

            
            $('#cookies-demo-1').click(function() {
                localStorage.removeItem('cookies_accepted');
                location.reload();
            });

            $('#cookies-demo-2').click(function() {
                const accepted = localStorage.getItem('cookies_accepted');
                const status = accepted ? 'Cookies ACEPTADAS' : 'Cookies NO ACEPTADAS';
                openModal(
                    'Estado de Cookies',
                    'Estado actual en localStorage: <strong>' + status + '</strong>'
                );
            });

            
            initCookiesAlert();
        });
    </script>
</body>

</html>
