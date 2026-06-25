<?php
/**
 * Plugin Name: Centro Formación Laguna — Fix listado usuarios Plesk / WP-CLI
 * Description: WordPress trac #62003 — caché incorrecta en WP_User_Query.
 * Version: 1.2.0
 * Author: Centro Formación Laguna
 *
 * Subir a: wp-content/mu-plugins/centroformacionlaguna-plesk-user-query-fix.php
 */

defined( 'ABSPATH' ) || exit;

/**
 * @param WP_User_Query $query Query instance.
 */
function centroformacionlaguna_plesk_disable_user_query_cache( $query ) {
	if ( ! is_object( $query ) || ! isset( $query->query_vars ) ) {
		return;
	}

	$fields = isset( $query->query_vars['fields'] ) ? $query->query_vars['fields'] : null;

	if ( is_array( $fields ) && 1 === count( $fields ) ) {
		$query->query_vars['cache_results'] = false;
		return;
	}

	if ( is_string( $fields ) && '' !== $fields && 'all' !== $fields ) {
		$query->query_vars['cache_results'] = false;
	}
}

/**
 * Siempre desactivar caché en consultas de usuarios (Plesk + WP-CLI + trac #62003).
 */
add_filter(
	'users_pre_query',
	static function ( $null, $query ) {
		centroformacionlaguna_plesk_disable_user_query_cache( $query );
		return $null;
	},
	1,
	2
);

add_action(
	'cli_init',
	static function () {
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}
	},
	0
);
