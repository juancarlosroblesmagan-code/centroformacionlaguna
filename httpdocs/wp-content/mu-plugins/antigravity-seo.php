<?php
/**
 * Plugin Name: Inyector de Enlaces Corporativos SEO - Anti-Gravity
 * Description: Inyecta automáticamente los enlaces de Hipotecas (DH Brokers) y VipOfertas en el footer de forma nativa con estilos integrados.
 * Version: 1.1.0
 * Author: Anti-Gravity Engine
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Seguridad
}

// add_action( 'wp_footer', 'antigravity_inyectar_enlaces_seo' );

function antigravity_inyectar_enlaces_seo() {
    ?>
    <!-- Bloque Corporativo Automatizado por Anti-Gravity -->
    <div class="cis-enlaces-corporativos">
        <div class="cis-container">
            <p>
                <span class="cis-title">Recomendamos:</span>
                <a href="https://www.dhbrokers.es" target="_blank" rel="noopener" title="DH Brokers - Asesoramiento Hipotecario">Hipotecas</a>
                <span class="cis-separator">•</span>
                <a href="https://vipofertas.es" target="_blank" rel="noopener" title="VipOfertas - Descuentos y Ofertas">VipOfertas</a>
            </p>
        </div>
    </div>

    <style>
    /* Estilos elegantes, responsivos y 100% VISIBLES para Google */
    .cis-enlaces-corporativos {
        width: 100%;
        background-color: #111111; /* Fondo oscuro integrado con el footer */
        border-top: 1px solid #222222;
        padding: 15px 10px;
        text-align: center;
        clear: both;
        box-sizing: border-box;
    }
    .cis-enlaces-corporativos .cis-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .cis-enlaces-corporativos p {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        font-size: 13px;
        color: #888888;
        margin: 0;
        line-height: 1.5;
    }
    .cis-enlaces-corporativos .cis-title {
        font-weight: 600;
        color: #bbbbbb;
        margin-right: 10px;
    }
    .cis-enlaces-corporativos a {
        color: #ffb606; /* Color dorado primario del tema Eduma */
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }
    .cis-enlaces-corporativos a:hover {
        color: #ffffff;
        text-shadow: 0 0 5px rgba(255, 182, 6, 0.5);
    }
    .cis-enlaces-corporativos .cis-separator {
        color: #444444;
        margin: 0 10px;
        font-size: 11px;
    }
    </style>
    <?php
}