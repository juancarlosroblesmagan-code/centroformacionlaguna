# 🎓 GUÍA DE INSTALACIÓN — CENTROFORMACIONLAGUNA
## Centro de Educación Polivalente
## centroformacionlaguna.net · Santa Cruz de Mudela, Ciudad Real

---

## PASO 1 — CLONAR LA WEB ORIGINAL (cursospremiumonline.es)

### Opción A: Con Duplicator (recomendado)
1. Accede a WordPress de cursospremiumonline.es
2. Ve a **Duplicator → Packages → Create New**
3. Selecciona "Full Site" y genera el paquete
4. Descarga los 2 archivos: `installer.php` y el `.zip`

### Opción B: Con All-in-One WP Migration
1. Instala el plugin **All-in-One WP Migration**
2. Ve a **All-in-One → Export**
3. Descarga el archivo `.wpress`

---

## PASO 2 — CREAR EL DOMINIO EN PLESK

1. Accede a: https://5.175.47.192:8443
2. Ve a **Domains → Add Domain**
3. Nombre sugerido: `demo.centroformacionlaguna.net` o `centroformacionlaguna.friendly-sutherland.5-175-47-192.plesk.page`
4. Crea una base de datos nueva:
   - Nombre: `centroformacionlaguna_wp`
   - Usuario: `centroformacionlaguna_usr`
   - Contraseña: (genera una segura)

---

## PASO 3 — INSTALAR WORDPRESS Y RESTAURAR EL CLON

### Si usaste Duplicator:
1. Sube `installer.php` y el `.zip` a la carpeta raíz del nuevo dominio (via FTP o Administrador de Archivos Plesk)
2. Navega a `https://tudominio.com/installer.php`
3. Sigue el asistente: introduce los datos de la nueva base de datos
4. Al finalizar, tendrás una copia exacta de cursospremiumonline.es

### Si usaste All-in-One WP Migration:
1. Instala WordPress limpio en el nuevo dominio
2. Instala el plugin **All-in-One WP Migration**
3. Ve a **All-in-One → Import** y sube el archivo `.wpress`

---

## PASO 4 — INSTALAR EL CHILD THEME DE CENTROFORMACIONLAGUNA

1. Sube la carpeta `centroformacionlaguna-child/` a: `/wp-content/themes/`
2. En WordPress: **Apariencia → Temas**
3. Activa **"Centro Formacion Laguna Child"**

### El child theme aplica automáticamente:
- ✅ Color granate `#8B1A1A` en header, botones, títulos
- ✅ Color dorado `#D4880A` en acentos, hover, iconos
- ✅ Tipografía Merriweather (titulares) + Source Sans Pro (cuerpo)
- ✅ Footer oscuro con bordes dorados
- ✅ Animaciones suaves al hacer scroll
- ✅ Scroll suave en enlaces internos
- ✅ Shortcodes: `[centroformacionlaguna_phone]`, `[centroformacionlaguna_email]`, `[centroformacionlaguna_address]`

---

## PASO 5 — AJUSTES INICIALES EN WORDPRESS

### 5.1 Ajustes Generales
- Ve a **Ajustes → Generales**
- Título del sitio: `Centro Formacion Laguna — Centro de Educación Polivalente`
- Descripción: `Formación para el empleo en Castilla-La Mancha`
- Email: `info@centroformacionlaguna.net`

### 5.2 Logo
- Ve a **Apariencia → Personalizar → Identidad del sitio**
- Sube el logo de Centro Formacion Laguna (PNG con fondo transparente, mín. 300px de ancho)
- Sube también el favicon (ICO o PNG 32x32)

### 5.3 Colores (si quieres ajustar)
- Ve a **Apariencia → Personalizar → Centro Formacion Laguna — Configuración → Colores Corporativos**
- Puedes cambiar los HEX de granate y dorado sin tocar código

### 5.4 Datos de contacto
- Ve a **Apariencia → Personalizar → Centro Formacion Laguna — Configuración → Datos de Contacto**
- Actualiza teléfono, email y dirección

---

## PASO 6 — ACTUALIZAR CONTENIDO

### Páginas a revisar/actualizar:
| Página          | Cambios necesarios                                    |
|-----------------|-------------------------------------------------------|
| Inicio          | Hero slider (textos + imágenes), sección planes       |
| Nosotros        | Historia de Centro Formacion Laguna, foto directora, misión/visión |
| Cursos Gratis   | Cursos SEPE disponibles en Castilla-La Mancha         |
| Contacto        | Dirección, teléfono, email, mapa (Cruz de Piedra, 13) |
| Blog            | Borrar posts de ejemplo, crear primeros artículos     |
| Footer          | Logo, datos, enlaces                                  |

### Textos clave a reemplazar:
- "Cursos Premium" → "Centro Formacion Laguna"
- "cursospremiumonline.es" → "centroformacionlaguna.net"  
- "910 785 785" → "926 33 11 62"
- "hola@cursospremiumonline.es" → "info@centroformacionlaguna.net"
- "Spain" → "C. Cruz de Piedra, 13 · Santa Cruz de Mudela, Ciudad Real"
- "Comunidad de Madrid" → "Castilla-La Mancha" (en menú y planes)

---

## PASO 7 — PLAN DE CURSOS (adaptar secciones)

### Tu web tiene 3 planes. Para Centro Formacion Laguna serían:

| Plan Original (cursospremium) | Plan Centro Formacion Laguna                    |
|-------------------------------|------------------------------------|
| Plan Estatal                  | Plan Estatal SEPE                  |
| Plan Comunidad de Madrid      | Plan Castilla-La Mancha (JCCM)     |
| Plan Castilla La-Mancha       | Plan Formación Privada / Bonificada |

---

## PASO 8 — PLUGINS A REVISAR/ACTUALIZAR

| Plugin                  | Acción                                              |
|-------------------------|-----------------------------------------------------|
| LearnPress              | Actualizar y mantener                               |
| Revolution Slider       | Cambiar imágenes y textos del hero                  |
| WooCommerce             | Actualizar datos fiscales y de pago                 |
| WPML / Polylang         | Solo si necesitan múltiples idiomas                 |
| Yoast SEO / Rank Math   | Configurar datos de Centro Formacion Laguna en SEO               |
| Contact Form 7          | Actualizar email de destino a info@centroformacionlaguna.net   |
| Cookie plugin           | Actualizar política de privacidad con datos de Centro Formacion Laguna |

---

## PASO 9 — SEO BÁSICO

Una vez instalado, configurar en Rank Math o Yoast:
- **Nombre del sitio**: Centro Formacion Laguna — Centro de Educación Polivalente
- **Palabras clave**: cursos gratuitos Ciudad Real, formación SEPE Castilla-La Mancha, cursos subvencionados Santa Cruz de Mudela
- **Google Business Profile**: Crear ficha en maps.google.com con la dirección del centro
- **Schema Local Business**: tipo `EducationalOrganization`

---

## PASO 10 — SEGURIDAD POST-INSTALACIÓN

⚠️ **IMPORTANTE — Cambiar credenciales:**
1. Contraseña de WordPress admin
2. Contraseña de root del servidor Plesk  
3. Contraseña FTP
4. Contraseña de base de datos

**Plugins de seguridad recomendados:**
- Wordfence Security (gratuito)
- WP Cerber Security
- UpdraftPlus (backups automáticos)

---

## SHORTCODES DISPONIBLES

Usa estos en cualquier página o widget:

```
[centroformacionlaguna_phone]   → +34 926 33 11 62 (enlace clickeable en móvil)
[centroformacionlaguna_email]   → info@centroformacionlaguna.net (enlace mailto)
[centroformacionlaguna_address] → C. Cruz de Piedra, 13 · Santa Cruz de Mudela, CR
```

---

## ESTRUCTURA DE ARCHIVOS DEL CHILD THEME

```
centroformacionlaguna-child/
├── style.css          ← Colores, tipografía, todos los estilos de marca
├── functions.php      ← Carga estilos, shortcodes, customizer, menús
├── js/
│   └── centroformacionlaguna-custom.js  ← Animaciones, sticky header, scroll suave
└── images/
    └── (poner aquí logo en PNG para uso en CSS si es necesario)
```

---

## CONTACTO DEL DESARROLLADOR

**Juan Carlos Robles Magán**
http://roblesmagan.com/
Grupo Comunicación 360º — http://grupocomunicacion360.com/

---
*Documento generado automáticamente — Centro Formacion Laguna Child Theme v1.0.0*
