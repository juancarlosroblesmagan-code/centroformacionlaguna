<?php
/**
 * Correcciones home Elementor: enlaces, textos y estilos de tarjetas/botones.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

$centroformacionlaguna_mu_pack_home = defined( 'CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE' ) && CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE;

/**
 * @return string
 */
function centroformacionlaguna_cursos_archive_url() {
	if ( function_exists( 'eduma_child_wc_courses_category_url' ) ) {
		return eduma_child_wc_courses_category_url();
	}
	return home_url( '/cursos-subvencionados-castilla-la-mancha/' );
}

/**
 * @return string
 */
function centroformacionlaguna_como_funciona_landing_url() {
	if ( function_exists( 'centroformacionlaguna_como_funciona_url' ) ) {
		return centroformacionlaguna_como_funciona_url();
	}
	return home_url( '/como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha/' );
}

/**
 * Sustituye el contenido de los paneles del acordeón «¿Por qué elegirnos?».
 *
 * @param string $html HTML de la home.
 * @param string $cursos URL del catálogo.
 * @param string $como   URL de la landing «Cómo funciona».
 * @return string
 */
if ( ! function_exists( 'centroformacionlaguna_replace_home_why_accordion' ) ) :
function centroformacionlaguna_replace_home_why_accordion( $html, $cursos, $como ) {
	$contacto = esc_url( home_url( '/contacto/' ) );

	$panels = array(
		'920e3b8' => sprintf(
			'Si trabajas en activo en <strong>Castilla-La Mancha</strong>, puedes acceder a <strong>cursos gratuitos subvencionados para trabajadores</strong> (SEPE y Junta), compatibles con tu jornada laboral. Formación <strong>100&nbsp;%% online</strong>, sin coste de matrícula y con certificado al finalizar: digitalización, ofimática, idiomas, PRL y competencias transversales. <a href="%1$s">Consulta el catálogo de cursos</a> o <a href="%2$s">descubre cómo inscribirte paso a paso</a>.',
			$cursos,
			$como
		),
		'95852de' => sprintf(
			'En situación de <strong>desempleo</strong>, la formación programada para el empleo te permite reforzar tu currículum sin pagar matrícula. Ofrecemos cientos de <strong>cursos subvencionados online en Castilla-La Mancha</strong>: orientación laboral, ofimática en la nube, atención al cliente, logística y sectores con demanda actual. Te orientamos en requisitos, plazas y documentación ante el SEPE. <a href="%1$s">Ver todos los cursos gratuitos</a>.',
			$cursos
		),
		'2d48fb3' => sprintf(
			'Tu empresa puede <strong>bonificar la formación de la plantilla</strong> mediante el crédito de formación (antiguo Fundae): formación subvencionada sin coste para el empleado y con retorno en productividad. En Centro Formacion Laguna impartimos acciones en digitalización, prevención de riesgos, idiomas y liderazgo en toda <strong>Castilla-La Mancha</strong>. Gestionamos documentación e impartición online. <a href="%1$s">Solicita información para empresas</a>.',
			$contacto
		),
		'189de56' => sprintf(
			'Cada curso cuenta con <strong>tutores especializados</strong> en su materia: no es solo vídeo sin acompañamiento. Resolvemos dudas, revisamos ejercicios y te guiamos hasta la evaluación final con contenidos actualizados y enfoque práctico para el empleo. Centro de referencia en formación para el empleo en la región. <a href="%1$s">Explora nuestras áreas formativas</a>.',
			$cursos
		),
	);

	foreach ( $panels as $interaction_id => $copy ) {
		$html = preg_replace(
			'/(<p[^>]*data-interaction-id="' . preg_quote( $interaction_id, '/' ) . '"[^>]*>)[\s\S]*?(<\/p>)/',
			'$1' . $copy . '$2',
			$html,
			1
		);
	}

	$html = str_replace(
		'Elige el plan que mejor se adapte a tu perfil y empieza hoy mismo.',
		'Más de 500 cursos subvencionados en Castilla-La Mancha. Elige tu perfil y empieza hoy sin coste de matrícula.',
		$html
	);

	/* Texto genérico duplicado en los cuatro paneles (respaldo). */
	$fallback = sprintf(
		'Formación subvencionada online en Castilla-La Mancha con Centro Formacion Laguna: inscripción flexible y certificado al finalizar. <a href="%1$s">Ver cursos gratuitos</a>.',
		$cursos
	);
	$html = str_replace( 'Inscríbete cuando quieras, formación a tu ritmo.', $fallback, $html );

	return $html;
}
endif;

if ( ! function_exists( 'centroformacionlaguna_fix_home_page_links' ) ) {
	/**
	 * Enlaces hero y demo Eduma/Envato en la home (respaldo si no hay mu-plugin).
	 *
	 * @param string $html HTML.
	 * @param string $cursos Catálogo.
	 * @param string $como Cómo funciona.
	 * @param string $contacto Contacto.
	 * @param string $eventos Eventos.
	 * @param string $home Inicio.
	 * @return string
	 */
	function centroformacionlaguna_fix_home_page_links( $html, $cursos, $como, $contacto, $eventos, $home ) {
	$html = preg_replace(
		'/(<a[^>]*class="[^"]*e-850d728-551d77c[^"]*"[^>]*href=")[^"]*("/iu',
		'$1' . $cursos . '$2',
		$html,
		1
	);
	$html = preg_replace(
		'/(<a[^>]*class="[^"]*e-c2f467e-da956f3[^"]*"[^>]*href=")[^"]*("/iu',
		'$1' . $contacto . '$2',
		$html,
		1
	);
	$html = preg_replace(
		'/(<a[^>]*class="[^"]*tp-button-primary[^"]*"[^>]*href=")[^"]*("[^>]*>\s*Ver cursos gratuitos\s*<\/a>)/iu',
		'$1' . $cursos . '$2',
		$html,
		1
	);
	$html = preg_replace(
		'/(<a[^>]*class="[^"]*tp-button-outline[^"]*"[^>]*href=")[^"]*("[^>]*>\s*Solicitar información\s*<\/a>)/iu',
		'$1' . $contacto . '$2',
		$html,
		1
	);
	$html = str_replace(
		'href="' . $home . '" target="_self" class="tp-button-outline e-415bdea',
		'href="' . $cursos . '" target="_self" class="tp-button-outline e-415bdea',
		$html
	);
	$html = str_replace(
		'href="' . $home . '" target="_self" class="tp-button-outline e-5264a37',
		'href="' . $contacto . '" target="_self" class="tp-button-outline e-5264a37',
		$html
	);
	$html = str_replace( 'https://1.envato.market/Yx2YR', $contacto, $html );
	$html = preg_replace( '#https?://1\.envato\.market/[^"\'<>\s]+#', $contacto, $html );
	$html = str_replace( 'href="' . esc_url( home_url( '/packages/' ) ) . '"', 'href="' . $cursos . '"', $html );
	$html = str_replace( 'View All Packages', 'Ver todos los cursos', $html );
	$html = str_replace( 'href="' . esc_url( home_url( '/courses/' ) ) . '"', 'href="' . $cursos . '"', $html );
	$html = str_replace( 'View All</a>', 'Ver todos los cursos</a>', $html );
	$html = str_replace( 'href="' . esc_url( home_url( '/events/' ) ) . '"', 'href="' . $eventos . '"', $html );
	$html = str_replace(
		'Cursos completamente actualizados.',
		'Aprende a tu ritmo. Cursos online actualizados, sin horarios fijos.',
		$html
	);
	$html = str_replace( 'data-interaction-id="100c151">', 'data-interaction-id="100c151" href="' . $como . '">', $html );
	$html = preg_replace(
		'/<button([^>]*data-interaction-id="100c151"[^>]*)>([\s\S]*?)<\/button>/iu',
		'<a$1>$2</a>',
		$html,
		1
	);

		return $html;
	}
}

/**
 * Buffer de salida en la home (Elementor). Desactivado por defecto: en algunos servidores provoca pantalla blanca.
 * Para activarlo: en wp-config.php añade define( 'CENTROFORMACIONLAGUNA_HOME_OUTPUT_BUFFER', true );
 */
add_action(
	'template_redirect',
	static function () {
		global $centroformacionlaguna_mu_pack_home;
		if ( ! empty( $centroformacionlaguna_mu_pack_home ) ) {
			return;
		}
		if ( ! defined( 'CENTROFORMACIONLAGUNA_HOME_OUTPUT_BUFFER' ) || ! CENTROFORMACIONLAGUNA_HOME_OUTPUT_BUFFER ) {
			return;
		}
		if ( is_admin() || ! is_front_page() || function_exists( 'centroformacionlaguna_site_fixes_css' ) ) {
			return;
		}

		$cursos   = esc_url( centroformacionlaguna_cursos_archive_url() );
		$como     = esc_url( centroformacionlaguna_como_funciona_landing_url() );
		$contacto = esc_url( home_url( '/contacto/' ) );
		$eventos  = esc_url( function_exists( 'centroformacionlaguna_eventos_url' ) ? centroformacionlaguna_eventos_url() : home_url( '/eventos-centroformacionlaguna-castilla-la-mancha/' ) );
		$home     = esc_url( home_url( '/' ) );

		ob_start(
			static function ( $html ) use ( $cursos, $como, $contacto, $eventos, $home ) {
				if ( ! is_string( $html ) || $html === '' ) {
					return $html;
				}
				$html = centroformacionlaguna_fix_home_page_links( $html, $cursos, $como, $contacto, $eventos, $home );
				return centroformacionlaguna_replace_home_why_accordion( $html, $cursos, $como );
			}
		);
	},
	0
);

add_action(
	'wp_footer',
	static function () {
		global $centroformacionlaguna_mu_pack_home;
		if ( ! empty( $centroformacionlaguna_mu_pack_home ) ) {
			return;
		}
		if ( ! is_front_page() || function_exists( 'centroformacionlaguna_site_fixes_css' ) ) {
			return;
		}
		?>
		<style id="centroformacionlaguna-home-fixes">
		/* Tres tarjetas «Formación Adaptada…» — misma altura */
		.elementor-element-263d9da {
			display: flex !important;
			flex-wrap: wrap;
			gap: 24px;
			align-items: stretch !important;
		}
		.elementor-element-263d9da > .elementor-element[class*="elementor-element-"] {
			flex: 1 1 280px;
			display: flex !important;
			min-height: 100%;
		}
		.elementor-element-263d9da .elementor-widget-container,
		.elementor-element-263d9da .elementor-icon-box-wrapper {
			height: 100%;
			width: 100%;
		}
		.elementor-element-263d9da .elementor-icon-box-wrapper {
			display: flex !important;
			align-items: flex-start;
			gap: 16px;
			background: #fff;
			border: 1px solid #eee;
			border-radius: 12px;
			padding: 28px 24px !important;
			box-shadow: 0 4px 20px rgba(0,0,0,.06);
			min-height: 200px;
			box-sizing: border-box;
		}
		.elementor-element-263d9da .elementor-icon-box-description {
			flex: 1;
			min-height: 4.5em;
		}
		body.home .elementor-element:has(a.e-850d728-551d77c) {
			display: flex !important;
			flex-wrap: wrap;
			gap: 16px !important;
			align-items: center !important;
		}
		body.home a.e-850d728-551d77c.tp-button-primary.e-button-base {
			background: #ffb606 !important;
			color: #1a1a1a !important;
			border: 2px solid #ffb606 !important;
			padding: 14px 28px !important;
			border-radius: 8px !important;
			font-weight: 700 !important;
			text-decoration: none !important;
		}
		body.home a.e-c2f467e-da956f3.tp-button-outline.e-button-base {
			background: transparent !important;
			color: #fff !important;
			border: 2px solid rgba(255,255,255,.92) !important;
			padding: 14px 28px !important;
			border-radius: 999px !important;
			font-weight: 600 !important;
			text-decoration: none !important;
		}
		body.home .elementor-element-263d9da .tp-button-outline.e-button-base {
			color: #8B1A1A !important;
			border: 2px solid #8B1A1A !important;
			background: #fff !important;
			padding: 14px 32px !important;
			border-radius: 999px !important;
			font-weight: 600 !important;
			text-decoration: none !important;
			display: inline-block !important;
		}
		</style>
		<?php
	},
	998
);
