<?php
/**
 * Plugin Name: Disable SSL Verification for Local Development
 * Description: Disables SSL verification for WordPress HTTP requests to prevent download failures in local Docker environments.
 */

add_filter( 'https_local_ssl_verify', '__return_false' );
add_filter( 'https_ssl_verify', '__return_false' );
add_filter( 'http_request_args', function( $parsed_args, $url ) {
    $parsed_args['sslverify'] = false;
    return $parsed_args;
}, 10, 2 );
