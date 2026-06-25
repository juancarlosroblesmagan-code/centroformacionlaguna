<?php
/**
 * Plugin Name: Datos Estructurados SEO Enriquecidos (JSON-LD) - Anti-Gravity
 * Description: Genera esquemas enriquecidos LocalBusiness y Course para maximizar el posicionamiento SEO local y no local.
 * Version: 1.0.0
 * Author: Anti-Gravity Engine
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Seguridad
}

/**
 * 1. ESQUEMA LOCALBUSINESS (Geolocalización y Datos de Contacto)
 * Se inyecta en la Portada y en la página de Contacto.
 */
add_action( 'wp_head', 'antigravity_inyectar_esquema_localbusiness', 20 );

function antigravity_inyectar_esquema_localbusiness() {
    // Solo aplicar en la home (portada) y en páginas que contengan "contacto" en el slug
    if ( ! is_front_page() && ! is_page( 'contacto' ) ) {
        return;
    }

    $logo_url = esc_url( content_url( '/uploads/2026/04/centroformacionlaguna-logo.png' ) );

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'LocalBusiness',
        'name'        => 'Centro de Formación Laguna',
        'image'       => $logo_url,
        'telephone'   => '+34 926 33 11 62',
        'email'       => 'info@centroformacionlaguna.net',
        'url'         => home_url( '/' ),
        'priceRange'  => '$$',
        'address'     => array(
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Santa Cruz de Mudela',
            'addressRegion'   => 'Ciudad Real',
            'addressCountry'  => 'ES',
            'postalCode'      => '13730'
        ),
        'geo' => array(
            '@type'     => 'GeoCoordinates',
            'latitude'  => '38.6441',  // Santa Cruz de Mudela latitud aprox
            'longitude' => '-3.4678'   // Santa Cruz de Mudela longitud aprox
        ),
        'sameAs' => array(
            'https://www.facebook.com/centroformacionlaguna'
        ),
        'description' => 'Centro de Formación Laguna - Especialistas en Formación Profesional y Cursos Subvencionados para el Empleo.'
    );

    echo "\n<!-- Esquema LocalBusiness de Centro de Formación Laguna (Anti-Gravity) -->\n";
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * 2. ESQUEMA COURSE (Fichas de Cursos de LearnPress)
 * Se inyecta dinámicamente en cada ficha de curso.
 */
add_action( 'wp_head', 'antigravity_inyectar_esquema_curso', 20 );

function antigravity_inyectar_esquema_curso() {
    // Soporta tanto CPT de LearnPress 'lp_course' como productos de WooCommerce 'product'
    if ( ! is_singular( array( 'lp_course', 'product' ) ) ) {
        return;
    }

    global $post;
    if ( ! is_object( $post ) ) {
        return;
    }

    // Si es un producto, verificar que pertenezca a la categoría de cursos subvencionados
    if ( $post->post_type === 'product' ) {
        if ( ! has_term( 'cursos-subvencionados-castilla-la-mancha', 'product_cat', $post->ID ) ) {
            // Si no tiene la categoría, comprobar si tiene metadatos de curso para mayor seguridad
            $fecha_inicio = get_post_meta( $post->ID, '_fecha_inicio', true );
            if ( empty( $fecha_inicio ) ) {
                return;
            }
        }
    }

    $title       = get_the_title( $post->ID );
    $description = get_the_excerpt( $post->ID ) ?: wp_strip_all_tags( $post->post_content );
    $description = wp_html_excerpt( $description, 250, '...' );
    $url         = get_permalink( $post->ID );
    $image       = get_the_post_thumbnail_url( $post->ID, 'full' ) ?: '';

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Course',
        'name'        => $title,
        'description' => $description,
        'url'         => $url,
        'provider'    => array(
            '@type'  => 'Organization',
            'name'   => 'Centro de Formación Laguna',
            'sameAs' => home_url( '/' )
        )
    );

    if ( $image ) {
        $schema['image'] = $image;
    }

    // Ofertas de precio
    if ( $post->post_type === 'product' ) {
        $schema['offers'] = array(
            '@type'         => 'Offer',
            'category'      => 'Subscription',
            'price'         => '0.00',
            'priceCurrency' => 'EUR',
            'offeredBy'     => array(
                '@type' => 'Organization',
                'name'  => 'Centro de Formación Laguna'
            )
        );

        // Detalles de la instancia del curso (Fechas y Centro de impartición)
        $fecha_inicio = get_post_meta( $post->ID, '_fecha_inicio', true );
        $fecha_fin    = get_post_meta( $post->ID, '_fecha_fin', true );
        $centro       = get_post_meta( $post->ID, '_centro_imparticion', true );

        if ( ! empty( $fecha_inicio ) || ! empty( $centro ) ) {
            $instance = array(
                '@type'      => 'CourseInstance',
                'courseMode' => 'Presencial', // Por defecto todos los cursos CLM son presenciales
            );

            if ( ! empty( $fecha_inicio ) ) {
                // Convertir dd/mm/yyyy a YYYY-MM-DD para Schema.org
                $parts = explode( '/', $fecha_inicio );
                if ( count( $parts ) === 3 ) {
                    $instance['startDate'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                } else {
                    $instance['startDate'] = $fecha_inicio;
                }
            }

            if ( ! empty( $fecha_fin ) ) {
                $parts = explode( '/', $fecha_fin );
                if ( count( $parts ) === 3 ) {
                    $instance['endDate'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                } else {
                    $instance['endDate'] = $fecha_fin;
                }
            }

            if ( ! empty( $centro ) ) {
                $instance['location'] = array(
                    '@type' => 'Place',
                    'name'  => 'Centro de Impartición - ' . $centro,
                    'address' => array(
                        '@type'           => 'PostalAddress',
                        'addressLocality' => $centro,
                        'addressRegion'   => 'Ciudad Real',
                        'addressCountry'  => 'ES'
                    )
                );
            }

            $schema['hasCourseInstance'] = $instance;
        }
    } elseif ( function_exists( 'learn_press_get_course' ) ) {
        // Fallback de LearnPress si existiera algún curso previo
        try {
            $course = learn_press_get_course( $post->ID );
            if ( $course ) {
                $is_free = $course->is_free();
                $price   = $is_free ? '0.00' : $course->get_price();
                
                $schema['offers'] = array(
                    '@type'         => 'Offer',
                    'category'      => 'Subscription',
                    'price'         => $price,
                    'priceCurrency' => 'EUR',
                    'offeredBy'     => array(
                        '@type' => 'Organization',
                        'name'  => 'Centro de Formación Laguna'
                    )
                );
            }
        } catch ( Exception $e ) {
            // Silenciar excepciones
        }
    }

    echo "\n<!-- Esquema de Curso (Anti-Gravity) -->\n";
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
