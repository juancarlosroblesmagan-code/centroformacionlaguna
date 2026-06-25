<?php
/**
 * Plugin Name: Reglas de SEO y Privacidad Local - Anti-Gravity
 * Description: Fuerza directivas no-index, robots.txt restrictivo y bloquea las llamadas API de Rank Math en el entorno local de Docker.
 * Version: 1.0.0
 * Author: Anti-Gravity Engine
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Seguridad
}

// SOLO se activa si estamos en el entorno local de desarrollo
$is_local_env = ( strpos( $_SERVER['HTTP_HOST'] ?? '', 'localhost' ) !== false ) || ( strpos( $_SERVER['HTTP_HOST'] ?? '', '127.0.0.1' ) !== false );
if ( $is_local_env ) {

    // 1. Forzar opción nativa de WordPress de no indexación
    add_action( 'init', function() {
        if ( get_option( 'blog_public' ) !== '0' ) {
            update_option( 'blog_public', '0' );
        }
    });

    // 2. Modificar etiquetas robots de Rank Math a noindex, nofollow
    add_filter( 'rank_math/frontend/robots', function( $robots ) {
        $robots['index']  = 'noindex';
        $robots['follow'] = 'nofollow';
        return $robots;
    }, 9999 );

    // 3. Forzar archivo robots.txt virtual restrictivo
    add_filter( 'robots_txt', function( $output, $public ) {
        return "User-agent: *\nDisallow: /\n";
    }, 9999, 2 );

    // 4. Bloquear cualquier petición HTTP saliente externa en local para evitar timeouts lentos
    add_filter( 'pre_http_request', function( $preempt, $parsed_args, $url ) {
        $host = parse_url( $url, PHP_URL_HOST );
        if ( $host && ! in_array( $host, array( 'localhost', '127.0.0.1', 'db', 'wordpress' ) ) && strpos( $host, 'wordpress.org' ) === false ) {
            return new WP_Error( 'blocked_request', 'External HTTP request blocked locally: ' . $host );
        }
        return $preempt;
    }, 10, 3 );

    // 5. Simular registro activo para evitar avisos de conexión en el panel
    add_filter( 'rank_math/registration/is_registered', '__return_true' );

    // 6. Añadir aviso visual sutil e inofensivo en la barra de administración de WordPress
    add_action( 'admin_bar_menu', function( $wp_admin_bar ) {
        $args = array(
            'id'    => 'cis-local-seo-alert',
            'title' => '<span style="color:#ffb606; font-weight:bold;">⚠️ Entorno de Pruebas (No Indexable)</span>',
            'meta'  => array( 'class' => 'cis-local-seo-alert-class' )
        );
        $wp_admin_bar->add_node( $args );
    }, 999 );

}
