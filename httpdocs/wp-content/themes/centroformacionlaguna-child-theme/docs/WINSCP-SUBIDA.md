# Subir el proyecto con WinSCP (Centro Formacion Laguna)

## Rutas en tu PC (origen)

```
c:\Users\juanc\OneDrive\Escritorio\CURSOR Web\eduma\
c:\Users\juanc\OneDrive\Escritorio\CURSOR Web\eduma-child\
```

## Ruta en el servidor Plesk (destino habitual)

Conéctate al sitio `friendly-sutherland.5-175-47-192.plesk.page` y abre:

```
/httpdocs/wp-content/themes/
```

(o `public_html/wp-content/themes/` según tu hosting)

## Qué arrastrar

| Panel izquierdo (local) | Panel derecho (servidor) |
|-------------------------|---------------------------|
| Carpeta `eduma` completa | `.../themes/eduma/` |
| Carpeta `eduma-child` completa | `.../themes/eduma-child/` |

**Modo de transferencia:** Sobrescribir archivos existentes.

**No subas** la carpeta `.claude` ni `InfoSystem` si está vacía.

## Después de subir (en WordPress)

1. **Apariencia → Temas** → Activar **Eduma Child - Centro Formacion Laguna** (versión `1.2.0`).
2. Entra al **wp-admin** una vez (como `CursosPremium`). Al cargar el escritorio el child:
   - **Importa los 2 cursos CLM** desde `cursospremiumonline.es` (contenido, etiquetas e imagen destacada). Si la conexión externa falla, usa el HTML local de respaldo.
   - **Desactiva LearnPress** y todos sus addons (LMS) automáticamente.
3. **Apariencia → Centro Formacion Laguna Setup** → **Ejecutar configuración** (solo si quieres recrear páginas/menú; la importación de cursos ya se ha hecho).
4. **WP Rocket → Vaciar caché** y refresca `https://friendly-sutherland.5-175-47-192.plesk.page/cursos-subvencionados-castilla-la-mancha/` para verlos.

> Para forzar una nueva sincronización después de tocar el contenido en el código, sube el valor de `EDUMA_CHILD_COURSES_IMPORT_VERSION` en `inc/centroformacionlaguna-import-courses.php` y vuelve a entrar al wp-admin.

También puedes ejecutar a mano la sincronización desde:
`/wp-admin/?eduma_child_sync_courses=1&_wpnonce=...` (botón en el asistente Centro Formacion Laguna Setup).

## Si quieres que el agente suba por SFTP (terminal)

Pásame por chat (o en un mensaje privado si prefieres):

- Host (ej. `5-175-47-192.plesk.page` o IP)
- Puerto (normalmente `22`)
- Usuario SFTP
- Contraseña **o** ruta a clave privada
- Ruta remota exacta a `wp-content/themes` (la que ves en WinSCP a la derecha)

Con eso puedo intentar la subida desde aquí con `scp`/`sftp`.

## Acceso WordPress (para terminar Elementor)

Si me das usuario + contraseña de administrador, puedo completar desde el navegador:

- Activar child theme y asistente
- Revisar menús y página de cursos
- Indicarte qué bloques Elementor tocar (no puedo “adivinar” sin entrar)

**No guardes contraseñas en archivos del repositorio.**
