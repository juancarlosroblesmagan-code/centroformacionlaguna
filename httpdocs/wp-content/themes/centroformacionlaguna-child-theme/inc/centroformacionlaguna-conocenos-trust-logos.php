<?php
/**
 * Conócenos: logos de acreditaciones en una sola línea (tamaños del editor).
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
		<style id="centroformacionlaguna-conocenos-trust-logos">
			body.page-id-16705 .cis-about-trust-logos-only,
			body.page-id-16705 .cis-about-trust-row.cis-about-trust-logos-only {
				display: flex !important;
				flex-direction: row !important;
				flex-wrap: nowrap !important;
				align-items: center !important;
				justify-content: center !important;
				gap: clamp(12px, 2vw, 32px) !important;
				width: 100%;
				max-width: 100%;
				margin: 0 auto;
				padding: 12px 4px 20px !important;
				grid-template-columns: none !important;
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
			}

			body.page-id-16705 .cis-about-trust-logos-only img {
				display: block !important;
				flex: 0 0 auto !important;
				float: none !important;
				margin: 0 !important;
				object-fit: contain !important;
				max-width: none !important;
			}

			body.page-id-16705 .cis-about-trust-logos-only .aligncenter {
				display: block !important;
				margin-left: 0 !important;
				margin-right: 0 !important;
			}

			/* Tamaños definidos en el editor de la página (width/height). */
			body.page-id-16705 .cis-about-trust-logos-only img.cis-about-trust-logo--jccm {
				width: 164px !important;
				height: auto !important;
				max-height: 109px;
			}

			body.page-id-16705 .cis-about-trust-logos-only img.wp-image-16846 {
				width: 218px !important;
				height: 44px !important;
			}

			body.page-id-16705 .cis-about-trust-logos-only img.wp-image-16847 {
				width: 214px !important;
				height: 46px !important;
			}

			body.page-id-16705 .cis-about-trust-logos-only img.cis-about-trust-logo--fundae {
				width: 185px !important;
				height: 44px !important;
			}

			body.page-id-16705 .cis-about-trust-logos-only img.cis-about-trust-logo--ue {
				width: 117px !important;
				height: 117px !important;
			}

			@media (max-width: 1024px) {
				body.page-id-16705 .cis-about-stats-grid,
				body.page-id-16705 .cis-about-centers-grid,
				body.page-id-16705 .cis-about-services-grid {
					grid-template-columns: repeat(2, 1fr) !important;
				}

				body.page-id-16705 .cis-about-trust-logos-only,
				body.page-id-16705 .cis-about-trust-row.cis-about-trust-logos-only {
					display: flex !important;
					flex-wrap: nowrap !important;
					grid-template-columns: none !important;
					justify-content: flex-start !important;
				}
			}
		</style>
		<?php
	},
	100
);
