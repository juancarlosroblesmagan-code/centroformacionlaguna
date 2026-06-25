<?php
/**
 * Landing «Eventos Centro Formacion Laguna» — agenda con personalidad (SEO CLM).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

const CENTROFORMACIONLAGUNA_EVENTOS_SLUG   = 'eventos-centroformacionlaguna-castilla-la-mancha';
const CENTROFORMACIONLAGUNA_EVENTOS_OPTION = 'centroformacionlaguna_eventos_page_id';

/**
 * @return string
 */
function centroformacionlaguna_eventos_url() {
	return home_url( '/' . CENTROFORMACIONLAGUNA_EVENTOS_SLUG . '/' );
}

/**
 * @return array<int, array<string, mixed>>
 */
function centroformacionlaguna_eventos_schedule() {
	$year = (int) gmdate( 'Y' );

	return array(
		array(
			'id'          => 'puertas-abiertas-online',
			'title'       => 'Puertas abiertas online: «¿Esto es gratis de verdad?»',
			'date'        => $year . '-06-12T17:00:00+02:00',
			'date_label'  => '12 junio · 17:00 h',
			'location'    => 'Videollamada (desde el sofá, válido)',
			'mode'        => 'online',
			'tag'         => 'Gratuito',
			'emoji'       => '🚪',
			'excerpt'     => 'Te enseñamos el campus, los cursos estrella y cómo inscribirte sin mandar el DNI a un grupo de WhatsApp dudoso.',
			'description' => 'Sesión en directo para trabajadores y desempleados de Castilla-La Mancha. Resolvemos dudas de requisitos SEPE, plazos y certificados. Duración aproximada: 45 minutos más el tiempo que tardemos en decir «tranquilo, es subvencionado».',
		),
		array(
			'id'          => 'webinar-inscripcion-sepe',
			'title'       => 'Webinar: Inscripción SEPE sin drama',
			'date'        => $year . '-06-26T18:30:00+02:00',
			'date_label'  => '26 junio · 18:30 h',
			'location'    => 'Online en directo',
			'mode'        => 'online',
			'tag'         => 'Plazas limitadas',
			'emoji'       => '📋',
			'excerpt'     => 'Documentación, plazos y errores típicos (sí, hay lista). Sales sabiendo qué hacer y qué no mandar por correo.',
			'description' => 'Guía práctica para acceder a cursos subvencionados en CLM. Incluye demo de navegación por el catálogo y tiempo de preguntas. Recomendado si alguna vez has dicho «lo miro mañana» tres meses seguidos.',
		),
		array(
			'id'          => 'taller-excel-express',
			'title'       => 'Taller exprés: Excel para humanos',
			'date'        => $year . '-07-10T11:00:00+02:00',
			'date_label'  => '10 julio · 11:00 h',
			'location'    => 'Online · 90 minutos',
			'mode'        => 'online',
			'tag'         => 'Demostración',
			'emoji'       => '📊',
			'excerpt'     => 'Muestra en vivo de lo que aprenderás en nuestros cursos de ofimática. Spoiler: las tablas dinámicas no muerden (mucho).',
			'description' => 'Demostración orientada a empleo: fórmulas útiles, tablas y trucos para el día a día. Ideal si tu relación con Excel es «solo abro el correo».',
		),
		array(
			'id'          => 'empresas-fundae',
			'title'       => 'Desayuno digital para empresas (café incluido en metáfora)',
			'date'        => $year . '-07-24T09:30:00+02:00',
			'date_label'  => '24 julio · 9:30 h',
			'location'    => 'Online · RRHH y autónomos',
			'mode'        => 'online',
			'tag'         => 'Empresas',
			'emoji'       => '☕',
			'excerpt'     => 'Bonificación, crédito de formación y cómo no dejar caducar euros que ya pagaste en cotizaciones.',
			'description' => 'Sesión para pymes y equipos de RRHH de Castilla-La Mancha: cómo planificar formación bonificada, documentación y calendario anual sin sorpresas a final de año.',
		),
		array(
			'id'          => 'orientacion-mudela',
			'title'       => 'Orientación laboral presencial · Santa Cruz de Mudela',
			'date'        => $year . '-09-18T10:00:00+02:00',
			'date_label'  => '18 septiembre · 10:00 h',
			'location'    => 'C. Cruz de Piedra, 13 · Ciudad Real',
			'mode'        => 'presencial',
			'tag'         => 'Con cita previa',
			'emoji'       => '📍',
			'excerpt'     => 'Revisamos tu perfil, cursos que encajan y próximos pasos. Trae CV si lo tienes; si no, te ayudamos a ordenar ideas.',
			'description' => 'Punto de información en nuestro centro de referencia. Atención personalizada para desempleados y trabajadores en activo de la zona. Duración estimada: 30–40 minutos por persona.',
		),
		array(
			'id'          => 'maraton-google-drive',
			'title'       => 'Maratón «Google Drive sin pánico»',
			'date'        => $year . '-10-08T17:00:00+02:00',
			'date_label'  => '8 octubre · 17:00 h',
			'location'    => 'Online',
			'mode'        => 'online',
			'tag'         => 'Novedad',
			'emoji'       => '☁️',
			'excerpt'     => 'Compartir carpetas, permisos y no borrar el archivo de todo el equipo por accidente. Sí, ha pasado.',
			'description' => 'Avance del curso de ofimática en la nube con Google Drive en CLM. Perfecto para teletrabajo y pymes que viven en documentos compartidos.',
		),
	);
}

/**
 * @return string
 */
function centroformacionlaguna_eventos_content_html() {
	$cursos_url   = function_exists( 'centroformacionlaguna_cursos_archive_url' )
		? centroformacionlaguna_cursos_archive_url()
		: home_url( '/cursos-subvencionados-castilla-la-mancha/' );
	$contacto_url = home_url( '/contacto/' );
	$como_url     = function_exists( 'centroformacionlaguna_como_funciona_url' )
		? centroformacionlaguna_como_funciona_url()
		: home_url( '/como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha/' );
	$events       = centroformacionlaguna_eventos_schedule();

	ob_start();
	?>
	<article class="centroformacionlaguna-page centroformacionlaguna-eventos" id="centroformacionlaguna-eventos-top">
		<header class="centroformacionlaguna-eventos-hero">
			<div class="centroformacionlaguna-eventos-hero__glow" aria-hidden="true"></div>
			<p class="centroformacionlaguna-eventos-kicker">Agenda Centro Formacion Laguna · Castilla-La Mancha</p>
			<h1>Eventos donde aprendes, preguntas… y no te vendemos un máster carísimo</h1>
			<p class="centroformacionlaguna-lead centroformacionlaguna-eventos-lead">
				Jornadas gratuitas, webinars y encuentros presenciales para sacarle partido a la
				<strong>formación subvencionada</strong>. Sin powerpoints interminables de la ESO.
				Con tutores reales, humor controlado y respuestas que entiende tu madre.
			</p>
			<div class="centroformacionlaguna-eventos-hero__actions">
				<a class="centroformacionlaguna-cta" href="#agenda">Ver la agenda</a>
				<a class="centroformacionlaguna-cta centroformacionlaguna-cta--ghost" href="<?php echo esc_url( $contacto_url ); ?>">Quiero que me aviséis</a>
			</div>
			<ul class="centroformacionlaguna-eventos-stats" aria-label="Datos rápidos">
				<li><strong>100&nbsp;%</strong> orientados al empleo</li>
				<li><strong>0</strong> letra pequeña tipo «sorpresa, ahora pagas»</li>
				<li><strong>+500</strong> cursos detrás de cada charla</li>
			</ul>
		</header>

		<nav class="centroformacionlaguna-eventos-filters" aria-label="Filtrar eventos por modalidad">
			<button type="button" class="is-active" data-filter="all">Todos</button>
			<button type="button" data-filter="online">Online</button>
			<button type="button" data-filter="presencial">Presencial</button>
			<button type="button" data-filter="empresas">Empresas</button>
		</nav>

		<section class="centroformacionlaguna-eventos-grid-wrap" id="agenda" aria-labelledby="eventos-agenda-title">
			<h2 id="eventos-agenda-title">Próximos eventos</h2>
			<p class="centroformacionlaguna-eventos-grid-intro">
				Fechas orientativas — confirma plaza en contacto. Si un evento se llena, no hacemos
				«últimas 2 plazas» cada martes durante seis meses. Prometido.
			</p>
			<div class="centroformacionlaguna-eventos-grid">
				<?php foreach ( $events as $event ) : ?>
					<?php
					$filter_class = $event['mode'];
					if ( false !== strpos( $event['title'], 'empresas' ) || false !== strpos( $event['id'], 'empresa' ) ) {
						$filter_class .= ' empresas';
					}
					?>
					<article
						class="centroformacionlaguna-event-card"
						data-mode="<?php echo esc_attr( $event['mode'] ); ?>"
						data-tags="<?php echo esc_attr( $filter_class ); ?>"
						id="evento-<?php echo esc_attr( $event['id'] ); ?>"
					>
						<div class="centroformacionlaguna-event-card__top">
							<span class="centroformacionlaguna-event-card__emoji" aria-hidden="true"><?php echo esc_html( $event['emoji'] ); ?></span>
							<span class="centroformacionlaguna-event-card__tag"><?php echo esc_html( $event['tag'] ); ?></span>
						</div>
						<time datetime="<?php echo esc_attr( $event['date'] ); ?>"><?php echo esc_html( $event['date_label'] ); ?></time>
						<h3><?php echo esc_html( $event['title'] ); ?></h3>
						<p class="centroformacionlaguna-event-card__loc"><?php echo esc_html( $event['location'] ); ?></p>
						<p><?php echo esc_html( $event['excerpt'] ); ?></p>
						<details class="centroformacionlaguna-event-card__more">
							<summary>Más info (sin relleno)</summary>
							<p><?php echo esc_html( $event['description'] ); ?></p>
						</details>
						<a class="centroformacionlaguna-event-card__cta" href="<?php echo esc_url( $contacto_url ); ?>?asunto=<?php echo rawurlencode( 'Evento: ' . $event['title'] ); ?>">
							Reservar plaza
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="centroformacionlaguna-eventos-types" aria-labelledby="eventos-tipos-title">
			<h2 id="eventos-tipos-title">¿Qué puedes encontrarte aquí?</h2>
			<div class="centroformacionlaguna-eventos-types__grid">
				<div class="centroformacionlaguna-eventos-type-card">
					<h3>🎓 Webinars SEPE</h3>
					<p>Inscripción, requisitos y catálogo sin tecnicismos. Para cuando Google te ha dado cincuenta respuestas distintas.</p>
				</div>
				<div class="centroformacionlaguna-eventos-type-card">
					<h3>🏢 Sesiones para empresas</h3>
					<p>Bonificación y planificación formativa. El Excel de RRHH te lo agradecerá (y tu crédito FUNDAE también).</p>
				</div>
				<div class="centroformacionlaguna-eventos-type-card">
					<h3>📍 Encuentros en centro</h3>
					<p>En Santa Cruz de Mudela y red de centros en CLM. Humanos, sillas y orientación cara a cara.</p>
				</div>
				<div class="centroformacionlaguna-eventos-type-card">
					<h3>🛠️ Talleres demostración</h3>
					<p>Muestras de ofimática, digitalización e idiomas. Probar antes de matricularse: como una test drive, pero de conocimiento.</p>
				</div>
			</div>
		</section>

		<section class="centroformacionlaguna-eventos-fun" aria-labelledby="eventos-fun-title">
			<h2 id="eventos-fun-title">Eventos que NO organizamos (por si acaso)</h2>
			<ul class="centroformacionlaguna-eventos-fun-list">
				<li>«Cómo hacerse rico en 48 horas vendiendo cursos a tus primos»</li>
				<li>«Networking» que es solo un folleto y un café frío</li>
				<li>Webinar de 4 horas donde el 70&nbsp;% es publicidad de otro webinar</li>
				<li>Sorteo de un PDF llamado «guía definitiva» con 3 páginas en Comic Sans</li>
			</ul>
			<p class="centroformacionlaguna-eventos-fun-note">
				Lo nuestro va de <strong>formación para el empleo en Castilla-La Mancha</strong>.
				Serio en lo importante; relajados en el trato.
			</p>
		</section>

		<section class="centroformacionlaguna-eventos-faq" aria-labelledby="eventos-faq-title">
			<h2 id="eventos-faq-title">Preguntas que nos hacen (con cariño)</h2>
			<details>
				<summary>¿Los eventos son gratis?</summary>
				<p>Casi siempre sí: son sesiones informativas u orientativas. Los cursos completos siguen su propia convocatoria subvencionada. Si algún día cobráramos por un café, te avisaríamos en grande.</p>
			</details>
			<details>
				<summary>¿Puedo asistir si aún no sé qué curso quiero?</summary>
				<p>Perfecto. Para eso están. Te ayudamos a encajar perfil, plazos y objetivo profesional.</p>
			</details>
			<details>
				<summary>¿Hacéis eventos solo en Ciudad Real?</summary>
				<p>La base es CLM y online para toda la región. Consulta fechas presenciales o pide cita en tu municipio.</p>
			</details>
		</section>

		<section class="centroformacionlaguna-eventos-cta centroformacionlaguna-landing-cta-block" aria-labelledby="eventos-cta-title">
			<h2 id="eventos-cta-title">¿No encuentras tu fecha ideal?</h2>
			<p>
				Escríbenos y te avisamos de la siguiente convocatoria. Mientras tanto, puedes explorar
				el catálogo o leer cómo funciona la inscripción paso a paso.
			</p>
			<p>
				<a class="centroformacionlaguna-cta" href="<?php echo esc_url( $contacto_url ); ?>">Contactar con Centro Formacion Laguna</a>
				<a class="centroformacionlaguna-cta centroformacionlaguna-cta--ghost" href="<?php echo esc_url( $cursos_url ); ?>">Ver cursos subvencionados</a>
				<a class="centroformacionlaguna-cta centroformacionlaguna-cta--ghost" href="<?php echo esc_url( $como_url ); ?>">Cómo funciona el SEPE</a>
			</p>
		</section>
	</article>
	<?php
	return (string) ob_get_clean();
}

/**
 * Crea la página si no existe.
 */
function centroformacionlaguna_ensure_eventos_page() {
	if ( get_option( CENTROFORMACIONLAGUNA_EVENTOS_OPTION ) ) {
		$page_id = (int) get_option( CENTROFORMACIONLAGUNA_EVENTOS_OPTION );
		if ( $page_id && 'publish' === get_post_status( $page_id ) ) {
			return;
		}
	}

	$existing = get_page_by_path( CENTROFORMACIONLAGUNA_EVENTOS_SLUG, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		update_option( CENTROFORMACIONLAGUNA_EVENTOS_OPTION, $existing->ID );
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Eventos Centro Formacion Laguna: jornadas y webinars de formación en Castilla-La Mancha',
			'post_name'    => CENTROFORMACIONLAGUNA_EVENTOS_SLUG,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => centroformacionlaguna_eventos_content_html(),
		),
		true
	);

	if ( ! is_wp_error( $page_id ) && $page_id ) {
		update_option( CENTROFORMACIONLAGUNA_EVENTOS_OPTION, $page_id );
		if ( class_exists( '\RankMath\Helper' ) ) {
			update_post_meta(
				$page_id,
				'rank_math_title',
				'Eventos y jornadas de formación subvencionada en Castilla-La Mancha | Centro Formacion Laguna'
			);
			update_post_meta(
				$page_id,
				'rank_math_description',
				'Webinars, puertas abiertas y orientación laboral gratuita en CLM. Eventos Centro Formacion Laguna sobre cursos SEPE, empresas y formación online. Reserva tu plaza.'
			);
		}
	}
}

/**
 * JSON-LD Event para SEO.
 */
function centroformacionlaguna_eventos_print_schema() {
	if ( ! is_page( CENTROFORMACIONLAGUNA_EVENTOS_SLUG ) ) {
		return;
	}

	$events = array();
	foreach ( centroformacionlaguna_eventos_schedule() as $event ) {
		$is_presencial = ( 'presencial' === $event['mode'] );
		$location      = array(
			'@type' => $is_presencial ? 'Place' : 'VirtualLocation',
			'name'  => $event['location'],
			'url'   => centroformacionlaguna_eventos_url(),
		);
		if ( $is_presencial ) {
			$location['address'] = array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'C. Cruz de Piedra, 13',
				'addressLocality' => 'Santa Cruz de Mudela',
				'addressRegion'   => 'Ciudad Real',
				'postalCode'      => '13730',
				'addressCountry'  => 'ES',
			);
		}

		$events[] = array(
			'@type'               => 'Event',
			'name'                => $event['title'],
			'startDate'           => $event['date'],
			'eventAttendanceMode' => $is_presencial
				? 'https://schema.org/OfflineEventAttendanceMode'
				: 'https://schema.org/OnlineEventAttendanceMode',
			'eventStatus'         => 'https://schema.org/EventScheduled',
			'location'            => $location,
			'description'         => $event['description'],
			'organizer'           => array(
				'@type' => 'Organization',
				'name'  => 'Centro Formacion Laguna — Centro de Educación Polivalente',
				'url'   => home_url( '/' ),
			),
			'offers'              => array(
				'@type'   => 'Offer',
				'price'   => '0',
				'priceCurrency' => 'EUR',
				'availability'  => 'https://schema.org/InStock',
				'url'           => home_url( '/contacto/' ),
			),
			'isAccessibleForFree' => true,
		);
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => $events,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

add_action(
	'admin_init',
	static function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		centroformacionlaguna_ensure_eventos_page();
	},
	20
);

add_filter(
	'the_content',
	static function ( $content ) {
		if ( ! is_page( CENTROFORMACIONLAGUNA_EVENTOS_SLUG ) ) {
			return $content;
		}
		$custom = centroformacionlaguna_eventos_content_html();
		if ( strlen( trim( wp_strip_all_tags( $content ) ) ) < 80 ) {
			return $custom;
		}
		return $content;
	},
	5
);

add_action( 'wp_head', 'centroformacionlaguna_eventos_print_schema', 20 );

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! is_page( CENTROFORMACIONLAGUNA_EVENTOS_SLUG ) ) {
			return;
		}
		wp_enqueue_style(
			'centroformacionlaguna-eventos',
			get_stylesheet_directory_uri() . '/assets/css/centroformacionlaguna-eventos.css',
			array( 'eduma-child-centroformacionlaguna' ),
			EDUMA_CHILD_VERSION
		);
		wp_enqueue_script(
			'centroformacionlaguna-eventos',
			get_stylesheet_directory_uri() . '/assets/js/centroformacionlaguna-eventos.js',
			array(),
			EDUMA_CHILD_VERSION,
			true
		);
	},
	1005
);

/* Demo Eduma /events/ → landing propia. */
add_action(
	'template_redirect',
	static function () {
		if ( is_admin() ) {
			return;
		}

		$target = centroformacionlaguna_eventos_url();

		if ( is_post_type_archive( 'tp_event' ) || is_singular( 'tp_event' ) ) {
			wp_safe_redirect( $target, 301 );
			exit;
		}

		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
		if ( is_string( $path ) && preg_match( '#^/events/?$#i', $path ) && ! is_page( CENTROFORMACIONLAGUNA_EVENTOS_SLUG ) ) {
			wp_safe_redirect( $target, 301 );
			exit;
		}
	},
	1
);
