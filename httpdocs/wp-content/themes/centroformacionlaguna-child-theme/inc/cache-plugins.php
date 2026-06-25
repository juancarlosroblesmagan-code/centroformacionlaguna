<?php
/**
 * Integración con WP Rocket y FlyingPress para Eduma.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Scripts que no deben retrasarse ni diferirse (menú, cursos, carrito).
 *
 * @return string[]
 */
function eduma_child_cache_js_exclusions() {
	return array(
		'/jquery/jquery.min.js',
		'/jquery/jquery-migrate',
		'/wp-includes/js/wp-hooks',
		'learn-press',
		'learnpress',
		'/lp-',
		'thim-main',
		'thim-scripts',
		'thim-course-filter',
		'search-course',
		'elementor',
		'elementor-frontend',
		'woocommerce',
		'wc-cart-fragments',
		'js-cookie',
		'imagesloaded',
	);
}

/**
 * Patrones CSS que Remove Unused CSS no debe eliminar (Eduma + LP + Elementor).
 *
 * @return string[]
 */
function eduma_child_cache_css_safelist() {
	return array(
		'.thim',
		'.edu-',
		'.learn-press',
		'.learnpress',
		'.lp-',
		'.lpr_',
		'.menu-mobile',
		'.mobile-menu',
		'.navbar',
		'.affix',
		'#masthead',
		'#wrapper-container',
		'.elementor',
		'.woocommerce',
		'.wc-',
		'.swiper',
		'.owl-',
		'.mfp-',
		'.flexslider',
		'.thim-body',
		'.thim-widget',
		'.course-',
		'.filter-course',
	);
}

/**
 * URLs que no deben cachearse (dinámicas).
 *
 * @return string[]
 */
function eduma_child_cache_uri_exclusions() {
	$paths = array(
		'/cart(.*)',
		'/checkout(.*)',
		'/my-account(.*)',
		'/wishlist(.*)',
		'/learnpress(.*)',
		'/profile(.*)',
	);

	if ( function_exists( 'learn_press_get_page_id' ) ) {
		$courses_id = learn_press_get_page_id( 'courses' );
		if ( $courses_id ) {
			$slug = get_post_field( 'post_name', $courses_id );
			if ( $slug ) {
				$paths[] = '/' . $slug;
			}
		}
	}

	return $paths;
}

/**
 * ¿Hay un plugin de caché que ya gestiona defer/delay?
 */
function eduma_child_cache_plugin_active() {
	return defined( 'WP_ROCKET_VERSION' )
		|| defined( 'FLYING_PRESS_VERSION' )
		|| defined( 'FLYING_PRESS_FILE' );
}

/* -------------------------------------------------------------------------
 * WP Rocket
 * ------------------------------------------------------------------------- */

if ( defined( 'WP_ROCKET_VERSION' ) ) {

	/**
	 * Excluir JS del retraso (Delay JavaScript Execution).
	 */
	add_filter(
		'rocket_delay_js_exclusions',
		static function ( $excluded ) {
			if ( ! is_array( $excluded ) ) {
				$excluded = array();
			}
			return array_values( array_unique( array_merge( $excluded, eduma_child_cache_js_exclusions() ) ) );
		}
	);

	/**
	 * Compatibilidad con opciones guardadas vía pre_get_rocket_option_*.
	 */
	add_filter(
		'pre_get_rocket_option_delay_js_exclusions',
		static function ( $value ) {
			$base = is_array( $value ) ? $value : array();
			return array_values( array_unique( array_merge( $base, eduma_child_cache_js_exclusions() ) ) );
		}
	);

	/**
	 * No diferir jQuery ni scripts críticos del tema (evita doble defer con el child).
	 */
	add_filter(
		'rocket_exclude_defer_js',
		static function ( $excluded ) {
			if ( ! is_array( $excluded ) ) {
				$excluded = array();
			}
			return array_values( array_unique( array_merge( $excluded, eduma_child_cache_js_exclusions() ) ) );
		}
	);

	/**
	 * Safelist para Remove Unused CSS.
	 */
	add_filter(
		'rocket_rucss_safelist',
		static function ( $safelist ) {
			if ( ! is_array( $safelist ) ) {
				$safelist = array();
			}
			return array_values( array_unique( array_merge( $safelist, eduma_child_cache_css_safelist() ) ) );
		}
	);

	/**
	 * No minificar/combinar JS problemático de LearnPress.
	 */
	add_filter(
		'rocket_exclude_js',
		static function ( $excluded ) {
			if ( ! is_array( $excluded ) ) {
				$excluded = array();
			}
			$extra = array(
				'/learn-press/assets/',
				'/learnpress/',
				'thim-course-filter',
			);
			return array_values( array_unique( array_merge( $excluded, $extra ) ) );
		}
	);

	/**
	 * Páginas dinámicas fuera de caché de página completa.
	 */
	add_filter(
		'rocket_cache_reject_uri',
		static function ( $uris ) {
			if ( ! is_array( $uris ) ) {
				$uris = array();
			}
			return array_values( array_unique( array_merge( $uris, eduma_child_cache_uri_exclusions() ) ) );
		}
	);
}

/* -------------------------------------------------------------------------
 * FlyingPress (exclusiones vía filtros cuando existen; UI como respaldo)
 * ------------------------------------------------------------------------- */

if ( defined( 'FLYING_PRESS_VERSION' ) || defined( 'FLYING_PRESS_FILE' ) ) {

	/**
	 * Excluir de “Delay JavaScript” (nombre de filtro usado en versiones recientes).
	 */
	add_filter(
		'flying_press_exclude_from_delay_js',
		static function ( $exclude ) {
			if ( ! is_array( $exclude ) ) {
				$exclude = array();
			}
			return array_values( array_unique( array_merge( $exclude, eduma_child_cache_js_exclusions() ) ) );
		}
	);

	/**
	 * Alias alternativo en algunas builds.
	 */
	add_filter(
		'flying_press_delay_js_exclusions',
		static function ( $exclude ) {
			if ( ! is_array( $exclude ) ) {
				$exclude = array();
			}
			return array_values( array_unique( array_merge( $exclude, eduma_child_cache_js_exclusions() ) ) );
		}
	);

	add_filter(
		'flying_press_exclude_defer_js',
		static function ( $exclude ) {
			if ( ! is_array( $exclude ) ) {
				$exclude = array();
			}
			return array_values( array_unique( array_merge( $exclude, eduma_child_cache_js_exclusions() ) ) );
		}
	);
}
