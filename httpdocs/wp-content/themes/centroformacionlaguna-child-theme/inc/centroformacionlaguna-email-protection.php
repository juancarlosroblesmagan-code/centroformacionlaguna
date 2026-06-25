<?php
/**
 * Protección anti-scrapers para el email de contacto (HTML público).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'centroformacionlaguna_should_protect_emails' ) ) {
	/**
	 * ¿Aplicar ofuscación en esta petición?
	 */
	function centroformacionlaguna_should_protect_emails() {
		if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
			return false;
		}
		if ( is_feed() || is_trackback() ) {
			return false;
		}
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			return false;
		}
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			return false;
		}
		return true;
	}
}

if ( ! function_exists( 'centroformacionlaguna_protected_email_addresses' ) ) {
	/**
	 * Emails que se ofuscan en el front.
	 *
	 * @return string[]
	 */
	function centroformacionlaguna_protected_email_addresses() {
		$primary = defined( 'CENTROFORMACIONLAGUNA_CONTACT_EMAIL' ) ? CENTROFORMACIONLAGUNA_CONTACT_EMAIL : 'info@centroscentroformacionlaguna.com';
		$emails  = array( $primary, 'info@centroformacionlaguna.net' );
		return array_unique( array_filter( $emails ) );
	}
}

if ( ! function_exists( 'centroformacionlaguna_build_protected_email_link' ) ) {
	/**
	 * Enlace mailto ofuscado (href real solo con JavaScript).
	 *
	 * @param string      $email Email completo.
	 * @param string|null $label Texto visible.
	 * @return string
	 */
	function centroformacionlaguna_build_protected_email_link( $email, $label = null ) {
		$label = null !== $label ? $label : $email;
		$parts = explode( '@', $email, 2 );
		if ( count( $parts ) !== 2 ) {
			return esc_html( $label );
		}

		list( $user, $domain ) = $parts;
		$display               = function_exists( 'antispambot' ) ? antispambot( $label ) : esc_html( $label );

		return sprintf(
			'<a href="#" class="centroformacionlaguna-protected-email" data-centroformacionlaguna-user="%1$s" data-centroformacionlaguna-domain="%2$s" rel="nofollow noopener" aria-label="%3$s">%4$s</a>',
			esc_attr( base64_encode( $user ) ),
			esc_attr( base64_encode( $domain ) ),
			esc_attr( sprintf( 'Enviar correo a %s', $email ) ),
			$display
		);
	}
}

if ( ! function_exists( 'centroformacionlaguna_build_protected_email_text' ) ) {
	/**
	 * Texto de email ofuscado (el carácter @ no va en HTML plano).
	 *
	 * @param string $email Email completo.
	 * @return string
	 */
	function centroformacionlaguna_build_protected_email_text( $email ) {
		$parts = explode( '@', $email, 2 );
		if ( count( $parts ) !== 2 ) {
			return esc_html( $email );
		}

		list( $user, $domain ) = $parts;

		return sprintf(
			'<span class="centroformacionlaguna-protected-email-text" data-centroformacionlaguna-user="%1$s" data-centroformacionlaguna-domain="%2$s" aria-label="%3$s"><span class="centroformacionlaguna-email-user">%4$s</span><span class="centroformacionlaguna-email-at" aria-hidden="true"></span><span class="centroformacionlaguna-email-domain">%5$s</span></span>',
			esc_attr( base64_encode( $user ) ),
			esc_attr( base64_encode( $domain ) ),
			esc_attr( $email ),
			esc_html( $user ),
			esc_html( $domain )
		);
	}
}

if ( ! function_exists( 'centroformacionlaguna_protect_emails_in_html' ) ) {
	/**
	 * Ofusca emails en HTML (JSON-LD se excluye temporalmente del buffer).
	 *
	 * @param string $html HTML de la página.
	 * @return string
	 */
	function centroformacionlaguna_protect_emails_in_html( $html ) {
		if ( ! is_string( $html ) || strpos( $html, '@' ) === false ) {
			return $html;
		}

		// Reparar email del footer si quedó doblemente ofuscado en el widget.
		$html = preg_replace(
			'/(<strong>Email:<\/strong>\s*)<a\b[^>]*\bcentroformacionlaguna-protected-email\b[^>]*>[\s\S]*?<\/a>/i',
			'$1<a href="mailto:info@centroscentroformacionlaguna.com">info@centroscentroformacionlaguna.com</a>',
			$html
		);

		$placeholders = array();
		$hold_block     = static function ( $matches ) use ( &$placeholders ) {
			$key                  = '<!--CENTROFORMACIONLAGUNA_HOLD_' . count( $placeholders ) . '-->';
			$placeholders[ $key ] = $matches[0];
			return $key;
		};

		$html = preg_replace_callback(
			'/<script\b[^>]*type\s*=\s*["\']application\/ld\+json["\'][^>]*>[\s\S]*?<\/script>/i',
			$hold_block,
			$html
		);

		$html = preg_replace_callback(
			'/<a\b[^>]*\bclass="[^"]*\bcentroformacionlaguna-protected-email\b[^"]*"[^>]*>[\s\S]*?<\/a>/i',
			$hold_block,
			$html
		);

		$html = preg_replace_callback(
			'/<span\b[^>]*\bclass="[^"]*\bcentroformacionlaguna-protected-email-text\b[^"]*"[^>]*>[\s\S]*?<\/span>/i',
			$hold_block,
			$html
		);

		foreach ( centroformacionlaguna_protected_email_addresses() as $email ) {
			$quoted = preg_quote( $email, '/' );

			$html = preg_replace_callback(
				'/<a\b(?![^>]*\bcentroformacionlaguna-protected-email\b)[^>]*\bhref\s*=\s*["\']mailto:' . $quoted . '["\'][^>]*>[\s\S]*?<\/a>/i',
				static function ( $matches ) use ( $email ) {
					if ( preg_match( '/<a\b[^>]*>([\s\S]*?)<\/a>/i', $matches[0], $label_match ) ) {
						$label = wp_strip_all_tags( $label_match[1] );
						if ( false !== strpos( $label, 'centroformacionlaguna-email-' ) || false !== strpos( $label, '&gt;' ) ) {
							$label = $email;
						}
						return centroformacionlaguna_build_protected_email_link( $email, $label ? $label : null );
					}
					return centroformacionlaguna_build_protected_email_link( $email );
				},
				$html
			);

			// Solo texto visible entre etiquetas (no atributos HTML).
			$html = preg_replace_callback(
				'/>([^<]*' . $quoted . '[^<]*)</i',
				static function ( $matches ) use ( $email ) {
					return '>' . str_ireplace( $email, centroformacionlaguna_build_protected_email_text( $email ), $matches[1] ) . '<';
				},
				$html
			);
		}

		foreach ( $placeholders as $key => $block ) {
			$html = str_replace( $key, $block, $html );
		}

		return $html;
	}
}

if ( ! function_exists( 'centroformacionlaguna_email_protection_inline_script' ) ) {
	/**
	 * Script mínimo: monta mailto solo en el navegador.
	 */
	function centroformacionlaguna_email_protection_inline_script() {
		if ( ! centroformacionlaguna_should_protect_emails() ) {
			return;
		}
		?>
		<script id="centroformacionlaguna-email-protection">
		(function () {
			function decode(v) {
				try { return atob(v || ''); } catch (e) { return ''; }
			}
			document.querySelectorAll('.centroformacionlaguna-protected-email').forEach(function (el) {
				var u = decode(el.getAttribute('data-centroformacionlaguna-user'));
				var d = decode(el.getAttribute('data-centroformacionlaguna-domain'));
				if (!u || !d) return;
				el.href = 'mailto:' + u + '@' + d;
			});
		})();
		</script>
		<?php
	}
}

if ( ! function_exists( 'centroformacionlaguna_email_protection_inline_styles' ) ) {
	/**
	 * CSS: el @ solo se pinta en pantalla.
	 */
	function centroformacionlaguna_email_protection_inline_styles() {
		if ( ! centroformacionlaguna_should_protect_emails() ) {
			return;
		}
		echo '<style id="centroformacionlaguna-email-protection-css">.centroformacionlaguna-email-at::before{content:"\\0040";}</style>';
	}
}

if ( ! has_action( 'wp_footer', 'centroformacionlaguna_email_protection_inline_script' ) ) {
	add_action( 'wp_footer', 'centroformacionlaguna_email_protection_inline_script', 99 );
}

if ( ! has_action( 'wp_head', 'centroformacionlaguna_email_protection_inline_styles' ) ) {
	add_action( 'wp_head', 'centroformacionlaguna_email_protection_inline_styles', 99 );
}
