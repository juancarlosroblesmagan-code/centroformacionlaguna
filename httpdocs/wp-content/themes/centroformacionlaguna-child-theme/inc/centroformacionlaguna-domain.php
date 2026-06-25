<?php
/**
 * Preparación para el dominio definitivo centroformacionlaguna.net.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Email de contacto oficial del centro.
 */
const CENTROFORMACIONLAGUNA_CONTACT_EMAIL = 'info@centroscentroformacionlaguna.com';

/**
 * Sustituye el email antiguo inexistente en contenido renderizado.
 *
 * @param string $content HTML o texto.
 * @return string
 */
function centroformacionlaguna_replace_legacy_email( $content ) {
	if ( ! is_string( $content ) || $content === '' ) {
		return $content;
	}
	return str_replace( 'info@centroformacionlaguna.net', CENTROFORMACIONLAGUNA_CONTACT_EMAIL, $content );
}

add_filter( 'widget_text', 'centroformacionlaguna_replace_legacy_email', 20 );
add_filter( 'widget_text_content', 'centroformacionlaguna_replace_legacy_email', 20 );
add_filter( 'the_content', 'centroformacionlaguna_replace_legacy_email', 20 );

add_action(
	'template_redirect',
	static function () {
		if ( is_admin() ) {
			return;
		}
		if ( defined( 'CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE' ) && CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE && is_front_page() ) {
			return;
		}
		ob_start(
			static function ( $html ) {
				if ( ! is_string( $html ) ) {
					return $html;
				}
				$html = centroformacionlaguna_replace_legacy_email( $html );
				if ( function_exists( 'centroformacionlaguna_should_protect_emails' ) && centroformacionlaguna_should_protect_emails() ) {
					$html = centroformacionlaguna_protect_emails_in_html( $html );
				}
				return $html;
			}
		);
	},
	0
);

/**
 * Cuando cambies DNS a centroformacionlaguna.net, actualiza también:
 * Ajustes → Generales → Direcciones WordPress y del sitio.
 *
 * Este filtro permite forzar URLs si defines la constante en wp-config.php:
 * define( 'CENTROFORMACIONLAGUNA_HOME_URL', 'https://centroformacionlaguna.net' );
 */
add_filter(
	'home_url',
	static function ( $url, $path, $scheme, $blog_id ) {
		if ( defined( 'CENTROFORMACIONLAGUNA_HOME_URL' ) && CENTROFORMACIONLAGUNA_HOME_URL ) {
			return trailingslashit( CENTROFORMACIONLAGUNA_HOME_URL ) . ltrim( (string) $path, '/' );
		}
		return $url;
	},
	10,
	4
);

add_filter(
	'site_url',
	static function ( $url, $path, $scheme, $blog_id ) {
		if ( defined( 'CENTROFORMACIONLAGUNA_SITE_URL' ) && CENTROFORMACIONLAGUNA_SITE_URL ) {
			return trailingslashit( CENTROFORMACIONLAGUNA_SITE_URL ) . ltrim( (string) $path, '/' );
		}
		return $url;
	},
	10,
	4
);
