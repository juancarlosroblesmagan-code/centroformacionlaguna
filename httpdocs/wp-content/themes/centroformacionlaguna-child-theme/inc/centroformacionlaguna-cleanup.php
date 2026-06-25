<?php
/**
 * Limpieza visual y textos del demo Eduma en el front de Centro Formacion Laguna.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'eduma_child_centroformacionlaguna_enqueue_assets', 1003 );

/**
 * Estilos y scripts de marca / limpieza demo.
 */
function eduma_child_centroformacionlaguna_enqueue_assets() {
	$css = get_stylesheet_directory() . '/assets/css/centroformacionlaguna.css';
	if ( ! is_readable( $css ) ) {
		return;
	}
	wp_enqueue_style(
		'eduma-child-centroformacionlaguna',
		get_stylesheet_directory_uri() . '/assets/css/centroformacionlaguna.css',
		array( 'eduma-child-style', 'thim-style' ),
		EDUMA_CHILD_VERSION
	);
}

add_filter( 'gettext', 'eduma_child_centroformacionlaguna_translate_strings', 20, 3 );

/**
 * Sustituye cadenas del demo en inglés visibles en el front.
 *
 * @param string $translated
 * @param string $text
 * @param string $domain
 * @return string
 */
function eduma_child_centroformacionlaguna_translate_strings( $translated, $text, $domain ) {
	if ( is_admin() ) {
		return $translated;
	}

	$map = array(
		'Get Free Access'           => 'Obtener acceso gratuito',
		'Full Name*'                => 'Nombre completo*',
		'Email Address*'            => 'Correo electrónico*',
		'Phone Number (optional)'   => 'Teléfono (opcional)',
		'Package Courses'           => 'Programas formativos',
		'View All Packages'         => 'Ver todos los cursos',
		'Share Your Knowledge. Teach the World.' => 'Comparte tu experiencia con el alumnado',
		'Create courses, reach thousands of alumnos, and earn income doing what you love.' => 'Forma parte de nuestro equipo de tutores en Castilla-La Mancha.',
		'Buy now'                   => '',
		'Purchase'                  => '',
		'Premium LMS & Online Education WordPress Theme' => 'Centro Formacion Laguna — Centro de Educación Polivalente',
		'Education WordPress Theme by ThimPress' => '© ' . gmdate( 'Y' ) . ' Centro Formacion Laguna — Formación para el empleo',
		'No deadlines. No pressure.' => 'Formación flexible y orientada a resultados.',
	);

	if ( isset( $map[ $text ] ) ) {
		return $map[ $text ];
	}

	return $translated;
}

add_filter( 'theme_mod_thim_copyright_text', 'eduma_child_centroformacionlaguna_copyright_text' );

/**
 * @param mixed $value
 * @return string
 */
function eduma_child_centroformacionlaguna_copyright_text( $value ) {
	return '© ' . gmdate( 'Y' ) . ' Centro Formacion Laguna — Centro de Educación Polivalente. Formación subvencionada en Castilla-La Mancha.';
}

add_filter( 'theme_mod_thim_copyright_show', '__return_true' );

/**
 * Oculta créditos Thim en el pie si el widget los imprime.
 */
add_action(
	'wp_footer',
	static function () {
		?>
		<style id="eduma-child-centroformacionlaguna-inline">
			.footer .widget a[href*="thimpress.com"],
			.footer .widget a[href*="themeforest"],
			.copyright-area a[href*="thimpress.com"],
			a[href*="thimpress.com/eduma"] { display: none !important; }
		</style>
		<?php
	},
	5
);
