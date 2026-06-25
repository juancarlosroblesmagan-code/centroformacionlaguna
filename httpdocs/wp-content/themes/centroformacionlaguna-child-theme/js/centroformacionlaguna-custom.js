/**
 * Centro Formacion Laguna - Custom JavaScript
 * Centro de Educación Polivalente
 */
(function($) {
    'use strict';

    // ============================================================
    // INIT
    // ============================================================    $(document).ready(function() {
        centroformacionlaguna_smoothScroll();
        centroformacionlaguna_stickyHeader();
        centroformacionlaguna_animateOnScroll();
        centroformacionlaguna_phoneFormat();
        centroformacionlaguna_setupAccordionTexts();
        centroformacionlaguna_collapseAccordion();
        centroformacionlaguna_setupHomepageEvents();
    });


    // ============================================================
    // SMOOTH SCROLL para enlaces internos
    // ============================================================
    function centroformacionlaguna_smoothScroll() {
        $('a[href^="#"]').not('[href="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 600, 'swing');
            }
        });
    }


    // ============================================================
    // STICKY HEADER con cambio de estilo al hacer scroll
    // ============================================================
    function centroformacionlaguna_stickyHeader() {
        var $header = $('#header, .site-header, header.header').first();
        var scrollTrigger = 100;

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > scrollTrigger) {
                $header.addClass('is-sticky-active');
            } else {
                $header.removeClass('is-sticky-active');
            }
        });
    }


    // ============================================================
    // ANIMACIONES AL HACER SCROLL (Intersection Observer)
    // ============================================================
    function centroformacionlaguna_animateOnScroll() {
        if (!('IntersectionObserver' in window)) return;

        var animatedElements = document.querySelectorAll(
            '.course-item, .plan-card, .icon-box, .testimonial-item, .post-item'
        );

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        animatedElements.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    }


    // ============================================================
    // TELÉFONO — Hacer clicable en móvil automáticamente
    // ============================================================
    function centroformacionlaguna_phoneFormat() {
        if (/Android|iPhone|iPad/i.test(navigator.userAgent)) {
            $('.centroformacionlaguna-phone, .topbar .phone').each(function() {
                var text = $(this).text().trim();
                var cleaned = text.replace(/\s+/g, '');
                if (!$(this).is('a')) {
                    $(this).wrap('<a href="tel:' + cleaned + '"></a>');
                }
            });
        }
    }


    // ============================================================
    // CONTADOR DE ESTADÍSTICAS (si existe en página)
    // ============================================================
    function centroformacionlaguna_counterUp() {
        if (!$.fn.countTo) return;

        $('.counter-number, .stat-number').each(function() {
            var $this = $(this);
            var target = parseInt($this.data('target') || $this.text(), 10);

            $this.prop('Counter', 0).animate({
                Counter: target
            }, {
                duration: 2000,
                easing: 'swing',
                step: function(now) {
                    $this.text(Math.ceil(now));
                }
            });
        });
    }

    // Activar contador cuando entra en viewport
    if ('IntersectionObserver' in window) {
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    centroformacionlaguna_counterUp();
                    counterObserver.disconnect();
                }
            });
        });
        var counterSection = document.querySelector('.counters-section, .stats-section');
        if (counterSection) counterObserver.observe(counterSection);
    }

    // ============================================================
    // CONFIGURACIÓN DE TEXTOS DE ACORDEÓN DE INICIO PARA SEO
    // ============================================================
    function centroformacionlaguna_setupAccordionTexts() {
        var coursesUrl = '/cursos-subvencionados-castilla-la-mancha/';
        var comoUrl = '/como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha/';
        var contactUrl = '/contacto/';

        var texts = {
            '920e3b8': 'Impulsa tu carrera profesional en <strong>Castilla-La Mancha</strong> con nuestros <strong>cursos gratuitos subvencionados para trabajadores activos y autónomos</strong>. Financiados por el SEPE y la Junta de Comunidades de Castilla-La Mancha (JCCM), te ofrecemos una formación <strong>100% online y flexible</strong>, adaptada a tus horarios y sin costes de matrícula. Especialízate en áreas clave como digitalización, competencias digitales, gestión empresarial, idiomas y prevención de riesgos laborales con titulación oficial baremable. <a href="' + coursesUrl + '">Explora el catálogo de cursos activos</a> o <a href="' + comoUrl + '">aprende cómo matricularte paso a paso</a>.',
            '95852de': 'Mejora tu empleabilidad y reingresa al mercado laboral con nuestros <strong>cursos subvencionados para desempleados en Castilla-La Mancha</strong>. Ponemos a tu disposición una amplia oferta de <strong>formación online gratuita</strong> con tutorías personalizadas. Desarrolla las habilidades más demandadas por las empresas en sectores como administración, ofimática en la nube, logística, comercio y marketing digital. Te guiamos de forma integral en la tramitación de tu plaza y obtención del certificado oficial de aprovechamiento. <a href="' + coursesUrl + '">Ver cursos disponibles para desempleados</a>.',
            '2d48fb3': 'Maximiza la productividad y competitividad de tu equipo mediante la <strong>formación bonificada para empresas (crédito FUNDAE)</strong>. En Centro Formacion Laguna diseñamos e impartimos planes formativos a medida y sin coste directo para tu organización, gestionando todo el proceso de bonificación ante el SEPE. Capacita a tu plantilla en herramientas de oficina digital, liderazgo, idiomas aplicados y prevención de riesgos laborales de manera cómoda y eficaz. <a href="' + contactUrl + '">Solicita consultoría de formación bonificada</a>.',
            '189de56': 'En Centro Formacion Laguna garantizamos un aprendizaje de alta calidad gracias a nuestro equipo de <strong>tutores expertos y especializados</strong>. A diferencia de otras plataformas autogestionadas, aquí dispondrás de acompañamiento docente continuo: resolvemos tus dudas en menos de 24 horas, realizamos un seguimiento de tus progresos y te orientamos de manera práctica en cada módulo. Disfruta de una experiencia de aprendizaje interactiva, humana y orientada al éxito en tu carrera. <a href="' + coursesUrl + '">Descubre nuestro método de enseñanza</a>.'
        };

        $.each(texts, function(id, html) {
            $('[data-interaction-id="' + id + '"]').html(html);
        });
    }

    // ============================================================
    // COLAPSO AUTOMÁTICO DE ACORDEÓN DE INICIO
    // ============================================================
    function centroformacionlaguna_collapseAccordion() {
        var collapseFn = function() {
            var $accordionItems = $('.e-n-accordion-item');
            if ($accordionItems.length) {
                $accordionItems.removeAttr('open');
                $accordionItems.find('.e-n-accordion-item-title').attr('aria-expanded', 'false');
                $accordionItems.find('.e-n-accordion-item-title').removeClass('elementor-active');
            }
        };

        // Ejecutar inmediatamente
        collapseFn();

        // Ejecutar al completar la carga de la ventana
        $(window).on('load', collapseFn);

        // Reintentos con retardos para sobreescribir la inicialización tardía de Elementor
        setTimeout(collapseFn, 100);
        setTimeout(collapseFn, 500);
        setTimeout(collapseFn, 1000);
    }

    // ============================================================
    // REPLANTEAR SECCIÓN DE EVENTOS EN LA HOME
    // ============================================================
    function centroformacionlaguna_setupHomepageEvents() {
        var $eventsContainer = $('[data-id="d87535a"]');
        if (!$eventsContainer.length) return;

        var contactUrl = '/contacto/';
        var eventsHtml = ' \
            <div class="centroformacionlaguna-home-events-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; width: 100%; margin-top: 20px; box-sizing: border-box;"> \
                <div class="centroformacionlaguna-home-event-card" style="background: #ffffff; border: 1px solid #efe2e2; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 18px rgba(139,26,26,0.03); transition: all 0.3s ease; box-sizing: border-box; min-height: 250px;"> \
                    <div> \
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;"> \
                            <span style="font-size: 1.5rem;">📋</span> \
                            <span style="background: #D4880A; color: #ffffff; font-size: 0.75rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">Plazas limitadas</span> \
                        </div> \
                        <div style="color: #8B1A1A; font-weight: 700; font-size: 0.85rem; margin-bottom: 8px;">26 de Junio · 18:30 h</div> \
                        <h4 style="font-family: Merriweather, Georgia, serif; color: #8B1A1A; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 700; line-height: 1.4;">Webinar: Inscripción SEPE sin drama</h4> \
                        <p style="color: #666666; font-size: 0.85rem; line-height: 1.5; margin: 0 0 16px 0;">Documentación, plazos y errores típicos. Sales sabiendo qué hacer y qué no mandar por correo.</p> \
                    </div> \
                    <a href="' + contactUrl + '?asunto=Webinar%20Inscripcion%20SEPE" style="display: block; width: 100%; text-align: center; background: #8B1A1A; color: #ffffff; padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background=\'#D4880A\'" onmouseout="this.style.background=\'#8B1A1A\'">Reservar plaza</a> \
                </div> \
                <div class="centroformacionlaguna-home-event-card" style="background: #ffffff; border: 1px solid #efe2e2; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 18px rgba(139,26,26,0.03); transition: all 0.3s ease; box-sizing: border-box; min-height: 250px;"> \
                    <div> \
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;"> \
                            <span style="font-size: 1.5rem;">📊</span> \
                            <span style="background: #8B1A1A; color: #ffffff; font-size: 0.75rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">Demostración</span> \
                        </div> \
                        <div style="color: #8B1A1A; font-weight: 700; font-size: 0.85rem; margin-bottom: 8px;">10 de Julio · 11:00 h</div> \
                        <h4 style="font-family: Merriweather, Georgia, serif; color: #8B1A1A; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 700; line-height: 1.4;">Taller exprés: Excel para humanos</h4> \
                        <p style="color: #666666; font-size: 0.85rem; line-height: 1.5; margin: 0 0 16px 0;">Muestra en vivo de lo que aprenderás. Spoiler: las tablas dinámicas no muerden (mucho).</p> \
                    </div> \
                    <a href="' + contactUrl + '?asunto=Taller%20Excel%20para%20humanos" style="display: block; width: 100%; text-align: center; background: #8B1A1A; color: #ffffff; padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background=\'#D4880A\'" onmouseout="this.style.background=\'#8B1A1A\'">Reservar plaza</a> \
                </div> \
                <div class="centroformacionlaguna-home-event-card" style="background: #ffffff; border: 1px solid #efe2e2; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 18px rgba(139,26,26,0.03); transition: all 0.3s ease; box-sizing: border-box; min-height: 250px;"> \
                    <div> \
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;"> \
                            <span style="font-size: 1.5rem;">☕</span> \
                            <span style="background: #D4880A; color: #ffffff; font-size: 0.75rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">Empresas</span> \
                        </div> \
                        <div style="color: #8B1A1A; font-weight: 700; font-size: 0.85rem; margin-bottom: 8px;">24 de Julio · 09:30 h</div> \
                        <h4 style="font-family: Merriweather, Georgia, serif; color: #8B1A1A; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 700; line-height: 1.4;">Desayuno digital para empresas</h4> \
                        <p style="color: #666666; font-size: 0.85rem; line-height: 1.5; margin: 0 0 16px 0;">Bonificación, crédito de formación y cómo aprovechar las cotizaciones acumuladas.</p> \
                    </div> \
                    <a href="' + contactUrl + '?asunto=Desayuno%20Digital%20Empresas" style="display: block; width: 100%; text-align: center; background: #8B1A1A; color: #ffffff; padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background=\'#D4880A\'" onmouseout="this.style.background=\'#8B1A1A\'">Reservar plaza</a> \
                </div> \
            </div>';

        $eventsContainer.html(eventsHtml);
    }

})(jQuery);


