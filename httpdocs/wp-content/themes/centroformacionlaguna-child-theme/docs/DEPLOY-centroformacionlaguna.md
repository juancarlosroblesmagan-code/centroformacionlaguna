# Desplegar y finalizar Centro Formacion Laguna en Plesk

Sitio de prueba: `https://friendly-sutherland.5-175-47-192.plesk.page/`

## 1. Subir archivos por FTP / Administrador de archivos Plesk

Sube estas carpetas a `wp-content/themes/` del servidor:

| Carpeta local | Destino en servidor |
|---------------|---------------------|
| `eduma/` | `wp-content/themes/eduma/` |
| `eduma-child/` | `wp-content/themes/eduma-child/` |

Si ya existe `eduma` en el servidor, **sobrescribe** con la copia local (incluye eliminación del código nulled en `functions.php`).

## 2. Activar el child theme

1. WordPress → **Apariencia → Temas**
2. Activa **Eduma Child - Optimized**
3. Debe aparecer un aviso amarillo: **Abrir asistente**

## 3. Ejecutar el asistente Centro Formacion Laguna

1. **Apariencia → Centro Formacion Laguna Setup**
2. Pulsa **Ejecutar / repetir configuración**

Esto crea o actualiza:

- `/conocenos/` — Quiénes somos (ya no 404)
- `/contacto/`
- `/faqs/`
- `/trabaja-con-nosotros/`
- `/politica-de-privacidad/`
- `/aviso-legal/`
- Menú **Centro Formacion Laguna Principal** (sin mega menú demo)
- Asigna **Cursos Gratis** a LearnPress y quita conflicto con WooCommerce tienda

## 4. Comprobar en el front

| URL | Debe mostrar |
|-----|----------------|
| `/conocenos/` | Página institucional en español |
| `/cursos-gratis/` | Catálogo **LearnPress** (cursos), no libros WooCommerce |
| Menú superior | Inicio, Cursos Gratis, Conócenos, Blog, Contacto — sin "Buy now" |

## 5. Lo que debes hacer en Elementor (home)

La portada está construida con **Elementor** y conserva bloques del demo en inglés. Edítala en:

**Páginas → Demo Main Centro Formacion Laguna (o la página de inicio) → Editar con Elementor**

Sustituye o traduce manualmente:

| Bloque actual (demo) | Sustituir por |
|----------------------|---------------|
| Get Free Access / Full Name | Regístrate gratis / Nombre completo |
| Package Courses | Programas formativos |
| Share Your Knowledge. Teach the World. | Únete a nuestro equipo de formadores |
| Eventos con Lorem Ipsum | Talleres reales o oculta la sección |
| Posts en inglés (Working Smart with AI…) | Artículos en español o oculta |
| Minísterio → **Ministerio** | Corregir typo en texto del hero |
| Pinteret / intagram | Pinterest / Instagram en redes del footer |

## 6. LearnPress — cursos reales

1. **LearnPress → Cursos → Añadir nuevo**
2. Crea cursos en español (ofimática, administrativo, idiomas…)
3. Marca precio **0** o "Gratis" según tu configuración
4. En **Ajustes → LearnPress → Páginas**, confirma que "Cursos" apunta a **Cursos Gratis**

Opcional: elimina productos WooCommerce de demo (libros en inglés) en **Productos**.

## 7. Blog

- Sustituye entradas demo por noticias en español, o despublica las que no uses.
- Cambia autor "CursosPremium" por **Centro Formacion Laguna** en usuarios.

## 8. Footer (widgets)

**Apariencia → Widgets → Footer**

Sustituye columnas demo (About, Documentation, Purchase, Recommend WordPress…) por:

**Centro Formacion Laguna**  
Conócenos · Blog · Contacto · Trabaja con nosotros

**Enlaces**  
Cursos gratis · FAQs · Eventos (si los usas)

**Contacto**  
Teléfono, email, dirección Santa Cruz de Mudela

**Legal**  
Política de privacidad · Aviso legal

## 9. Rendimiento (recomendado)

Ver [`CACHE-PLUGINS.md`](CACHE-PLUGINS.md) y activar WP Rocket o FlyingPress.

## 10. Dominio definitivo (centroformacionlaguna.net)

Dominio provisional actual: `friendly-sutherland.5-175-47-192.plesk.page`  
Dominio final: **centroformacionlaguna.net**

En Plesk, cuando el DNS apunte a centroformacionlaguna.net:

1. Asigna **centroformacionlaguna.net** como dominio principal del sitio
2. **Ajustes → Generales** → cambia ambas URLs a `https://centroformacionlaguna.net`
3. Regenera certificado SSL en Plesk
4. **WP Rocket** → vaciar caché
5. **Rank Math** → comprobar sitemap y redirecciones

Opcional en `wp-config.php` (solo durante la migración, quitar después):

```php
define( 'CENTROFORMACIONLAGUNA_HOME_URL', 'https://centroformacionlaguna.net' );
define( 'CENTROFORMACIONLAGUNA_SITE_URL', 'https://centroformacionlaguna.net' );
```

El child theme incluye filtros en `inc/centroformacionlaguna-domain.php` para esas constantes.

---

## Credenciales necesarias

Para editar Elementor, menús avanzados o importar demos necesitas acceso **wp-admin**. Si no tienes usuario, créalo en Plesk → WordPress → Usuarios o por base de datos.

---

## Resumen de lo que el código ya hace solo

- Sin preloader
- Sin enlaces Buy now / ThimPress (CSS + filtros)
- Menú simplificado (tras el asistente)
- Páginas legales e institucionales en español
- Copyright Centro Formacion Laguna
- Corrección página cursos vs tienda WooCommerce

## Lo que requiere tu edición en WordPress

- Contenido Elementor de la home
- Cursos LearnPress reales
- Entradas de blog
- Widgets del footer
- Formulario de contacto (plugin)
- Revisión legal de privacidad y aviso legal
