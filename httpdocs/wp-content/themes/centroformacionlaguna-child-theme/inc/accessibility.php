<?php
/**
 * Mejoras de accesibilidad para menú móvil y navegación.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', 'eduma_child_mobile_menu_a11y_script', 20 );

/**
 * Añade role, aria-label y teclado a toggles del menú móvil (div.icon-bar).
 */
function eduma_child_mobile_menu_a11y_script() {
	$label_open  = esc_js( __( 'Open menu', 'eduma-child' ) );
	$label_close = esc_js( __( 'Close menu', 'eduma-child' ) );
	?>
	<script>
		(function () {
			var toggles = document.querySelectorAll('.menu-mobile-effect');
			if (!toggles.length) {
				return;
			}

			toggles.forEach(function (el) {
				if (el.getAttribute('role') === 'button') {
					return;
				}
				el.setAttribute('role', 'button');
				el.setAttribute('tabindex', '0');
				el.setAttribute('aria-expanded', 'false');
				el.setAttribute('aria-label', '<?php echo $label_open; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>');

				el.addEventListener('click', function () {
					var open = document.body.classList.contains('mobile-menu-open');
					el.setAttribute('aria-expanded', open ? 'true' : 'false');
					el.setAttribute('aria-label', open ? '<?php echo $label_close; // phpcs:ignore ?>' : '<?php echo $label_open; // phpcs:ignore ?>');
				});

				el.addEventListener('keydown', function (e) {
					if (e.key === 'Enter' || e.key === ' ') {
						e.preventDefault();
						el.click();
					}
				});
			});
		})();
	</script>
	<?php
}
