# Eduma Child — Centro Formacion Laguna

Child theme para **Centro Formacion Laguna** (Eduma) con rendimiento, asistente de páginas y limpieza del demo.

**Despliegue en el servidor:** [`docs/DEPLOY-CENTROFORMACIONLAGUNA.md`](docs/DEPLOY-CENTROFORMACIONLAGUNA.md)

## Activación

1. En WordPress: **Apariencia → Temas**
2. Activa **Eduma Child - Optimized**
3. El tema padre **Eduma** debe permanecer instalado

## Qué hace

| Mejora | Efecto |
|--------|--------|
| Preloader desactivado | Mejor LCP, sin delay de 500 ms |
| Scripts del tema con `defer` | Menos bloqueo del parser |
| Google Fonts del tema quitadas | Menos peticiones externas (si usas otras fuentes, configúralas en Customizer o Elementor) |
| Filtro de cursos LP solo en archivo | Menos JS en el resto de páginas |
| CSS inline de demos recortado | Menos peso si no usas clases `demo-*` |
| Header corregido | Pingback y profile https |
| Menú móvil | `<button>` + ARIA |

## Importante — licencia y seguridad

El `functions.php` del tema **padre** contenía código de tema nulled (redirección a wordpressnull.org). Ese bloque fue **eliminado** en esta copia del proyecto.

Para producción estable:

- Compra o renueva **Eduma** en [ThimPress](https://thimpress.com/eduma/)
- Sustituye la carpeta `eduma` por la versión oficial
- Mantén este child theme para tus personalizaciones

## Caché (WP Rocket / FlyingPress)

Guía completa: [`docs/CACHE-PLUGINS.md`](docs/CACHE-PLUGINS.md)  
Listas para copiar/pegar: [`docs/wp-rocket-exclusions.txt`](docs/wp-rocket-exclusions.txt), [`docs/flyingpress-exclusions.txt`](docs/flyingpress-exclusions.txt)

El child registra exclusiones automáticas si el plugin está activo.

## Siguiente fase (manual o con plugin de caché)

- Critical CSS + minificación (ver guía de caché)
- Imágenes WebP y `fetchpriority` en hero
- Purga de CSS no usado (el `style.css` del padre sigue siendo ~716 KB)
- Unificar iconos (FA + Ionicons + Pe-icon → uno solo)

## Revertir el preloader

Comenta o elimina el filtro `theme_mod_thim_preload` en `inc/performance.php`.
