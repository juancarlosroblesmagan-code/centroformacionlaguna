<?php
/**
 * Cursos como productos WooCommerce (estilo cursospremiumonline.es).
 * Sin LearnPress / LMS.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/** Slug de la categoría principal de cursos CLM. */
const EDUMA_CHILD_WC_CAT_SLUG = 'cursos-subvencionados-castilla-la-mancha';

/**
 * URL del archivo de la categoría de cursos.
 *
 * @return string
 */
function eduma_child_wc_courses_category_url() {
	$term = get_term_by( 'slug', EDUMA_CHILD_WC_CAT_SLUG, 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}
	return home_url( '/cursos-subvencionados-castilla-la-mancha/' );
}

/**
 * Configura WooCommerce para el catálogo de cursos.
 */
function eduma_child_centroformacionlaguna_setup_woocommerce_courses() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$term = get_term_by( 'slug', EDUMA_CHILD_WC_CAT_SLUG, 'product_cat' );
	if ( ! $term ) {
		$created = wp_insert_term(
			'Cursos Castilla la Mancha',
			'product_cat',
			array(
				'slug'        => EDUMA_CHILD_WC_CAT_SLUG,
				'description' => 'Cursos gratuitos subvencionados en Castilla-La Mancha por el SEPE y la Junta de CLM.',
			)
		);
		if ( is_wp_error( $created ) ) {
			return;
		}
		$term_id = (int) $created['term_id'];
	} else {
		$term_id = (int) $term->term_id;
	}

	$cursos_page = get_page_by_path( 'cursos-gratis' );
	if ( $cursos_page instanceof WP_Post ) {
		update_post_meta( $cursos_page->ID, '_eduma_child_wc_catalog_redirect', '1' );
		delete_post_meta( $cursos_page->ID, '_elementor_edit_mode' );
		delete_post_meta( $cursos_page->ID, '_elementor_data' );
		wp_update_post(
			array(
				'ID'           => $cursos_page->ID,
				'post_content' => '<!-- wp:shortcode -->[product_category category="' . EDUMA_CHILD_WC_CAT_SLUG . '" per_page="24" columns="3" orderby="date" order="DESC"]<!-- /wp:shortcode -->',
			)
		);
	}

	$shop_id = (int) get_option( 'woocommerce_shop_page_id', 0 );
	if ( $cursos_page && $shop_id === (int) $cursos_page->ID ) {
		update_option( 'woocommerce_shop_page_id', 0 );
	}

	if ( class_exists( 'LearnPress' ) ) {
		$lp_courses = (int) get_option( 'learn_press_courses_page_id', 0 );
		if ( $cursos_page && $lp_courses === (int) $cursos_page->ID ) {
			update_option( 'learn_press_courses_page_id', 0 );
		}
	}

	update_option( 'eduma_child_wc_cat_term_id', $term_id );
}

add_action( 'eduma_child_centroformacionlaguna_run_setup', 'eduma_child_centroformacionlaguna_setup_woocommerce_courses', 15 );

/**
 * Redirige /cursos-gratis/ al archivo de categoría.
 */
add_action(
	'template_redirect',
	static function () {
		if ( ! is_page( 'cursos-gratis' ) ) {
			return;
		}
		if ( ! get_post_meta( get_queried_object_id(), '_eduma_child_wc_catalog_redirect', true ) ) {
			return;
		}
		$target = eduma_child_wc_courses_category_url();
		if ( trailingslashit( home_url( '/cursos-gratis/' ) ) === trailingslashit( $target ) ) {
			return;
		}
		wp_safe_redirect( $target, 301 );
		exit;
	},
	5
);

/* ------------------------------------------------------------------------- *
 * Cursos gratuitos (0 €): botón "Leer más", sin añadir al carrito.
 * ------------------------------------------------------------------------- */

add_filter(
	'woocommerce_is_purchasable',
	static function ( $purchasable, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return false;
		}
		return $purchasable;
	},
	10,
	2
);

add_filter(
	'woocommerce_product_add_to_cart_text',
	static function ( $text, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return __( 'Solicitar información', 'eduma-child' );
		}
		return $text;
	},
	10,
	2
);

add_filter(
	'woocommerce_product_add_to_cart_url',
	static function ( $url, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return $product->get_permalink();
		}
		return $url;
	},
	10,
	2
);

add_filter(
	'woocommerce_get_price_html',
	static function ( $html, $product ) {
		if ( $product && (float) $product->get_price() <= 0 ) {
			return '';
		}
		return $html;
	},
	10,
	2
);

/**
 * Archivo categoría cursos CLM: sin contador ni selector «Ordenar por».
 */
add_action(
	'wp',
	static function () {
		if ( ! is_tax( 'product_cat', EDUMA_CHILD_WC_CAT_SLUG ) ) {
			return;
		}
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	},
	20
);

if ( ! function_exists( 'centroformacionlaguna_wc_cursos_url' ) ) {
	/**
	 * Retorna la URL del catálogo de cursos WooCommerce.
	 *
	 * @return string
	 */
	function centroformacionlaguna_wc_cursos_url() {
		return eduma_child_wc_courses_category_url();
	}
}

// =========================================================================
// ELIMINADOS POR DUPLICIDAD - AHORA SE GESTIONAN EN FUNCTIONS.PHP
// =========================================================================
// add_action( 'woocommerce_product_options_general_product_data', 'centroformacionlaguna_add_course_meta_fields' );
// add_action( 'woocommerce_process_product_meta', 'centroformacionlaguna_save_course_meta_fields' );
// add_action( 'woocommerce_product_meta_end', 'centroformacionlaguna_display_course_meta_fields' );

function centroformacionlaguna_add_course_meta_fields() {
	echo '<div class="options_group">';

	// Fecha de inicio
	woocommerce_wp_text_input( array(
		'id'          => '_fecha_inicio',
		'label'       => __( 'Fecha de inicio del curso', 'centroformacionlaguna-child' ),
		'placeholder' => 'Ej: 15/09/2026',
		'desc_tip'    => 'true',
		'description' => __( 'Introduce la fecha de inicio del curso.', 'centroformacionlaguna-child' ),
		'type'        => 'text',
	) );

	// Fecha de fin
	woocommerce_wp_text_input( array(
		'id'          => '_fecha_fin',
		'label'       => __( 'Fecha de finalización', 'centroformacionlaguna-child' ),
		'placeholder' => 'Ej: 20/12/2026',
		'desc_tip'    => 'true',
		'description' => __( 'Introduce la fecha de finalización del curso.', 'centroformacionlaguna-child' ),
		'type'        => 'text',
	) );

	// Centro donde se imparte (select con opciones)
	woocommerce_wp_select( array(
		'id'          => '_centro_imparticion',
		'label'       => __( 'Centro donde se imparte', 'centroformacionlaguna-child' ),
		'options'     => array(
			''                      => __( 'Selecciona un centro...', 'centroformacionlaguna-child' ),
			'Santa Cruz de Mudela'  => 'Santa Cruz de Mudela',
			'Viso del Marqués'      => 'Viso del Marqués',
			'Fuente el Fresno'      => 'Fuente el Fresno',
			'Membrilla'             => 'Membrilla',
			'Online / Aula Virtual' => 'Online / Aula Virtual',
			'Varios Centros'        => 'Varios Centros',
		),
		'desc_tip'    => 'true',
		'description' => __( 'Selecciona el centro donde se impartirá el curso.', 'centroformacionlaguna-child' ),
	) );

	echo '</div>';
}

/**
 * Guardar campos de metadatos del curso al guardar el producto.
 */
// add_action( 'woocommerce_process_product_meta', 'centroformacionlaguna_save_course_meta_fields' );
function centroformacionlaguna_save_course_meta_fields( $post_id ) {
	$fields = array( '_fecha_inicio', '_fecha_fin', '_centro_imparticion' );
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
}

/**
 * Mostrar los campos de metadatos en la ficha del producto, debajo de categorías y etiquetas.
 */
// add_action( 'woocommerce_product_meta_end', 'centroformacionlaguna_display_course_meta_fields' );
function centroformacionlaguna_display_course_meta_fields() {
	global $product;
	if ( ! $product ) {
		return;
	}

	$post_id = $product->get_id();
	$fecha_inicio = get_post_meta( $post_id, '_fecha_inicio', true );
	$fecha_fin    = get_post_meta( $post_id, '_fecha_fin', true );
	$centro       = get_post_meta( $post_id, '_centro_imparticion', true );

	if ( ! empty( $fecha_inicio ) || ! empty( $fecha_fin ) || ! empty( $centro ) ) {
		echo '<div class="centroformacionlaguna-course-details-meta" style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #e8ddd0;">';
		
		if ( ! empty( $fecha_inicio ) ) {
			echo '<span class="course-meta-item fecha-inicio" style="display: block; margin-bottom: 6px; font-size: 14px; color: #555;">';
			echo '<span style="color: #8B1A1A; margin-right: 6px;">📅</span><strong style="color: #2c2c2c;">' . esc_html__( 'Fecha de inicio:', 'centroformacionlaguna-child' ) . '</strong> ' . esc_html( $fecha_inicio );
			echo '</span>';
		}
		
		if ( ! empty( $fecha_fin ) ) {
			echo '<span class="course-meta-item fecha-fin" style="display: block; margin-bottom: 6px; font-size: 14px; color: #555;">';
			echo '<span style="color: #8B1A1A; margin-right: 6px;">🏁</span><strong style="color: #2c2c2c;">' . esc_html__( 'Fecha de finalización:', 'centroformacionlaguna-child' ) . '</strong> ' . esc_html( $fecha_fin );
			echo '</span>';
		}
		
		if ( ! empty( $centro ) ) {
			echo '<span class="course-meta-item centro-imparticion" style="display: block; margin-bottom: 6px; font-size: 14px; color: #555;">';
			echo '<span style="color: #8B1A1A; margin-right: 6px;">📍</span><strong style="color: #2c2c2c;">' . esc_html__( 'Centro:', 'centroformacionlaguna-child' ) . '</strong> ' . esc_html( $centro );
			echo '</span>';
		}
		
		echo '</div>';
	}
}

