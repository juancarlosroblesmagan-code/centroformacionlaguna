<?php
/**
 * Header del child: correcciones SEO (pingback, profile https).
 *
 * @package eduma-child
 */
?><!DOCTYPE html>
<html itemscope itemtype="https://schema.org/WebPage" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open() ) : ?>
		<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="thim-body">
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<?php do_action( 'thim_before_body' ); ?>

<div class="mobile-menu-wrapper">
	<div class="mobile-menu-inner">
		<div class="icon-wrapper">
			<div class="icon-menu-back" data-close=""><?php esc_html_e( 'Back', 'eduma' ); ?><span></span></div>
			<button type="button" class="menu-mobile-effect navbar-toggle close-icon" data-effect="mobile-effect" aria-expanded="false" aria-controls="thim-mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'eduma-child' ); ?>">
				<span class="icon-bar" aria-hidden="true"></span>
				<span class="icon-bar" aria-hidden="true"></span>
				<span class="icon-bar" aria-hidden="true"></span>
			</button>
		</div>
		<nav id="thim-mobile-menu" class="mobile-menu-container mobile-effect" aria-label="<?php esc_attr_e( 'Mobile menu', 'eduma-child' ); ?>">
			<?php get_template_part( 'inc/header/menu-mobile' ); ?>
		</nav>
	</div>
</div>

<div id="wrapper-container" class="wrapper-container">
	<div class="content-pusher">
		<header id="masthead" class="site-header affix-top<?php thim_header_class(); ?>">
			<?php
			if ( get_theme_mod( 'thim_toolbar_show', true ) ) {
				get_template_part( 'inc/header/toolbar' );
			}
			get_template_part( 'inc/header/' . get_theme_mod( 'thim_header_style', 'header_v1' ) );
			?>
		</header>

		<div id="main-content">
