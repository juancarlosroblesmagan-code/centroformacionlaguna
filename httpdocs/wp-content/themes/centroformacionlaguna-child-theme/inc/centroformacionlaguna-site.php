<?php
/**
 * Configuración automática del sitio Centro Formacion Laguna (páginas, menú, LearnPress).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/inc/centroformacionlaguna-content.php';

const EDUMA_CHILD_CENTROFORMACIONLAGUNA_SETUP_OPTION = 'eduma_child_centroformacionlaguna_setup_v1';

add_action( 'after_switch_theme', 'eduma_child_centroformacionlaguna_run_setup' );

add_action(
	'admin_menu',
	static function () {
		add_theme_page(
			__( 'Centro Formacion Laguna Setup', 'eduma-child' ),
			__( 'Centro Formacion Laguna Setup', 'eduma-child' ),
			'manage_options',
			'eduma-child-centroformacionlaguna-setup',
			'eduma_child_centroformacionlaguna_admin_page'
		);
	}
);

/**
 * Pantalla de administración para relanzar el asistente.
 */
function eduma_child_centroformacionlaguna_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['eduma_child_centroformacionlaguna_setup'] ) && check_admin_referer( 'eduma_child_centroformacionlaguna_setup' ) ) {
		delete_option( EDUMA_CHILD_CENTROFORMACIONLAGUNA_SETUP_OPTION );
		$result = eduma_child_centroformacionlaguna_run_setup( true );
		echo '<div class="notice notice-success"><p>' . esc_html( $result['message'] ) . '</p></div>';
	}

	$done = (bool) get_option( EDUMA_CHILD_CENTROFORMACIONLAGUNA_SETUP_OPTION );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Centro Formacion Laguna — Configuración del sitio', 'eduma-child' ); ?></h1>
		<p><?php esc_html_e( 'Crea páginas institucionales, asigna el menú principal y corrige la página de cursos LearnPress.', 'eduma-child' ); ?></p>
		<p><strong><?php esc_html_e( 'Estado:', 'eduma-child' ); ?></strong>
			<?php echo $done ? esc_html__( 'Completado', 'eduma-child' ) : esc_html__( 'Pendiente', 'eduma-child' ); ?>
		</p>
		<form method="post">
			<?php wp_nonce_field( 'eduma_child_centroformacionlaguna_setup' ); ?>
			<p>
				<button type="submit" name="eduma_child_centroformacionlaguna_setup" class="button button-primary">
					<?php esc_html_e( 'Ejecutar / repetir configuración', 'eduma-child' ); ?>
				</button>
			</p>
		</form>
		<p><?php esc_html_e( 'La home y secciones Elementor deben editarse en Apariencia → Personalizar o con Elementor. Este asistente no sustituye ese contenido.', 'eduma-child' ); ?></p>
	</div>
	<?php
}

/**
 * Ejecuta la configuración una vez (o forzada desde admin).
 *
 * @param bool $force Forzar ejecución.
 * @return array{message:string, pages:array<string, int>}
 */
function eduma_child_centroformacionlaguna_run_setup( $force = false ) {
	if ( ! $force && get_option( EDUMA_CHILD_CENTROFORMACIONLAGUNA_SETUP_OPTION ) ) {
		return array(
			'message' => __( 'La configuración ya se ejecutó anteriormente.', 'eduma-child' ),
			'pages'   => array(),
		);
	}

	$page_ids = eduma_child_centroformacionlaguna_create_pages();
	eduma_child_centroformacionlaguna_fix_courses_page();
	eduma_child_centroformacionlaguna_create_primary_menu( $page_ids );

	/**
	 * WooCommerce: categoría de cursos, redirección y productos demo.
	 */
	do_action( 'eduma_child_centroformacionlaguna_run_setup' );

	update_option( EDUMA_CHILD_CENTROFORMACIONLAGUNA_SETUP_OPTION, time() );

	return array(
		'message' => __( 'Configuración Centro Formacion Laguna completada. Revisa menús y la página de inicio en Elementor.', 'eduma-child' ),
		'pages'   => $page_ids,
	);
}

/**
 * @return array<string, int> slug => post_id
 */
function eduma_child_centroformacionlaguna_create_pages() {
	$definitions = eduma_child_centroformacionlaguna_page_definitions();
	$created     = array();

	foreach ( $definitions as $key => $page ) {
		$existing = get_page_by_path( $page['slug'] );
		if ( $existing instanceof WP_Post ) {
			wp_update_post(
				array(
					'ID'           => $existing->ID,
					'post_title'   => $page['title'],
					'post_content' => $page['content'],
					'post_status'  => 'publish',
				)
			);
			$created[ $key ] = (int) $existing->ID;
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $page['title'],
				'post_name'    => $page['slug'],
				'post_content' => $page['content'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
			),
			true
		);

		if ( ! is_wp_error( $post_id ) ) {
			$created[ $key ] = (int) $post_id;
		}
	}

	return $created;
}

/**
 * Página Cursos Gratis (la configuración WooCommerce está en centroformacionlaguna-woocommerce-courses.php).
 */
function eduma_child_centroformacionlaguna_fix_courses_page() {
	$courses = get_page_by_path( 'cursos-gratis' );

	if ( ! $courses instanceof WP_Post ) {
		wp_insert_post(
			array(
				'post_title'   => 'Cursos Gratis',
				'post_name'    => 'cursos-gratis',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
	}
}

/**
 * @param array<string, int> $page_ids
 */
function eduma_child_centroformacionlaguna_create_primary_menu( $page_ids ) {
	$menu_name = 'Centro Formacion Laguna Principal';
	$menu      = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = (int) $menu->term_id;
	}

	if ( is_wp_error( $menu_id ) || ! $menu_id ) {
		return;
	}

	$items = array(
		array(
			'title' => __( 'Inicio', 'eduma-child' ),
			'url'   => home_url( '/' ),
		),
		array(
			'title' => __( 'Cursos Gratis', 'eduma-child' ),
			'url'   => function_exists( 'eduma_child_wc_courses_category_url' )
				? eduma_child_wc_courses_category_url()
				: home_url( '/cursos-gratis/' ),
		),
	);

	if ( ! empty( $page_ids['conocenos'] ) ) {
		$items[] = array(
			'title' => __( 'Conócenos', 'eduma-child' ),
			'url'   => get_permalink( $page_ids['conocenos'] ),
		);
	}

	$blog_id = (int) get_option( 'page_for_posts' );
	if ( $blog_id ) {
		$items[] = array(
			'title' => __( 'Blog', 'eduma-child' ),
			'url'   => get_permalink( $blog_id ),
		);
	} else {
		$items[] = array(
			'title' => __( 'Blog', 'eduma-child' ),
			'url'   => home_url( '/blog/' ),
		);
	}

	if ( ! empty( $page_ids['contacto'] ) ) {
		$items[] = array(
			'title' => __( 'Contacto', 'eduma-child' ),
			'url'   => get_permalink( $page_ids['contacto'] ),
		);
	}

	// Evitar duplicar ítems si se relanza el setup.
	$existing_items = wp_get_nav_menu_items( $menu_id );
	if ( empty( $existing_items ) ) {
		foreach ( $items as $item ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'  => $item['title'],
					'menu-item-url'    => $item['url'],
					'menu-item-status' => 'publish',
				)
			);
		}
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
