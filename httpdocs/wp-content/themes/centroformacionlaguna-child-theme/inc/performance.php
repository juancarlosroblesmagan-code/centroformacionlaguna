<?php
/**
 * Optimizaciones de rendimiento para Eduma Child.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Desactiva el preloader del tema (mejora LCP y TTI).
 * Para reactivarlo: Customizer → General → desmarcar o quitar este filtro.
 */
add_filter(
	'theme_mod_thim_preload',
	static function () {
		return false;
	}
);

/**
 * Evita clases de body asociadas al overlay/preload.
 */
add_filter(
	'body_class',
	static function ( $classes ) {
		return array_values(
			array_diff(
				$classes,
				array( 'thim-body-preload', 'thim-body-load-overlay' )
			)
		);
	},
	20
);

/**
 * Sustituye el script inline del footer (preload + delay 500ms en carruseles).
 */
add_action(
	'after_setup_theme',
	static function () {
		remove_action( 'wp_footer', 'thim_js_inline_windowload' );
	},
	20
);

add_action( 'wp_footer', 'eduma_child_footer_scripts', 5 );

/**
 * Ajuste ligero de carruseles Owl solo si existen en la página.
 */
function eduma_child_footer_scripts() {
	?>
	<script>
		window.addEventListener('load', function () {
			if (!document.querySelector('.thim-owl-carousel-post')) {
				return;
			}
			if (typeof jQuery === 'undefined') {
				return;
			}
			jQuery('.thim-owl-carousel-post').each(function () {
				jQuery(this).find('.image').css('min-height', 0);
			});
			jQuery(window).trigger('resize');
		});
	</script>
	<?php
}

/**
 * Quita Google Fonts del tema si ThimPress no gestiona tipografías (TP).
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		wp_dequeue_style( 'thim-fontgoogle-default' );
		wp_deregister_style( 'thim-fontgoogle-default' );
	},
	1002
);

/**
 * Diferir scripts del tema (solo si no hay WP Rocket / FlyingPress, para evitar doble defer).
 */
add_filter(
	'script_loader_tag',
	static function ( $tag, $handle ) {
		if ( function_exists( 'eduma_child_cache_plugin_active' ) && eduma_child_cache_plugin_active() ) {
			return $tag;
		}

		$defer_handles = array(
			'thim-main',
			'thim-scripts',
			'thim-scripts-course-filter',
			'search-course-widget',
			'thim-event-pagination',
		);

		if ( ! in_array( $handle, $defer_handles, true ) ) {
			return $tag;
		}

		if ( false !== strpos( $tag, ' defer', 0 ) ) {
			return $tag;
		}

		return str_replace( ' src', ' defer src', $tag );
	},
	10,
	2
);

/**
 * No cargar el filtro de cursos en LearnPress antiguo fuera del archivo de cursos.
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( function_exists( 'thim_is_new_learnpress' ) && thim_is_new_learnpress( '4.1.6' ) ) {
			return;
		}

		$on_courses = false;

		if ( function_exists( 'thim_check_is_course' ) && thim_check_is_course() ) {
			$on_courses = true;
		}

		if ( is_post_type_archive( 'lp_course' ) || is_tax( 'course_category' ) || is_tax( 'course_tag' ) ) {
			$on_courses = true;
		}

		if ( ! $on_courses ) {
			wp_dequeue_script( 'thim-scripts-course-filter' );
			wp_deregister_script( 'thim-scripts-course-filter' );
		}
	},
	1002
);

/**
 * Reduce CSS inline: omite hojas de demo si el body no usa esa clase de demo.
 */
add_filter(
	'thim_get_var_css_customizer',
	'eduma_child_trim_demo_inline_css',
	100
);

/**
 * @param string $css CSS acumulado del customizer.
 * @return string
 */
function eduma_child_trim_demo_inline_css( $css ) {
	$body_class = (string) get_theme_mod( 'thim_body_custom_class', '' );

	$demo_markers = array(
		'demo-marketplace'      => '/** CSS Demo Marketplace */',
		'demo-ecommerce'        => '/** CSS Demo Ecommerce */',
		'demo-online-learning'  => '/** CSS Demo Online Learning */',
		'demo-education-news'   => '/** CSS Demo Education News */',
		'demo-yoga'             => '/** CSS Demo Yoga */',
		'demo-preschool'        => '/** CSS Demo Preschool */',
		'demo-global-university' => '/** CSS Demo Global University */',
		'eduma-restaurant'      => '/** CSS Demo Restaurant */',
	);

	foreach ( $demo_markers as $needle => $marker ) {
		if ( false !== strpos( $body_class, $needle, 0 ) ) {
			continue;
		}

		$css = eduma_child_remove_css_block_after_marker( $css, $marker );
	}

	if ( 'footer-restaurant' !== get_theme_mod( 'thim_footer_custom_class', '' )
		&& false === strpos( $body_class, 'eduma-restaurant', 0 ) ) {
		$css = eduma_child_remove_css_block_after_marker( $css, '/** CSS Demo Restaurant */' );
	}

	if ( ! class_exists( 'RevSlider' ) ) {
		$css = eduma_child_remove_css_block_after_marker( $css, '/** CSS RevSlider */' );
	}

	return $css;
}

/**
 * Elimina un bloque CSS que empieza en un comentario marcador hasta el siguiente marcador /**.
 *
 * @param string $css    Contenido CSS.
 * @param string $marker Comentario de inicio del bloque.
 * @return string
 */
function eduma_child_remove_css_block_after_marker( $css, $marker ) {
	$start = strpos( $css, $marker );
	if ( false === $start ) {
		return $css;
	}

	$rest  = substr( $css, $start + strlen( $marker ) );
	$next  = preg_match( '/\r?\n\/\*\* CSS /', $rest, $matches, PREG_OFFSET_CAPTURE );
	$end   = $next ? $matches[0][1] : strlen( $rest );

	return substr( $css, 0, $start ) . substr( $rest, $end );
}
