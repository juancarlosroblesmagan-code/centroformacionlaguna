<?php
/**
 * Landing «Cómo funcionan los cursos subvencionados» (SEO SEPE / CLM).
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

const CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG   = 'como-funcionan-cursos-subvencionados-sepe-castilla-la-mancha';
const CENTROFORMACIONLAGUNA_COMO_FUNCIONA_OPTION = 'centroformacionlaguna_como_funciona_page_id';
const CENTROFORMACIONLAGUNA_COMO_FUNCIONA_VER    = 'centroformacionlaguna_como_funciona_content_ver';
const CENTROFORMACIONLAGUNA_COMO_FUNCIONA_VERSION = 3;

/**
 * @return string
 */
function centroformacionlaguna_como_funciona_url() {
	return home_url( '/' . CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG . '/' );
}

/**
 * @return string
 */
function centroformacionlaguna_como_funciona_cursos_url() {
	if ( function_exists( 'centroformacionlaguna_site_cursos_url' ) ) {
		return centroformacionlaguna_site_cursos_url();
	}
	if ( function_exists( 'eduma_child_wc_courses_category_url' ) ) {
		return eduma_child_wc_courses_category_url();
	}
	return home_url( '/cursos-subvencionados-castilla-la-mancha/' );
}

if ( ! function_exists( 'centroformacionlaguna_como_funciona_content_html' ) ) :
/**
 * HTML de la landing (UTF-8, diseño moderno).
 *
 * @return string
 */
function centroformacionlaguna_como_funciona_content_html() {
	$cursos_url   = centroformacionlaguna_como_funciona_cursos_url();
	$contacto_url = home_url( '/contacto/' );
	$faq_url      = home_url( '/preguntas-frecuentes/' );
	$img_hero     = esc_url( content_url( '/uploads/2026/05/centroscentroformacionlaguna-banner.webp' ) );
	$img_online   = esc_url( content_url( '/uploads/2026/05/centroscentroformacionlaguna-banner.webp' ) );

	ob_start();
	?>
	<article class="centroformacionlaguna-page centroformacionlaguna-landing-como-funciona centroformacionlaguna-landing-modern">
		<div class="cf-intro-grid">
			<div class="cf-intro-copy">
				<p class="centroformacionlaguna-landing-kicker">Formación para el empleo · Castilla-La Mancha</p>
				<p class="centroformacionlaguna-lead">En <strong>Centro Formacion Laguna</strong> te guiamos en todo el proceso: comprobar requisitos, inscripción gratuita, formación <strong>100&nbsp;% online</strong> y certificado al finalizar.</p>
				<div class="cf-cta-row">
					<a class="centroformacionlaguna-cta" href="<?php echo esc_url( $cursos_url ); ?>">Ver catálogo de cursos</a>
					<a class="centroformacionlaguna-cta centroformacionlaguna-cta--ghost" href="<?php echo esc_url( $contacto_url ); ?>">Solicitar información</a>
				</div>
				<ul class="cf-stats" aria-label="Datos Centro Formacion Laguna">
					<li><strong>+500</strong><span>cursos</span></li>
					<li><strong>+2.000</strong><span>alumnos</span></li>
					<li><strong>100&nbsp;%</strong><span>online</span></li>
				</ul>
			</div>
			<figure class="cf-intro-media">
				<img src="<?php echo esc_url( $img_hero ); ?>" alt="Alumnos en formación online con Centro Formacion Laguna en Castilla-La Mancha" width="720" height="480" loading="eager" decoding="async" />
			</figure>
		</div>

		<section class="cf-section" aria-labelledby="cf-pasos">
			<h2 id="cf-pasos">El proceso en 5 pasos</h2>
			<p class="cf-section-lead">Desde la consulta del catálogo hasta tu certificado: un recorrido claro y sin coste de matrícula en cursos subvencionados.</p>
			<ol class="centroformacionlaguna-steps cf-steps-grid">
				<li>
					<span class="cf-step-num" aria-hidden="true">1</span>
					<h3>Comprueba tu perfil</h3>
					<p>Trabajadores en activo, desempleados o empresas que bonifican la formación. Documentación habitual: DNI/NIE y vida laboral.</p>
				</li>
				<li>
					<span class="cf-step-num" aria-hidden="true">2</span>
					<h3>Elige tu curso</h3>
					<p>Digitalización, ofimática en la nube, idiomas, PRL, hostelería y competencias transversales en Castilla-La Mancha.</p>
				</li>
				<li>
					<span class="cf-step-num" aria-hidden="true">3</span>
					<h3>Inscríbete gratis</h3>
					<p>Sin coste de matrícula en acciones subvencionadas. Te ayudamos con el formulario y el alta en la plataforma.</p>
				</li>
				<li>
					<span class="cf-step-num" aria-hidden="true">4</span>
					<h3>Formación a tu ritmo</h3>
					<p>Desde ordenador, tablet o móvil, con tutores especializados y contenidos actualizados.</p>
				</li>
				<li>
					<span class="cf-step-num" aria-hidden="true">5</span>
					<h3>Obtén tu certificado</h3>
					<p>Al superar la evaluación recibes certificado acreditativo para tu empleo actual o tu búsqueda de trabajo.</p>
				</li>
			</ol>
		</section>

		<section class="cf-split" aria-labelledby="cf-quien">
			<div class="cf-split-copy">
				<h2 id="cf-quien">¿Quién financia estos cursos?</h2>
				<p>La <strong>formación programada para el empleo</strong> se articula con fondos del <strong>SEPE</strong>, la <strong>Junta de Castilla-La Mancha</strong> y, en formación bonificada, las cotizaciones de las empresas.</p>
				<p>Centro Formacion Laguna es centro colaborador que imparte acciones formativas adaptadas al mercado laboral de la región.</p>
			</div>
			<figure class="cf-split-media">
				<img src="<?php echo esc_url( $img_online ); ?>" alt="Formación subvencionada online con apoyo de tutores" width="640" height="420" loading="lazy" decoding="async" />
			</figure>
		</section>

		<section class="cf-section" aria-labelledby="cf-ventajas">
			<h2 id="cf-ventajas">Ventajas de formarte con Centro Formacion Laguna</h2>
			<ul class="cf-benefits">
				<li>Más de <strong>500 cursos</strong> y nuevas incorporaciones periódicas</li>
				<li>Modalidad <strong>100&nbsp;% online</strong> con tutorización</li>
				<li>Especialización en empleo, digitalización y competencias transversales</li>
				<li>Atención en español para toda <strong>Castilla-La Mancha</strong></li>
			</ul>
		</section>

		<section class="centroformacionlaguna-landing-cta-block" aria-labelledby="cf-cta">
			<h2 id="cf-cta">¿Listo para empezar?</h2>
			<p>Consulta el catálogo actualizado o escríbenos si tienes dudas sobre plazas, convocatorias o documentación.</p>
			<div class="cf-cta-row">
				<a class="centroformacionlaguna-cta" href="<?php echo esc_url( $cursos_url ); ?>">Ver todos los cursos gratuitos</a>
				<a class="centroformacionlaguna-cta centroformacionlaguna-cta--ghost" href="<?php echo esc_url( $faq_url ); ?>">Preguntas frecuentes</a>
			</div>
		</section>
	</article>
	<?php
	return (string) ob_get_clean();
}
endif;

if ( ! function_exists( 'centroformacionlaguna_sync_como_funciona_page_content' ) ) :
/**
 * Sincroniza título y contenido en la base de datos (UTF-8 correcto).
 */
function centroformacionlaguna_sync_como_funciona_page_content() {
	if ( (int) get_option( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_VER, 0 ) >= CENTROFORMACIONLAGUNA_COMO_FUNCIONA_VERSION ) {
		return;
	}

	$page = get_page_by_path( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG, OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$title = 'Cómo funcionan los cursos subvencionados por el SEPE en Castilla-La Mancha';

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_title'   => $title,
			'post_content' => centroformacionlaguna_como_funciona_content_html(),
		)
	);

	update_option( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_OPTION, $page->ID );

	if ( class_exists( '\RankMath\Helper' ) ) {
		update_post_meta( $page->ID, 'rank_math_title', 'Cómo funcionan los cursos subvencionados SEPE en Castilla-La Mancha | Centro Formacion Laguna' );
		update_post_meta( $page->ID, 'rank_math_description', 'Guía paso a paso: requisitos, inscripción gratuita, formación online y certificado de cursos subvencionados por el SEPE en Castilla-La Mancha con Centro Formacion Laguna.' );
	}

	update_option( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_VER, CENTROFORMACIONLAGUNA_COMO_FUNCIONA_VERSION );
}
endif;

if ( ! function_exists( 'centroformacionlaguna_como_funciona_page_css' ) ) :
/**
 * @return string
 */
function centroformacionlaguna_como_funciona_page_css() {
	return '
body.centroformacionlaguna-page-como-funciona #sidebar,
body.centroformacionlaguna-page-como-funciona .widget-area,
body.centroformacionlaguna-page-como-funciona .sticky-sidebar,
body.centroformacionlaguna-page-como-funciona aside.sidebar,
body.centroformacionlaguna-page-como-funciona .col-sm-3:not(.cf-intro-grid *) {
	display:none!important;
}
body.centroformacionlaguna-page-como-funciona main.site-main,
body.centroformacionlaguna-page-como-funciona .content-area,
body.centroformacionlaguna-page-como-funciona .col-sm-9 {
	width:100%!important;max-width:100%!important;flex:0 0 100%!important;
}
body.centroformacionlaguna-page-como-funciona .container.site-content {
	max-width:1140px;
}
.centroformacionlaguna-landing-modern {
	max-width:100%;
	padding:0 0 3rem;
}
.cf-intro-grid {
	display:grid;
	grid-template-columns:1fr 1fr;
	gap:2.5rem;
	align-items:center;
	margin-bottom:3rem;
	padding:2rem;
	background:linear-gradient(135deg,#faf8f6 0%,#fff 55%);
	border-radius:16px;
	border:1px solid #eee;
}
.cf-intro-media img,
.cf-split-media img {
	width:100%;
	height:auto;
	border-radius:12px;
	box-shadow:0 12px 40px rgba(0,0,0,.12);
	object-fit:cover;
}
.centroformacionlaguna-landing-kicker {
	text-transform:uppercase;
	letter-spacing:.08em;
	font-size:.8rem;
	color:#8b1a1a;
	font-weight:700;
	margin:0 0 1rem;
}
.centroformacionlaguna-landing-modern .centroformacionlaguna-lead {
	font-size:1.125rem;
	line-height:1.75;
	color:#444;
	margin:0 0 1.5rem;
}
.cf-cta-row {
	display:flex;
	flex-wrap:wrap;
	gap:12px;
	margin-bottom:1.5rem;
}
.cf-stats {
	list-style:none;
	display:flex;
	flex-wrap:wrap;
	gap:1.25rem;
	padding:0;
	margin:0;
}
.cf-stats li {
	background:#fff;
	border:1px solid #eee;
	border-radius:10px;
	padding:.75rem 1.25rem;
	min-width:100px;
	text-align:center;
	box-shadow:0 2px 12px rgba(0,0,0,.04);
}
.cf-stats strong {
	display:block;
	font-size:1.35rem;
	color:#8b1a1a;
}
.cf-stats span {
	font-size:.8rem;
	color:#666;
	text-transform:uppercase;
	letter-spacing:.04em;
}
.cf-section {
	margin-bottom:3rem;
}
.cf-section h2 {
	color:#8b1a1a;
	font-size:clamp(1.5rem,3vw,2rem);
	margin-bottom:.75rem;
}
.cf-section-lead {
	color:#555;
	max-width:640px;
	margin-bottom:1.75rem;
	line-height:1.7;
}
.cf-steps-grid {
	list-style:none;
	padding:0;
	margin:0;
	display:grid;
	grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
	gap:1.25rem;
}
.cf-steps-grid > li {
	position:relative;
	margin:0;
	padding:1.5rem 1.25rem 1.25rem 1.25rem;
	background:#fff;
	border:1px solid #eee;
	border-radius:12px;
	box-shadow:0 4px 24px rgba(0,0,0,.06);
}
.cf-step-num {
	position:absolute;
	top:1rem;
	right:1rem;
	width:2rem;
	height:2rem;
	line-height:2rem;
	text-align:center;
	background:#ffb606;
	color:#1a1a1a;
	font-weight:800;
	border-radius:50%;
	font-size:.9rem;
}
.cf-steps-grid h3 {
	margin:0 2.5rem .5rem 0;
	color:#8b1a1a;
	font-size:1.05rem;
}
.cf-steps-grid p {
	margin:0;
	line-height:1.65;
	color:#444;
	font-size:.95rem;
}
.cf-split {
	display:grid;
	grid-template-columns:1fr 1fr;
	gap:2rem;
	align-items:center;
	margin-bottom:3rem;
	padding:2rem;
	background:#8b1a1a;
	border-radius:16px;
	color:#fff;
}
.cf-split h2,
.cf-split p {
	color:#fff;
}
.cf-split p {
	line-height:1.75;
	opacity:.95;
}
.cf-benefits {
	list-style:none;
	padding:0;
	margin:0;
	display:grid;
	grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
	gap:1rem;
}
.cf-benefits li {
	padding:1rem 1.25rem;
	background:#fafafa;
	border-left:4px solid #ffb606;
	border-radius:0 8px 8px 0;
	line-height:1.6;
}
.centroformacionlaguna-landing-cta-block {
	background:linear-gradient(135deg,#5c1010 0%,#8b1a1a 100%);
	color:#fff;
	padding:2.5rem 2rem;
	border-radius:16px;
	text-align:center;
}
.centroformacionlaguna-landing-cta-block h2,
.centroformacionlaguna-landing-cta-block p {
	color:#fff;
}
.centroformacionlaguna-landing-cta-block .cf-cta-row {
	justify-content:center;
	margin-top:1rem;
}
.centroformacionlaguna-landing-cta-block .centroformacionlaguna-cta {
	background:#ffb606;
	color:#1a1a1a!important;
	border:2px solid #ffb606;
	padding:14px 28px;
	border-radius:8px;
	font-weight:700;
	text-decoration:none;
	display:inline-block;
}
.centroformacionlaguna-landing-cta-block .centroformacionlaguna-cta--ghost {
	background:transparent;
	color:#fff!important;
	border:2px solid #fff;
	border-radius:999px;
}
.centroformacionlaguna-landing-modern .centroformacionlaguna-cta:not(.centroformacionlaguna-cta--ghost) {
	background:#ffb606;
	color:#1a1a1a!important;
	border:2px solid #ffb606;
	padding:14px 28px;
	border-radius:8px;
	font-weight:700;
	text-decoration:none;
	display:inline-block;
}
.centroformacionlaguna-landing-modern .centroformacionlaguna-cta--ghost {
	background:transparent;
	color:#8b1a1a!important;
	border:2px solid #8b1a1a;
	padding:14px 28px;
	border-radius:999px;
	font-weight:600;
	text-decoration:none;
	display:inline-block;
}
.centroformacionlaguna-landing-modern .centroformacionlaguna-cta--ghost:hover {
	background:#8b1a1a;
	color:#fff!important;
}
@media (max-width:900px){
	.cf-intro-grid,.cf-split{grid-template-columns:1fr;}
	.cf-intro-media{order:-1;}
}
';
}
endif;

add_action(
	'admin_init',
	static function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		centroformacionlaguna_ensure_como_funciona_page();
	},
	20
);
if ( function_exists( 'centroformacionlaguna_sync_como_funciona_page_content' ) ) {
	add_action(
		'admin_init',
		static function () {
			if ( ! current_user_can( 'edit_pages' ) ) {
				return;
			}
			centroformacionlaguna_sync_como_funciona_page_content();
		},
		25
	);
}

/**
 * Crea la página si no existe.
 */
function centroformacionlaguna_ensure_como_funciona_page() {
	if ( get_option( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_OPTION ) ) {
		$page_id = (int) get_option( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_OPTION );
		if ( $page_id && 'publish' === get_post_status( $page_id ) ) {
			return;
		}
	}

	$existing = get_page_by_path( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		update_option( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_OPTION, $existing->ID );
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Cómo funcionan los cursos subvencionados por el SEPE en Castilla-La Mancha',
			'post_name'    => CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => centroformacionlaguna_como_funciona_content_html(),
		),
		true
	);

	if ( ! is_wp_error( $page_id ) && $page_id ) {
		update_option( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_OPTION, $page_id );
	}
}

if ( ! defined( 'CENTROFORMACIONLAGUNA_CF_SLUG' ) ) {
	add_filter(
		'the_content',
		static function ( $content ) {
			if ( ! is_page( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG ) ) {
				return $content;
			}
			return centroformacionlaguna_como_funciona_content_html();
		},
		999
	);
}

add_filter(
	'body_class',
	static function ( $classes ) {
		if ( is_page( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG ) ) {
			$classes[] = 'centroformacionlaguna-page-como-funciona';
		}
		return $classes;
	}
);

add_filter(
	'document_title_parts',
	static function ( $parts ) {
		if ( is_page( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG ) ) {
			$parts['title'] = 'Cómo funcionan los cursos subvencionados SEPE en Castilla-La Mancha';
		}
		return $parts;
	}
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! is_page( CENTROFORMACIONLAGUNA_COMO_FUNCIONA_SLUG ) || ! function_exists( 'centroformacionlaguna_como_funciona_page_css' ) ) {
			return;
		}
		if ( defined( 'CENTROFORMACIONLAGUNA_CF_SLUG' ) && wp_style_is( 'centroformacionlaguna-site-fixes', 'enqueued' ) ) {
			return;
		}
		$handle = 'centroformacionlaguna-como-funciona-inline';
		wp_register_style( $handle, false, array(), (string) CENTROFORMACIONLAGUNA_COMO_FUNCIONA_VERSION );
		wp_enqueue_style( $handle );
		wp_add_inline_style( $handle, centroformacionlaguna_como_funciona_page_css() );
		wp_enqueue_style(
			'centroformacionlaguna-como-funciona',
			get_stylesheet_directory_uri() . '/assets/css/centroformacionlaguna-como-funciona.css',
			array( $handle ),
			defined( 'EDUMA_CHILD_VERSION' ) ? EDUMA_CHILD_VERSION : '1.0'
		);
	},
	100000
);
