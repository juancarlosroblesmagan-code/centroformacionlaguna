<?php
/**
 * Contenido HTML de páginas institucionales Centro Formacion Laguna.
 *
 * @package eduma-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return array<string, array{title:string, slug:string, content:string, template?:string}>
 */
function eduma_child_centroformacionlaguna_page_definitions() {
	$phone   = '+34 926 33 11 62';
	$email   = 'info@centroscentroformacionlaguna.com';
	$address = 'C. Cruz de Piedra, 13 · 13700 Santa Cruz de Mudela, Ciudad Real';

	return array(
		'conocenos' => array(
			'title'   => 'Conócenos',
			'slug'    => 'conocenos',
			'content' => eduma_child_centroformacionlaguna_content_conocenos( $phone, $email, $address ),
		),
		'contacto'  => array(
			'title'   => 'Contacto',
			'slug'    => 'contacto',
			'content' => eduma_child_centroformacionlaguna_content_contacto( $phone, $email, $address ),
		),
		'faqs'      => array(
			'title'   => 'Preguntas frecuentes',
			'slug'    => 'faqs',
			'content' => eduma_child_centroformacionlaguna_content_faqs(),
		),
		'trabaja'   => array(
			'title'   => 'Trabaja con nosotros',
			'slug'    => 'trabaja-con-nosotros',
			'content' => eduma_child_centroformacionlaguna_content_trabaja( $email ),
		),
		'privacidad' => array(
			'title'   => 'Política de privacidad',
			'slug'    => 'politica-de-privacidad',
			'content' => eduma_child_centroformacionlaguna_content_privacidad( $email ),
		),
		'aviso'     => array(
			'title'   => 'Aviso legal',
			'slug'    => 'aviso-legal',
			'content' => eduma_child_centroformacionlaguna_content_aviso( $email, $address ),
		),
	);
}

/**
 * @param string $phone
 * @param string $email
 * @param string $address
 * @return string
 */
function eduma_child_centroformacionlaguna_content_conocenos( $phone, $email, $address ) {
	ob_start();
	?>
	<div class="centroformacionlaguna-page centroformacionlaguna-page--about">
		<p class="centroformacionlaguna-lead">Desde 2007, <strong>Centro Formacion Laguna — Centro de Educación Polivalente</strong> impulsa la formación para el empleo en Castilla-La Mancha con cursos gratuitos y bonificados para trabajadores, desempleados y empresas.</p>

		<h2>Quiénes somos</h2>
		<p>Somos un centro especializado en formación profesional para el empleo, con sedes y puntos de atención en <strong>Santa Cruz de Mudela</strong>, <strong>Viso del Marqués</strong>, <strong>Fuente del Fresno</strong> y <strong>Membrilla</strong>. Acompañamos a personas y organizaciones con programas actualizados, tutores expertos y metodología flexible (presencial, online y mixta).</p>

		<h2>Qué ofrecemos</h2>
		<ul>
			<li><strong>Cursos gratuitos para trabajadores</strong> — Formación subvencionada para mejorar competencias dentro de la empresa.</li>
			<li><strong>Cursos gratuitos para desempleados</strong> — Acción formativa orientada a la inserción laboral.</li>
			<li><strong>Formación bonificada para empresas</strong> — Planes FUNDAE y programas a medida.</li>
			<li><strong>Talleres y jornadas</strong> — Actividades presenciales y online en la región.</li>
		</ul>

		<h2>Nuestros centros</h2>
		<p>Centro principal: <?php echo esc_html( $address ); ?>. Teléfono: <a href="tel:+34926331162"><?php echo esc_html( $phone ); ?></a> · Email: <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>

		<h2>Compromiso</h2>
		<p>Trabajamos con administraciones y organismos como la Junta de Castilla-La Mancha, el Ministerio de Trabajo y Economía Social y el Ministerio de Educación y Formación Profesional y Deportes para ofrecer formación de calidad, accesible y orientada a resultados reales en el mercado laboral.</p>

		<p><a class="centroformacionlaguna-cta" href="<?php echo esc_url( home_url( '/cursos-gratis/' ) ); ?>">Ver cursos gratuitos</a> · <a class="centroformacionlaguna-cta centroformacionlaguna-cta--ghost" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">Solicitar información</a></p>
	</div>
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * @param string $phone
 * @param string $email
 * @param string $address
 * @return string
 */
function eduma_child_centroformacionlaguna_content_contacto( $phone, $email, $address ) {
	ob_start();
	?>
	<div class="centroformacionlaguna-page centroformacionlaguna-page--contact">
		<p class="centroformacionlaguna-lead">¿Tienes dudas sobre requisitos, plazas o convocatorias? Escríbenos o llámanos y te orientamos sin compromiso.</p>
		<div class="centroformacionlaguna-contact-grid">
			<div>
				<h2>Datos de contacto</h2>
				<ul>
					<li><strong>Teléfono:</strong> <a href="tel:+34926331162"><?php echo esc_html( $phone ); ?></a></li>
					<li><strong>Email:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
					<li><strong>Dirección:</strong> <?php echo esc_html( $address ); ?></li>
				</ul>
				<h3>Horario de atención</h3>
				<p>Lunes a viernes, 9:00 – 14:00 y 16:00 – 19:00 (consultar festivos locales).</p>
			</div>
			<div>
				<h2>Otros centros</h2>
				<p>Viso del Marqués · Fuente del Fresno · Membrilla. Indica tu localidad al contactar y te derivamos al punto más cercano.</p>
			</div>
		</div>
		<p>Si tu web usa un formulario de contacto (Contact Form 7, WPForms, etc.), puedes insertarlo aquí desde el editor de WordPress.</p>
	</div>
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * @return string
 */
function eduma_child_centroformacionlaguna_content_faqs() {
	ob_start();
	?>
	<div class="centroformacionlaguna-page centroformacionlaguna-page--faqs">
		<h2>Preguntas frecuentes</h2>
		<div class="centroformacionlaguna-faq">
			<h3>¿Los cursos son realmente gratuitos?</h3>
			<p>Sí, cuando se trata de acciones subvencionadas para desempleados o trabajadores según convocatoria vigente. Los requisitos dependen del programa y del organismo que financia la formación.</p>
		</div>
		<div class="centroformacionlaguna-faq">
			<h3>¿Quién puede inscribirse?</h3>
			<p>Depende del curso: hay itinerarios para personas en desempleo, ocupados de empresas adheridas y formación bonificada para pymes. Te informamos caso por caso.</p>
		</div>
		<div class="centroformacionlaguna-faq">
			<h3>¿Puedo hacer el curso online?</h3>
			<p>Muchos programas combinan modalidad online y presencial. En la ficha de cada curso verás la modalidad, duración y fechas.</p>
		</div>
		<div class="centroformacionlaguna-faq">
			<h3>¿Entregáis certificado o diploma?</h3>
			<p>Al finalizar y superar la evaluación, recibes la acreditación correspondiente según el tipo de acción formativa (certificado de profesionalidad, diploma de asistencia, etc.).</p>
		</div>
		<div class="centroformacionlaguna-faq">
			<h3>¿Cómo me inscribo?</h3>
			<p>Consulta el catálogo en <a href="<?php echo esc_url( home_url( '/cursos-gratis/' ) ); ?>">Cursos gratis</a>, elige tu curso y sigue el proceso de matrícula o contacta con nosotros para ayuda.</p>
		</div>
	</div>
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * @param string $email
 * @return string
 */
function eduma_child_centroformacionlaguna_content_trabaja( $email ) {
	ob_start();
	?>
	<div class="centroformacionlaguna-page centroformacionlaguna-page--jobs">
		<p class="centroformacionlaguna-lead">¿Te apasiona la formación? Buscamos tutores, coordinadores y personal administrativo en Castilla-La Mancha.</p>
		<h2>Cómo enviar tu candidatura</h2>
		<p>Envía tu CV y área de especialización a <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a> con el asunto <strong>Trabaja con nosotros</strong>.</p>
		<h2>Perfiles habituales</h2>
		<ul>
			<li>Formadores en administración, informática, idiomas y ofimática</li>
			<li>Coordinación de grupos y seguimiento de alumnado</li>
			<li>Gestión de convocatorias y documentación FUNDAE / SEPE</li>
		</ul>
	</div>
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * @param string $email
 * @return string
 */
function eduma_child_centroformacionlaguna_content_privacidad( $email ) {
	ob_start();
	?>
	<div class="centroformacionlaguna-page centroformacionlaguna-page--legal">
		<h2>Política de privacidad</h2>
		<p><em>Texto base. Debe revisarse por asesoría legal antes de publicación definitiva.</em></p>
		<p>El responsable del tratamiento es Centro de Educación Polivalente Centro Formacion Laguna. Puedes ejercer tus derechos de acceso, rectificación, supresión y otros escribiendo a <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>.</p>
		<p>Tratamos los datos que nos facilitas para gestionar solicitudes de información, matrículas en cursos y comunicaciones relacionadas con nuestros servicios formativos.</p>
	</div>
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * @param string $email
 * @param string $address
 * @return string
 */
function eduma_child_centroformacionlaguna_content_aviso( $email, $address ) {
	ob_start();
	?>
	<div class="centroformacionlaguna-page centroformacionlaguna-page--legal">
		<h2>Aviso legal</h2>
		<p><em>Texto base. Debe revisarse por asesoría legal antes de publicación definitiva.</em></p>
		<p><strong>Titular:</strong> Centro de Educación Polivalente Centro Formacion Laguna<br>
		<strong>Domicilio:</strong> <?php echo esc_html( $address ); ?><br>
		<strong>Contacto:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
		<p>El acceso a este sitio web implica la aceptación de las condiciones de uso. Los contenidos tienen fines informativos sobre la oferta formativa del centro.</p>
	</div>
	<?php
	return trim( (string) ob_get_clean() );
}
