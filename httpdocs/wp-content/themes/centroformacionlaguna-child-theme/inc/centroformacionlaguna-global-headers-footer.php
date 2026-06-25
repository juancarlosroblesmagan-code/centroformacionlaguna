<?php
/**
 * Banners en todas las páginas (sin migas) + menú Cursos sin mega-menú.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

if ( defined( 'CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE' ) && CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE ) {
	return;
}

/**
 * CSS global (carga al final para ganar al tema y estilos en línea).
 *
 * @return string
 */
function eduma_child_global_ui_fix_css() {
	$banner = esc_url( content_url( '/uploads/2026/05/centroscentroformacionlaguna-banner.webp' ) );

	return '
/* Menú Cursos: sin flecha, sin panel al clic */
#menu-item-16477 .thim-ekits-menu__icon,
.menu-item-16477 .thim-ekits-menu__icon,
#menu-item-16477 > .arrow,
#menu-item-16477 > .dropdown-toggle,
#menu-item-16477 a i,
#menu-item-16477 a .fa,
#menu-item-16477 a .fa-angle-down {
	display:none!important;visibility:hidden!important;width:0!important;height:0!important;overflow:hidden!important;font-size:0!important;
}
#menu-item-16477 .thim-ekits-menu__content,
.menu-item-16477 .thim-ekits-menu__content,
#menu-item-16477 .sub-menu,
#menu-item-16477 .dropdown-menu,
#menu-item-16477 .thim-ekits-mega-menu-content,
#menu-item-16477 .elementor-13633,
#menu-item-16477 [data-elementor-id="13633"],
#menu-item-16477 ul.thim-ekits-menu__content {
	display:none!important;visibility:hidden!important;opacity:0!important;pointer-events:none!important;
	height:0!important;max-height:0!important;overflow:hidden!important;border:none!important;box-shadow:none!important;
	margin:0!important;padding:0!important;
}
#menu-item-16477:hover .thim-ekits-menu__content,
#menu-item-16477:focus-within .thim-ekits-menu__content,
#menu-item-16477.active .thim-ekits-menu__content,
#menu-item-16477.open .thim-ekits-menu__content {
	display:none!important;
}
#menu-item-16477 .thim-ekits-menu__nav-link::before,
#menu-item-16477 .thim-ekits-menu__nav-link::after,
#menu-item-16477 > a::after {
	display:none!important;content:none!important;
}
#menu-item-16477 .thim-ekits-menu__nav-link.active,
#menu-item-16477.current-menu-item > .thim-ekits-menu__nav-link,
#menu-item-16477 > a.active {
	outline:none!important;box-shadow:none!important;border:none!important;background:transparent!important;
}
#menu-item-16477.thim-ekits-menu__has-dropdown,
#menu-item-16477.thim-ekits-menu__mega-menu {
	position:static!important;
}

/* Páginas internas: sin migas ni barra blanca */
body:not(.home) .top_heading .breadcrumbs-wrapper,
body:not(.home) .top_heading .breadcrumbs,
body:not(.home) .top_heading #breadcrumbs,
body:not(.home) .top_heading .banner-wrapper .breadcrumbs-wrapper {
	display:none!important;visibility:hidden!important;height:0!important;min-height:0!important;
	padding:0!important;margin:0!important;overflow:hidden!important;background:transparent!important;border:none!important;
}
body:not(.home) .top_heading .banner-wrapper {
	background:transparent!important;padding-top:0!important;width:100%!important;text-align:center!important;
}
body:not(.home) .top_heading .banner-wrapper .container,
body:not(.home) .top_heading .top_site_main .container {
	display:flex!important;flex-direction:column!important;align-items:center!important;justify-content:center!important;
	text-align:center!important;width:100%!important;
}
body:not(.home) .top_heading .page-title-wrapper {
	padding-top:12px!important;display:flex!important;align-items:center!important;justify-content:center!important;
	min-height:180px!important;width:100%!important;text-align:center!important;
}
body:not(.home) .top_heading h1.page-title,
body:not(.home) .top_heading .page-title {
	margin:0 auto!important;display:block!important;width:100%!important;max-width:960px!important;
	text-align:center!important;float:none!important;
}
body:not(.home) .top_heading .top_site_main.style_heading_3 {
	justify-content:center!important;text-align:center!important;
}

/* Banner con imagen (vence style="" del tema) */
body:not(.home) .top_heading span.overlay-top-header,
body:not(.home) .top_heading .overlay-top-header,
body:not(.home) .top_site_main.style_heading_3 > .overlay-top-header {
	background-image:linear-gradient(135deg,rgba(139,26,26,.78) 0%,rgba(40,12,12,.65) 100%),url("' . $banner . '")!important;
	background-size:cover!important;background-position:center 35%!important;background-repeat:no-repeat!important;
	opacity:1!important;
}
body:not(.home) .top_heading .top_site_main.style_heading_3 {
	min-height:300px!important;display:flex!important;align-items:center!important;
}
body:not(.home) .top_heading .page-title {
	color:#fff!important;text-shadow:0 2px 20px rgba(0,0,0,.35)!important;font-weight:800!important;
}
body:not(.home) .top_heading .flex-control-nav,
body:not(.home) .top_heading .flex-direction-nav,
body:not(.home) .top_heading .owl-dots,
body:not(.home) .top_heading .swiper-pagination,
body:not(.home) .top_heading .tp-bullets,
body:not(.home) .top_heading rs-bullets {
	display:none!important;
}

/* Blog: sin sidebar demo */
body.blog #sidebar,
body.blog .col-sm-3.sticky-sidebar,
body.blog .widget-area,
body.archive.category #sidebar,
body.archive.category .widget-area,
body.single-post #sidebar,
body.single-post .widget-area {
	display:none!important;
}
body.blog main.site-main.col-sm-9,
body.archive.category main.site-main.col-sm-9,
body.single-post main.site-main.col-sm-9 {
	width:100%!important;max-width:100%!important;flex:0 0 100%!important;
}
body.blog .container.site-content,
body.archive.category .container.site-content {
	max-width:1280px;
}

@media (max-width:640px){
	body:not(.home) .top_heading .top_site_main.style_heading_3{min-height:220px!important;}
}

.centroformacionlaguna-footer-inner p,
.centroformacionlaguna-footer-inner ul li,
.centroformacionlaguna-footer-credits p{line-height:1.75!important;}
.centroformacionlaguna-footer-inner h4{margin-bottom:12px!important;}
.centroformacionlaguna-protected-email,
.centroformacionlaguna-protected-email-text{word-break:break-word;}
';
}

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( is_admin() ) {
			return;
		}
		wp_register_style( 'eduma-child-global-ui', false, array(), EDUMA_CHILD_VERSION );
		wp_enqueue_style( 'eduma-child-global-ui' );
		wp_add_inline_style( 'eduma-child-global-ui', eduma_child_global_ui_fix_css() );
	},
	99999
);
