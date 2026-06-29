/**
 * Centro Formacion Laguna - Custom JavaScript
 * Centro de Educación Polivalente
 */
(function($) {
    'use strict';

    // ============================================================
    // INIT
    // ============================================================
    $(document).ready(function() {
        // Evitar ejecutar scripts en el editor de Elementor
        if ($('body').hasClass('elementor-editor-active') || (window.elementorFrontend && window.elementorFrontend.isEditMode())) {
            return;
        }

        centroformacionlaguna_smoothScroll();
        centroformacionlaguna_stickyHeader();
        centroformacionlaguna_animateOnScroll();
        centroformacionlaguna_phoneFormat();
        centroformacionlaguna_collapseAccordion();
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
        if (counterSection) counterObserver.observe(counterSection);    // ============================================================
    // COLAPSO AUTOMÁTICO DE ACORDEÓN DE INICIO
    // ============================================================
    function centroformacionlaguna_collapseAccordion() {
        if ($('body').hasClass('elementor-editor-active') || (window.elementorFrontend && window.elementorFrontend.isEditMode())) {
            return;
        }
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

})(jQuery);


