<?php
/**
 * Conócenos: fondos de sección a ancho completo (100vw).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_head',
	static function () {
		if ( ! is_page( 16705 ) ) {
			return;
		}
		?>
		<style id="centroformacionlaguna-conocenos-full-bleed">
			body.page-id-16705 {
				overflow-x: hidden;
			}
			body.page-id-16705 .container.sidebar-right.site-content,
			body.page-id-16705 .container.sidebar-right.site-content > .row,
			body.page-id-16705 main.site-main.col-sm-9,
			body.page-id-16705 main.site-main,
			body.page-id-16705 #main.site-main,
			body.page-id-16705 .entry-content,
			body.page-id-16705 .elementor-16705,
			body.page-id-16705 .elementor-16705 .e-con-inner,
			body.page-id-16705 .elementor-widget-text-editor .elementor-widget-container {
				max-width: 100% !important;
				width: 100% !important;
				padding-left: 0 !important;
				padding-right: 0 !important;
			}
			body.page-id-16705 .cis-about-page {
				width: 100%;
				max-width: none;
				overflow: visible;
			}
			body.page-id-16705 .cis-about-page section {
				position: relative;
				z-index: 0;
				padding: clamp(72px, 8vw, 96px) 24px !important;
				width: 100vw;
				max-width: 100vw;
				margin-left: calc(50% - 50vw);
				margin-right: calc(50% - 50vw);
				box-sizing: border-box;
			}
			body.page-id-16705 .cis-about-page .cis-about-section-head {
				margin-bottom: 52px !important;
			}
			body.page-id-16705 .cis-about-page .cis-about-section-sub {
				margin-top: 12px;
			}
			body.page-id-16705 .cis-about-centers-cta,
			body.page-id-16705 .cis-about-hero-ctas,
			body.page-id-16705 .cis-about-cta-buttons {
				margin-top: 36px;
			}
			body.page-id-16705 .cis-about-page .cis-about-container {
				max-width: 1240px;
				margin-left: auto;
				margin-right: auto;
				width: 100%;
			}
		</style>
		<?php
	},
	99
);
