<?php
/**
 * Plugin Name: Centro Formación Laguna — Pack seguro (CSS + textos home + menú)
 * Description: Usar con tema Eduma padre activo si el child theme da pantalla blanca. Un solo archivo.
 * Version: 2.1.0
 * Author: Centro Formación Laguna
 *
 * Subir SOLO este archivo a wp-content/mu-plugins/.
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE' ) ) {
	define( 'CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE', true );
}

/**
 * @return string
 */
function centroformacionlaguna_mu_cursos_url() {
	if ( function_exists( 'eduma_child_wc_courses_category_url' ) ) {
		return eduma_child_wc_courses_category_url();
	}
	$t = get_term_by( 'slug', 'cursos-subvencionados-castilla-la-mancha', 'product_cat' );
	if ( $t && ! is_wp_error( $t ) ) {
		$l = get_term_link( $t );
		if ( ! is_wp_error( $l ) ) {
			return $l;
		}
	}
	return home_url( '/cursos-subvencionados-castilla-la-mancha/' );
}

/**
 * @return string
 */
function centroformacionlaguna_mu_pack_css() {
	if ( function_exists( 'centroformacionlaguna_mu_ui_css' ) ) {
		return centroformacionlaguna_mu_ui_css() . centroformacionlaguna_mu_pack_footer_css();
	}

	$banner = esc_url( content_url( '/uploads/2026/05/centroformacionlaguna-banner.webp' ) );

	return '
#menu-item-16477 .thim-ekits-menu__icon,.menu-item-16477 .thim-ekits-menu__icon,
#menu-item-16477 > .arrow,#menu-item-16477 > .dropdown-toggle,
#menu-item-16477 a i,#menu-item-16477 a .fa,#menu-item-16477 a .fa-angle-down{
	display:none!important;visibility:hidden!important;width:0!important;height:0!important;overflow:hidden!important;
}
#menu-item-16477 .thim-ekits-menu__content,.menu-item-16477 .thim-ekits-menu__content,
#menu-item-16477 .sub-menu,#menu-item-16477 .dropdown-menu,#menu-item-16477 .thim-ekits-mega-menu-content,
#menu-item-16477 .elementor-13633,#menu-item-16477 [data-elementor-id="13633"],
#menu-item-16477 ul.thim-ekits-menu__content{
	display:none!important;visibility:hidden!important;opacity:0!important;pointer-events:none!important;
	height:0!important;max-height:0!important;overflow:hidden!important;margin:0!important;padding:0!important;
}
#menu-item-16477 .thim-ekits-menu__nav-link::before,#menu-item-16477 .thim-ekits-menu__nav-link::after,
#menu-item-16477 > a::after{display:none!important;content:none!important;}
body:not(.home) .top_heading .breadcrumbs-wrapper,body:not(.home) .top_heading .breadcrumbs,
body:not(.home) .top_heading #breadcrumbs,body:not(.home) .top_heading .banner-wrapper .breadcrumbs-wrapper{
	display:none!important;height:0!important;padding:0!important;margin:0!important;overflow:hidden!important;
}
body:not(.home) .top_heading .banner-wrapper{background:transparent!important;width:100%!important;text-align:center!important;}
body:not(.home) .top_heading .banner-wrapper .container,body:not(.home) .top_heading .top_site_main .container{
	display:flex!important;flex-direction:column!important;align-items:center!important;justify-content:center!important;width:100%!important;
}
body:not(.home) .top_heading .page-title-wrapper{
	padding-top:12px!important;display:flex!important;align-items:center!important;justify-content:center!important;min-height:180px!important;width:100%!important;
}
body:not(.home) .top_heading h1.page-title,body:not(.home) .top_heading .page-title{
	display:block!important;width:100%!important;max-width:960px!important;margin-left:auto!important;margin-right:auto!important;text-align:center!important;
}
body:not(.home) .top_heading span.overlay-top-header,body:not(.home) .top_heading .overlay-top-header,
body:not(.home) .top_site_main.style_heading_3 > span.overlay-top-header{
	background-image:linear-gradient(135deg,rgba(139,26,26,.78) 0%,rgba(40,12,12,.65) 100%),url("' . $banner . '")!important;
	background-size:cover!important;background-position:center 35%!important;background-repeat:no-repeat!important;opacity:1!important;
}
body:not(.home) .top_heading .top_site_main.style_heading_3{
	min-height:300px!important;display:flex!important;align-items:center!important;justify-content:center!important;text-align:center!important;
}
body:not(.home) .top_heading .page-title{color:#fff!important;text-shadow:0 2px 20px rgba(0,0,0,.35)!important;font-weight:800!important;}
body.tax-product_cat.term-cursos-subvencionados-castilla-la-mancha .woocommerce-result-count,
body.tax-product_cat.term-cursos-subvencionados-castilla-la-mancha .woocommerce-ordering,
body.term-cursos-subvencionados-castilla-la-mancha .woocommerce-result-count,
body.term-cursos-subvencionados-castilla-la-mancha .woocommerce-ordering{
	display:none!important;height:0!important;margin:0!important;padding:0!important;
}
body.blog #sidebar,body.blog .widget-area,body.blog .col-sm-3.sticky-sidebar,
body.single-post #sidebar,body.single-post .widget-area,
body.page-id-16729 #sidebar,body.page-id-16729 .widget-area,body.page-id-16729 .sticky-sidebar,
body.page-id-16705 #sidebar,body.page-id-16705 .widget-area,body.page-id-16705 .sticky-sidebar,
body.centroformacionlaguna-page-como-funciona #sidebar,body.centroformacionlaguna-page-como-funciona .widget-area{
	display:none!important;width:0!important;overflow:hidden!important;
}
body.blog main.site-main.col-sm-9,body.single-post main.site-main.col-sm-9,
body.page-id-16729 main.site-main,body.page-id-16729 .col-sm-9,
body.page-id-16705 main.site-main,body.page-id-16705 .col-sm-9,
body.centroformacionlaguna-page-como-funciona main.site-main,body.centroformacionlaguna-page-como-funciona .col-sm-9{
	width:100%!important;max-width:100%!important;flex:0 0 100%!important;
}
body.blog .blog-grid-3 article.post h2.entry-title,body.blog .blog-grid-3 article.post .entry-title{
	display:block!important;visibility:visible!important;color:#8B1A1A!important;min-height:2.5em!important;
}
.elementor-element-263d9da{display:flex!important;flex-wrap:wrap;gap:24px;align-items:stretch!important;}
.elementor-element-263d9da > .elementor-element{flex:1 1 280px;display:flex!important;align-self:stretch!important;}
.elementor-element-263d9da .elementor-widget-container,.elementor-element-263d9da .elementor-icon-box-wrapper{height:100%!important;width:100%!important;}
.elementor-element-263d9da .elementor-icon-box-wrapper{
	display:flex!important;align-items:flex-start;gap:16px;background:#fff;border:1px solid #eee;border-radius:12px;
	padding:28px 24px!important;box-shadow:0 4px 20px rgba(0,0,0,.06);min-height:200px!important;
}
body.home a.e-850d728-551d77c.tp-button-primary.e-button-base{
	background:#ffb606!important;color:#1a1a1a!important;border:2px solid #ffb606!important;padding:14px 28px!important;border-radius:8px!important;font-weight:700!important;
}
body.home a.e-c2f467e-da956f3.tp-button-outline.e-button-base{
	background:transparent!important;color:#fff!important;border:2px solid rgba(255,255,255,.92)!important;padding:14px 28px!important;border-radius:999px!important;
}
body.home .elementor-element-263d9da .tp-button-outline.e-button-base{
	color:#8B1A1A!important;border:2px solid #8B1A1A!important;background:#fff!important;padding:14px 32px!important;border-radius:999px!important;
}
@media (max-width:640px){body:not(.home) .top_heading .top_site_main.style_heading_3{min-height:220px!important;}}
' . centroformacionlaguna_mu_pack_footer_css();
}

/**
 * Pie de página Centro Formación Laguna.
 *
 * @return string
 */
function centroformacionlaguna_mu_pack_footer_css() {
	return '
.centroformacionlaguna-footer-inner p,.centroformacionlaguna-footer-inner ul li,.centroformacionlaguna-footer-credits p{line-height:1.75!important;}
.centroformacionlaguna-footer-inner h4{margin-bottom:12px!important;}
.centroformacionlaguna-protected-email,.centroformacionlaguna-protected-email-text{word-break:break-word;}
';
}

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( is_admin() ) {
			return;
		}
		wp_register_style( 'centroformacionlaguna-mu-pack', false, array(), '2.1.0' );
		wp_enqueue_style( 'centroformacionlaguna-mu-pack' );
		wp_add_inline_style( 'centroformacionlaguna-mu-pack', centroformacionlaguna_mu_pack_css() );
	},
	99999
);

add_action(
	'wp',
	static function () {
		if ( ! function_exists( 'is_tax' ) || ! is_tax( 'product_cat', 'cursos-subvencionados-castilla-la-mancha' ) ) {
			return;
		}
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	},
	20
);

/** Menú: «Cursos Gratis» → «Cursos» en el ítem del catálogo CLM. */
add_filter(
	'wp_nav_menu_objects',
	static function ( $items ) {
		if ( ! is_array( $items ) ) {
			return $items;
		}
		foreach ( $items as $item ) {
			if ( ! isset( $item->url ) ) {
				continue;
			}
			if ( false !== strpos( $item->url, 'cursos-subvencionados-castilla-la-mancha' ) ) {
				$item->title = 'Cursos';
			}
			if ( isset( $item->title ) && 'Cursos Gratis' === $item->title ) {
				$item->title = 'Cursos';
			}
		}
		return $items;
	}
);

/** Textos demo Eduma en inglés (plantillas del tema). */
add_filter(
	'gettext',
	static function ( $translated, $text ) {
		if ( is_admin() ) {
			return $translated;
		}
		$map = array(
			'View All Packages'         => 'Ver todos los cursos',
			'Package Courses'           => 'Programas formativos',
			'Get Free Access'           => 'Obtener acceso gratuito',
			'Full Name*'                => 'Nombre completo*',
			'Email Address*'            => 'Correo electrónico*',
			'Phone Number (optional)'   => 'Teléfono (opcional)',
		);
		return $map[ $text ] ?? $translated;
	},
	20,
	2
);

/*
 * Nota v2.1: ob_start en la home provocaba portada en blanco (0 bytes) con WP Rocket.
 * Los textos del acordeón en home siguen en WPCode / child theme (centroformacionlaguna-home-fixes).
 */
