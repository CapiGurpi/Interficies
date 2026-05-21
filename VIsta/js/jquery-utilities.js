

$(document).ready(function() {


    
    /**
     * Abre un modal con título, contenido y acciones
     * @param {string} title - Título del modal
     * @param {string} message - Contenido del modal
     * @param {array} buttons - Array de objetos con {text, class, callback}
     */
    window.openModal = function(title, message, buttons = null) {
        let modalHTML = `
            <div class="modal-overlay active">
                <div class="modal-content">
                    <button class="modal-close" aria-label="Cerrar">×</button>
                    <h2 class="modal-title">${title}</h2>
                    <div class="modal-body">${message}</div>
        `;
        
        if (buttons && buttons.length > 0) {
            modalHTML += '<div class="modal-actions">';
            buttons.forEach(btn => {
                modalHTML += `<button class="modal-btn ${btn.class}" data-action="${btn.action}">${btn.text}</button>`;
            });
            modalHTML += '</div>';
        }
        
        modalHTML += `</div></div>`;
        
        
        $('.modal-overlay').remove();
        
        $('body').append(modalHTML);
        
        // Cerrar modal al hacer clic en el fondo
        $('.modal-overlay').click(function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        
        $('.modal-close').click(closeModal);
        
        
        $('.modal-btn').click(function() {
            const action = $(this).data('action');
            const callback = buttons.find(b => b.action === action)?.callback;
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
    };
    
    
    window.closeModal = function() {
        $('.modal-overlay').fadeOut(300, function() {
            $(this).remove();
        });
    };

    
    
    /**
     * Añade un mensaje flotante al pasar el ratón sobre una imagen
     * @param {string} selector - Selector CSS de las imágenes
     * @param {string} message - Mensaje a mostrar
     */
    window.addImageHoverMessage = function(selector, message) {
        $(selector).each(function() {
            if (!$(this).parent().hasClass('image-container')) {
                $(this).wrap('<div class="image-container"></div>');
            }
            
            if ($(this).siblings('.image-tooltip').length === 0) {
                $(this).after(`<div class="image-tooltip">${message}</div>`);
            }
        });
    };


    
 
    window.initCookiesAlert = function() {
        const STORAGE_KEY = 'cookies_accepted';
        
        // Verificar si el usuario ya aceptó las cookies
        if (!localStorage.getItem(STORAGE_KEY)) {
            // Mostrar alerta de cookies
            showCookiesAlert();
        } else {
            // El usuario ya aceptó, no mostrar el aviso
            hideCookiesAlert();
        }
        
      
        function showCookiesAlert() {
            if ($('.cookies-alert').length === 0) {
                const alertHTML = `
                    <div class="cookies-alert show">
                        <div class="cookies-text">
                            <strong>Aviso de Cookies</strong><br>
                            Utilizamos cookies para mejorar tu experiencia en nuestro sitio. 
                            Al continuar navegando, aceptas el uso de cookies.
                            <a href="Vista/info/policies.php" style="color: red; text-decoration: underline;">
                                Más información
                            </a>
                        </div>
                        <div class="cookies-buttons">
                            <button class="cookies-btn cookies-btn-accept" id="accept-cookies">Aceptar</button>
                            <button class="cookies-btn cookies-btn-reject" id="reject-cookies">Rechazar</button>
                        </div>
                    </div>
                    <button id="show-cookies-btn">Mostrar Aviso de Cookies</button>
                `;
                
                $('body').append(alertHTML);
                
                // Manejar aceptación de cookies
                $('#accept-cookies').click(function() {
                    localStorage.setItem(STORAGE_KEY, 'true');
                    hideCookiesAlert();
                    enableLoginButton();
                });
                
                // Manejar rechazo de cookies
                $('#reject-cookies').click(function() {
                    hideCookiesAlert();
                    disableLoginButton();
                });
                
                // Mostrar aviso nuevamente
                $('#show-cookies-btn').click(function() {
                    $('.cookies-alert').addClass('show');
                    $(this).hide();
                });
            }
        }
        
        
        function hideCookiesAlert() {
            $('.cookies-alert').removeClass('show');
        }
        
        
        function enableLoginButton() {
            const loginBtn = $('input[name="login"]');
            if (loginBtn.length) {
                loginBtn.prop('disabled', false).css('opacity', '1');
                loginBtn.attr('title', 'Iniciar Sesión');
            }
        }
        
        
        function disableLoginButton() {
            const loginBtn = $('input[name="login"]');
            if (loginBtn.length) {
                loginBtn.prop('disabled', true).css('opacity', '0.5');
                loginBtn.attr('title', 'Debes aceptar las cookies para continuar');
                $('#show-cookies-btn').show();
            }
        }
    };

    
    
    /**
     * Inicializa un slider con Slick Carousel
     * @param {string} selector - Selector CSS del slider
     * @param {object} options - Opciones de configuración
     */
    window.initSlider = function(selector, options = {}) {
        // Valores por defecto de configuración responsiva
        const defaultOptions = {
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }
            ],
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            speed: 500,
            autoplay: true,
            autoplaySpeed: 4000,
            dots: true,
            arrows: true,
            prevArrow: '<button class="slick-prev" aria-label="Anterior">❮</button>',
            nextArrow: '<button class="slick-next" aria-label="Siguiente">❯</button>',
            ...options
        };
        
        $(selector).slick(defaultOptions);
    };
    
    /**
     * Destruye un slider de Slick
     * @param {string} selector - Selector CSS del slider
     */
    window.destroySlider = function(selector) {
        if ($(selector).hasClass('slick-initialized')) {
            $(selector).slick('unslick');
        }
    };
    
    /**
     * Reinicializa un slider (útil para cambios de resolución)
     * @param {string} selector - Selector CSS del slider
     * @param {object} options - Opciones de configuración
     */
    window.reinitSlider = function(selector, options = {}) {
        destroySlider(selector);
        initSlider(selector, options);
    };

    
    
    
    $(window).resize(function() {
        
    });
});


if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        
    });
}
