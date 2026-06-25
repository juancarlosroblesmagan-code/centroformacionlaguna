<?php
/**
 * Plugin Name: Profiler de Rendimiento Local - Anti-Gravity
 * Description: Muestra el tiempo de carga, consultas SQL y memoria consumida en un comentario HTML para optimización local.
 * Version: 1.0.0
 * Author: Anti-Gravity Engine
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( getenv('WORDPRESS_DB_HOST') ) {
    add_action( 'wp_footer', 'antigravity_print_performance_stats', 9999 );
    add_action( 'admin_footer', 'antigravity_print_performance_stats', 9999 );
}

function antigravity_print_performance_stats() {
    global $wpdb;
    
    $time    = timer_stop( 0, 4 );
    $queries = get_num_queries();
    $memory  = round( memory_get_peak_usage() / 1024 / 1024, 2 );
    
    echo "\n<!-- RENDIMIENTO LOCAL (Anti-Gravity): Tiempo de generación: {$time}s | Consultas SQL: {$queries} | Pico de memoria: {$memory}MB -->\n";
}
