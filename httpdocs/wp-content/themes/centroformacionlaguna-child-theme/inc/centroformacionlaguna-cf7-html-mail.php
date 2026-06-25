<?php
/**
 * CF7: enviar correos como HTML cuando el cuerpo incluye etiquetas.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'wpcf7_mail_components',
	static function ( $components, $contact_form, $mail_template ) {
		if ( ! is_array( $components ) || empty( $components['body'] ) ) {
			return $components;
		}

		$body = $components['body'];
		if ( false !== stripos( $body, '<' ) && false !== stripos( $body, '>' ) ) {
			$components['use_html'] = true;
		}

		return $components;
	},
	10,
	3
);
