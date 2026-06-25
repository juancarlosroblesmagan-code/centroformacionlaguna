<?php
/**
 * Importa los 2 cursos CLM desde cursospremiumonline.es (servidor → servidor).
 * Si el remoto falla, usa el HTML local de inc/centroformacionlaguna-course-content.php.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/** Versión del contenido. Aumentar para forzar reimportación automática. */
const EDUMA_CHILD_COURSES_IMPORT_VERSION = 4;

/**
 * Reimporta automáticamente cuando un admin entra al wp-admin
 * tras subir una versión nueva del child theme. Además desactiva LearnPress
 * para garantizar que el sitio se queda solo con WooCommerce.
 */
add_action(
	'admin_init',
	static function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		$done = (int) get_option( 'eduma_child_courses_import_version', 0 );
		if ( $done >= EDUMA_CHILD_COURSES_IMPORT_VERSION ) {
			return;
		}

		eduma_child_sync_courses_from_premium();
		eduma_child_deactivate_learnpress_plugins();

		update_option( 'eduma_child_courses_import_version', EDUMA_CHILD_COURSES_IMPORT_VERSION );
	},
	20
);

/**
 * Aviso en el admin si LearnPress sigue activo después del intento de desactivado.
 */
add_action(
	'admin_notices',
	static function () {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( ! is_plugin_active( 'learnpress/learnpress.php' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p><strong>Centro Formacion Laguna:</strong> ';
		echo esc_html__( 'LearnPress sigue activo. Este sitio usa WooCommerce para los cursos; deberías desactivar LearnPress en Plugins.', 'eduma-child' );
		echo '</p></div>';
	}
);

/**
 * Ejecutar: /wp-admin/?eduma_child_sync_courses=1&_wpnonce=...
 */
function eduma_child_maybe_sync_courses_from_premium() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( empty( $_GET['eduma_child_sync_courses'] ) ) {
		return;
	}
	check_admin_referer( 'eduma_child_sync_courses' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		wp_die( esc_html__( 'WooCommerce no está activo.', 'eduma-child' ) );
	}

	$results = eduma_child_sync_courses_from_premium();
	eduma_child_deactivate_learnpress_plugins();

	wp_die(
		'<pre>' . esc_html( wp_json_encode( $results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) ) . '</pre>',
		esc_html__( 'Importación de cursos', 'eduma-child' ),
		array( 'response' => 200 )
	);
}
add_action( 'admin_init', 'eduma_child_maybe_sync_courses_from_premium' );

/**
 * @return array<string, mixed>
 */
function eduma_child_sync_courses_from_premium() {
	$cat_slug = defined( 'EDUMA_CHILD_WC_CAT_SLUG' ) ? EDUMA_CHILD_WC_CAT_SLUG : 'cursos-subvencionados-castilla-la-mancha';
	$term     = get_term_by( 'slug', $cat_slug, 'product_cat' );
	if ( ! $term ) {
		$created = wp_insert_term(
			'Cursos Castilla la Mancha',
			'product_cat',
			array(
				'slug'        => $cat_slug,
				'description' => 'Cursos gratuitos subvencionados en Castilla-La Mancha.',
			)
		);
		$cat_id = is_wp_error( $created ) ? 0 : (int) $created['term_id'];
	} else {
		$cat_id = (int) $term->term_id;
		wp_update_term(
			$cat_id,
			'product_cat',
			array(
				'name'        => 'Cursos Castilla la Mancha',
				'description' => 'Cursos gratuitos subvencionados en Castilla-La Mancha.',
			)
		);
	}

	$slugs   = array(
		'curso-de-gestion-de-negocios-online-2-0-clm',
		'curso-ofimatica-en-la-nube-con-google-drive',
	);
	$out     = array( 'category_id' => $cat_id, 'products' => array() );
	$legacy  = 'curso-ofimatica-en-la-nube-con-google-drive-clm';

	foreach ( $slugs as $slug ) {
		$result = eduma_child_import_product_from_premium( $slug, $cat_id );
		if ( ! empty( $result['error'] ) ) {
			$result = eduma_child_import_product_from_local( $slug, $cat_id );
			$result['source'] = 'local';
		} else {
			$result['source'] = 'remote';
		}
		$out['products'][ $slug ] = $result;
	}

	$legacy_post = get_page_by_path( $legacy, OBJECT, 'product' );
	$new_post    = get_page_by_path( 'curso-ofimatica-en-la-nube-con-google-drive', OBJECT, 'product' );
	if ( $legacy_post && $new_post && (int) $legacy_post->ID !== (int) $new_post->ID ) {
		wp_trash_post( $legacy_post->ID );
		$out['legacy_ofimatica_trashed'] = $legacy_post->ID;
	}

	if ( function_exists( 'centroformacionlaguna_apply_course_featured_images' ) ) {
		$out['course_images'] = centroformacionlaguna_apply_course_featured_images();
	} else {
		$out['course_images'] = eduma_child_apply_course_featured_images();
	}

	return $out;
}

/**
 * Asigna fotos centroscentroformacionlaguna a los productos CLM (child theme, sin mu-plugin).
 *
 * @return array<string, mixed>
 */
function eduma_child_apply_course_featured_images() {
	$map = array(
		'curso-de-gestion-de-negocios-online-2-0-clm'     => 'centroscentroformacionlaguna-5',
		'curso-ofimatica-en-la-nube-con-google-drive'     => 'centroscentroformacionlaguna-6',
		'curso-ofimatica-en-la-nube-con-google-drive-clm' => 'centroscentroformacionlaguna-6',
	);
	$results = array();
	foreach ( $map as $product_slug => $media_slug ) {
		$product = get_page_by_path( $product_slug, OBJECT, 'product' );
		$att_id  = eduma_child_get_attachment_id_by_slug( $media_slug );
		if ( ! $product || ! $att_id ) {
			$results[ $product_slug ] = array( 'ok' => false );
			continue;
		}
		set_post_thumbnail( $product->ID, $att_id );
		$results[ $product_slug ] = array( 'ok' => true, 'featured' => $att_id );
	}
	return $results;
}

/**
 * @param string $slug Attachment post_name.
 * @return int
 */
function eduma_child_get_attachment_id_by_slug( $slug ) {
	$posts = get_posts(
		array(
			'post_type'      => 'attachment',
			'name'           => $slug,
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'fields'         => 'ids',
		)
	);
	return ! empty( $posts[0] ) ? (int) $posts[0] : 0;
}

/**
 * Crea o actualiza un producto usando el HTML local (fallback).
 *
 * @param string $slug
 * @param int    $cat_id
 * @return array<string, mixed>
 */
function eduma_child_import_product_from_local( $slug, $cat_id ) {
	$local = array(
		'curso-de-gestion-de-negocios-online-2-0-clm'   => array(
			'title'   => 'CURSO DE GESTIÓN DE NEGOCIOS ONLINE 2.0 CLM',
			'excerpt' => 'Curso gratuito subvencionado por la Comunidad de Castilla La Mancha y por el SEPE. Mejora tus competencias digitales para avanzar en tu futuro profesional.',
			'content' => function_exists( 'eduma_child_course_gestion_content' ) ? eduma_child_course_gestion_content() : '',
			'image'   => content_url( '/uploads/2026/05/centroscentroformacionlaguna-5.webp' ),
			'tags'    => array( 'Gratis', 'Online', 'Subvencionado' ),
		),
		'curso-ofimatica-en-la-nube-con-google-drive'   => array(
			'title'   => 'CURSO DE OFIMÁTICA EN LA NUBE CON GOOGLE DRIVE PARA CLM',
			'excerpt' => 'Crear y gestionar de forma eficaz, todos los tipos de documentos necesarios en la gestión ofimática en la nube de Google.',
			'content' => function_exists( 'eduma_child_course_ofimatica_content' ) ? eduma_child_course_ofimatica_content() : '',
			'image'   => content_url( '/uploads/2026/05/centroscentroformacionlaguna-6.webp' ),
			'tags'    => array( 'cursos gratis', 'formación subvencionada', 'SEPE' ),
		),
	);
	if ( empty( $local[ $slug ] ) ) {
		return array( 'error' => 'local_not_defined' );
	}

	$data     = $local[ $slug ];
	$existing = get_page_by_path( $slug, OBJECT, 'product' );
	$postarr  = array(
		'post_title'   => $data['title'],
		'post_name'    => $slug,
		'post_excerpt' => $data['excerpt'],
		'post_content' => $data['content'],
		'post_status'  => 'publish',
		'post_type'    => 'product',
	);
	if ( $existing ) {
		$postarr['ID'] = $existing->ID;
		$product_id    = wp_update_post( $postarr, true );
	} else {
		$product_id = wp_insert_post( $postarr, true );
	}
	if ( is_wp_error( $product_id ) || ! $product_id ) {
		return array( 'error' => is_wp_error( $product_id ) ? $product_id->get_error_message() : 'insert_failed' );
	}

	wp_set_object_terms( $product_id, array( $cat_id ), 'product_cat' );
	if ( ! empty( $data['tags'] ) ) {
		wp_set_object_terms( $product_id, array_map( 'sanitize_text_field', $data['tags'] ), 'product_tag' );
	}
	update_post_meta( $product_id, '_regular_price', '0' );
	update_post_meta( $product_id, '_price', '0' );
	update_post_meta( $product_id, '_virtual', 'yes' );
	wp_set_object_terms( $product_id, 'simple', 'product_type' );

	$feat_id = 0;
	$media_map = array(
		'curso-de-gestion-de-negocios-online-2-0-clm' => 'centroscentroformacionlaguna-5',
		'curso-ofimatica-en-la-nube-con-google-drive' => 'centroscentroformacionlaguna-6',
	);
	if ( ! empty( $media_map[ $slug ] ) ) {
		$feat_id = eduma_child_get_attachment_id_by_slug( $media_map[ $slug ] );
	}
	if ( ! $feat_id && ! empty( $data['image'] ) ) {
		$feat_id = eduma_child_sideload_image( $data['image'] );
	}
	if ( $feat_id ) {
		set_post_thumbnail( $product_id, $feat_id );
	}

	return array(
		'id'       => (int) $product_id,
		'featured' => (int) $feat_id,
	);
}

/**
 * @param string $slug Source product slug.
 * @param int    $cat_id Category term id.
 * @return array<string, mixed>
 */
function eduma_child_import_product_from_premium( $slug, $cat_id ) {
	$url  = 'https://cursospremiumonline.es/wp-json/wp/v2/product?slug=' . rawurlencode( $slug ) . '&_embed=wp:featuredmedia,wp:term';
	$resp = wp_remote_get(
		$url,
		array(
			'timeout' => 60,
		)
	);
	if ( is_wp_error( $resp ) ) {
		return array( 'error' => $resp->get_error_message() );
	}
	$code = (int) wp_remote_retrieve_response_code( $resp );
	$body = json_decode( wp_remote_retrieve_body( $resp ), true );
	if ( 200 !== $code || empty( $body[0] ) ) {
		return array( 'error' => 'source_not_found', 'code' => $code );
	}

	$src = $body[0];
	$tag_ids = array();
	if ( ! empty( $src['_embedded']['wp:term'] ) ) {
		foreach ( $src['_embedded']['wp:term'] as $group ) {
			foreach ( $group as $t ) {
				if ( empty( $t['taxonomy'] ) || 'product_tag' !== $t['taxonomy'] ) {
					continue;
				}
				$tag = term_exists( $t['slug'], 'product_tag' );
				if ( ! $tag ) {
					$tag = wp_insert_term( $t['name'], 'product_tag', array( 'slug' => $t['slug'] ) );
				}
				if ( ! is_wp_error( $tag ) ) {
					$tag_ids[] = (int) ( is_array( $tag ) ? $tag['term_id'] : $tag );
				}
			}
		}
	}

	$feat_id = 0;
	if ( ! empty( $src['_embedded']['wp:featuredmedia'][0]['source_url'] ) ) {
		$feat_id = eduma_child_sideload_image( $src['_embedded']['wp:featuredmedia'][0]['source_url'] );
	}

	$title   = wp_strip_all_tags( $src['title']['rendered'] ?? '' );
	$excerpt = wp_strip_all_tags( $src['excerpt']['rendered'] ?? '' );
	$content = $src['content']['rendered'] ?? '';

	$existing = get_page_by_path( $slug, OBJECT, 'product' );
	$postarr  = array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_excerpt' => $excerpt,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'product',
	);

	if ( $existing ) {
		$postarr['ID'] = $existing->ID;
		$product_id    = wp_update_post( $postarr, true );
	} else {
		$product_id = wp_insert_post( $postarr, true );
	}

	if ( is_wp_error( $product_id ) ) {
		return array( 'error' => $product_id->get_error_message() );
	}

	wp_set_object_terms( $product_id, array( $cat_id ), 'product_cat' );
	if ( $tag_ids ) {
		wp_set_object_terms( $product_id, $tag_ids, 'product_tag' );
	}
	if ( $feat_id ) {
		set_post_thumbnail( $product_id, $feat_id );
	}

	update_post_meta( $product_id, '_regular_price', '0' );
	update_post_meta( $product_id, '_price', '0' );
	update_post_meta( $product_id, '_virtual', 'yes' );
	wp_set_object_terms( $product_id, 'simple', 'product_type' );

	return array(
		'id'           => $product_id,
		'featured'     => $feat_id,
		'tags'         => $tag_ids,
		'image'        => $src['_embedded']['wp:featuredmedia'][0]['source_url'] ?? '',
	);
}

/**
 * @param string $image_url Remote image URL.
 * @return int Attachment ID or 0.
 */
function eduma_child_sideload_image( $image_url ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = download_url( $image_url );
	if ( is_wp_error( $tmp ) ) {
		return 0;
	}

	$file = array(
		'name'     => basename( wp_parse_url( $image_url, PHP_URL_PATH ) ),
		'tmp_name' => $tmp,
	);
	$id = media_handle_sideload( $file, 0 );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp );
		return 0;
	}
	return (int) $id;
}

/**
 * Desactiva plugins LearnPress.
 */
function eduma_child_deactivate_learnpress_plugins() {
	if ( ! function_exists( 'deactivate_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$active = (array) get_option( 'active_plugins', array() );
	$removed = array();
	foreach ( $active as $plugin ) {
		if ( stripos( $plugin, 'learnpress' ) !== false || stripos( $plugin, 'learn-press' ) !== false ) {
			deactivate_plugins( $plugin, true );
			$removed[] = $plugin;
		}
	}
	return $removed;
}

/**
 * @return string
 */
function eduma_child_sync_courses_admin_url() {
	return wp_nonce_url(
		admin_url( '?eduma_child_sync_courses=1' ),
		'eduma_child_sync_courses'
	);
}
