# Caché: WP Rocket y FlyingPress con Eduma

Guía para usar **un solo** plugin de caché (no ambos a la vez) con el child theme **Eduma Child - Optimized**.

El child theme ya registra exclusiones automáticas en `inc/cache-plugins.php`. Esta guía complementa la configuración en el panel del plugin.

---

## Antes de empezar

1. Activa **Eduma Child - Optimized**.
2. Vacía caché del plugin y del navegador.
3. Anota la URL de tu homepage (ej. `https://tudominio.com/`).
4. Prueba en **modo incógnito** tras cada cambio grande.

---

## WP Rocket — configuración recomendada

### Cache

| Opción | Valor |
|--------|--------|
| Mobile cache | Activado |
| Separate cache files for mobile | Activado (si el diseño móvil difiere) |
| User cache | Desactivado (salvo membresías por rol) |

**Never cache URL(s)** — el child añade cart/checkout/cuenta; revisa en *Advanced rules* que estén:

```
/cart(.*)
/checkout(.*)
/my-account(.*)
/wishlist(.*)
```

### File optimization

| Opción | Valor | Notas Eduma |
|--------|--------|-------------|
| Minify CSS | Sí | |
| Combine CSS | **No** al inicio | Puede romper orden de estilos LP/Elementor |
| Optimize CSS delivery | Sí | Critical CSS / async |
| Remove Unused CSS | Sí | Safelist ya ampliada por el child |
| Minify JavaScript | Sí | |
| Combine JavaScript | **No** | LearnPress y Elementor suelen romperse |
| Load JavaScript deferred | **No** si usas Delay JS | Elige una estrategia |
| Delay JavaScript execution | Sí | Exclusiones vía child + lista abajo |

### Media

| Opción | Valor |
|--------|--------|
| LazyLoad images | Sí |
| LazyLoad CSS backgrounds | Sí (probar) |
| Exclude images above the fold | Añadir clase o selector del hero |

Para el hero de la home, en el bloque/imagen principal añade en WP Rocket → *Excluded images*: la URL de la imagen LCP o la clase del contenedor (ej. `.thim-hero`, `.elementor-element-xxx`).

### Preload

| Opción | Valor |
|--------|--------|
| Preload links | Sí |
| Prefetch DNS requests | Solo dominios que uses (Analytics, etc.) |
| Preload fonts | Solo si las fuentes están **autohospedadas** |

### Exclusiones manuales Delay JS (pegar en “Excluded JavaScript Files”)

Si algo falla (menú, filtros de cursos, carrito), añade:

```
/jquery/jquery.min.js
/wp-includes/js/wp-hooks
learn-press
learnpress
thim-main
thim-scripts
thim-course-filter
elementor-frontend
woocommerce
wc-cart-fragments
imagesloaded
```

### Remove Unused CSS — Safelist adicional (si ves diseño roto)

En *CSS safelist* del plugin, una línea por patrón:

```
.thim
.edu-
.learn-press
.lp-
.menu-mobile
#masthead
.elementor
.woocommerce
.course-
```

### Tras guardar

1. **Clear cache** en WP Rocket.
2. **Regenerate** Remove Unused CSS si está activo (botón en el plugin).
3. Prueba: home, archivo de cursos, un curso, carrito.

---

## FlyingPress — configuración recomendada

### Cache

- **Page Cache**: ON  
- **Preload**: ON (sitemap o URLs principales)  
- Excluir las mismas rutas dinámicas (cart, checkout, my-account)

### CSS

| Opción | Valor |
|--------|--------|
| Minify CSS | ON |
| Remove Unused CSS | ON (con precaución) |
| Critical CSS / Load CSS asynchronously | ON |

Si el menú o los cursos se ven mal, desactiva Remove Unused CSS temporalmente y usa solo minify + critical.

### JavaScript

| Opción | Valor |
|--------|--------|
| Minify JS | ON |
| Defer JS | ON |
| Delay JS | ON para terceros; **excluir** scripts del tema |

En **Exclude from Delay** (o equivalente), pega:

```
jquery
wp-hooks
learn-press
learnpress
thim-main
thim-scripts
thim-course-filter
elementor
woocommerce
wc-cart-fragments
imagesloaded
```

En **Delay on interaction** (opcional), puedes retrasar:

```
googletagmanager.com
google-analytics.com
fbevents.js
hotjar
tawk.to
crisp.chat
```

### Imágenes

- Lazy load: ON  
- Excluir la imagen LCP de la homepage (URL o selector)

### Si los filtros PHP no aplican en tu versión

FlyingPress cambia nombres de filtros entre versiones. El child registra varios alias; si no funcionan, usa solo la caja de exclusiones de la UI con la lista de arriba.

---

## PageSpeed / Lighthouse — checklist

### URLs a medir

| URL | Por qué |
|-----|---------|
| `/` | Homepage — LCP del hero |
| `/courses/` (o slug de cursos) | Filtros + grid LearnPress |
| Un curso single | Tabs + vídeo + botón matricular |
| `/cart/` | WooCommerce (si aplica) |

### Herramientas

- [PageSpeed Insights](https://pagespeed.web.dev/) — móvil primero  
- Chrome DevTools → Lighthouse (modo móvil, sin extensión)  
- WebPageTest opcional (waterfall)

### Orden de pruebas

1. **Baseline**: child activo, **sin** plugin de caché → guardar captura.  
2. **Child + caché**: activar WP Rocket *o* FlyingPress con esta guía → vaciar caché → medir de nuevo.  
3. Comparar **LCP**, **INP**, **CLS**, peso de `style.css` y número de peticiones JS.

### Objetivos orientativos (móvil)

| Métrica | Antes (típico Eduma) | Objetivo tras optimizar |
|---------|----------------------|-------------------------|
| LCP | 4–8 s | &lt; 2.5 s |
| INP | 200–500 ms | &lt; 200 ms |
| CLS | variable | &lt; 0.1 |
| CSS transferido | 700 KB+ | bajar con RUCSS + crítico |

### Si LCP sigue alto

1. Imagen hero: WebP/AVIF, tamaño correcto, `fetchpriority="high"` (Elementor → optimización de imagen o código en plantilla).  
2. Confirmar preloader desactivado (Customizer + child).  
3. Remove Unused CSS activo con safelist.  
4. Menos sliders/autoplay en above-the-fold.  
5. Hosting con HTTP/2 o 3 y Brotli.

### Si INP es malo

1. Revisar exclusiones Delay JS (menú y `thim-main`).  
2. No combinar JS.  
3. Desactivar scripts de chat/analytics hasta interacción.

### Si CLS sube

1. Dimensiones fijas en imágenes de cursos y carruseles.  
2. Reservar altura del header sticky.  
3. No cargar fuentes que cambien métricas (FOIT/FOUT) — `font-display: swap` ya está en el tema.

---

## Compartir resultados para revisión

Copia y rellena:

```
Homepage: https://...
Child theme: sí / no
Plugin caché: WP Rocket / FlyingPress / ninguno
PageSpeed móvil — Performance: __
LCP: __ | INP: __ | CLS: __
Plugins activos: LearnPress, Elementor, WooCommerce, ...
Problema visual: ninguno / menú / cursos / checkout
```

Con esa ficha se puede afinar exclusiones sin adivinar.

---

## Conflictos frecuentes

| Síntoma | Causa probable | Solución |
|---------|----------------|----------|
| Menú móvil no abre | Delay JS en `thim-main` / jQuery | Excluir scripts de la lista |
| Filtro de cursos no filtra | `thim-course-filter` o `wp-hooks` retrasados | Excluir |
| Carrito mini vacío | `wc-cart-fragments` retrasado | Excluir |
| Estilos rotos en curso | Remove Unused CSS agresivo | Safelist `.lp-`, `.learn-press` |
| Pantalla blanca al pagar | Caché en checkout | Excluir URL checkout |

---

## Siguiente paso opcional en código

- Autohospedar fuentes y preload local.  
- Sustituir `thim_get_feature_image()` por `wp_get_attachment_image()` con `srcset`.  
- Tema padre oficial sin código nulled.
