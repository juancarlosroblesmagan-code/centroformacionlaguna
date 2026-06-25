# Centro Formacion Laguna — qué hacer al despertar (5–10 minutos)

Paquete preparado en esta carpeta (`eduma-child`). La web en vivo **aún muestra textos demo** porque falta subir los archivos al servidor.

## ¿Tengo que pulsar RUN en Cursor?

**No**, si subes tú los archivos por Plesk o WinSCP. El agente no puede dejar la web perfecta en `centroscentroformacionlaguna.com` sin que alguien copie archivos al hosting.

Los avisos **Run** aparecen cuando el agente pide permisos extra (red, “all”, git). Para irte a dormir tranquilo: **no hace falta dejar Cursor abierto**; basta con seguir esta lista mañana.

## Paso 1 — Mu-plugin (lo más importante)

1. En Plesk → Archivos → `httpdocs/wp-content/mu-plugins/`
2. **Borra** cualquier `centroformacionlaguna-site-fixes.php`, `centroformacionlaguna-global-ui-fix.php`, etc. (ver `tools/mu-plugins/_NO-SUBIR/README.md`)
3. Sube **solo** desde tu PC:
   - `eduma-child/tools/mu-plugins/centroformacionlaguna-mu-pack.php`

## Paso 2 — Tema hijo (carpeta completa)

1. Sube **toda** la carpeta local `eduma-child` al servidor como:
   - `httpdocs/wp-content/themes/centroformacionlaguna-child-theme/`
2. En WordPress → Apariencia → Temas:
   - Activa **Eduma Child - Centro Formacion Laguna** (o el nombre del child)
   - Si sale pantalla blanca: vuelve a **Eduma** (padre) — el mu-pack sigue arreglando la home

## Paso 3 — Caché

WP Rocket → Vaciar caché. Prueba en ventana privada.

## Paso 4 — Comprobar

Abre https://centroscentroformacionlaguna.com/

- Menú: **Cursos** (no “Cursos Gratis”)
- Sin “View All Packages”
- Acordeón con textos de Castilla-La Mancha (no “Inscríbete cuando quieras…” en los 4 paneles)

## Opcional (cuando todo vaya bien)

En `wp-config.php`, **solo si quieres** Conócenos completo, eventos, importación:

```php
define( 'CENTROFORMACIONLAGUNA_CHILD_FULL', true );
```

Luego: Apariencia → **Centro Formacion Laguna Setup** (menú y páginas).

## Si algo falla

- Script de emergencia (subir, usar una vez, **borrar**): `tools/recuperar-web.php` → `httpdocs/recuperar-web.php`
- Guía detallada: `DEPLOY-FINAL.md`

## Plesk / acceso

No hace falta darme la contraseña de Plesk en el chat. Con **File Manager** o **WinSCP** (`docs/WINSCP-SUBIDA.md`) tú subes los 2 elementos de arriba y queda igual de bien.

Si quieres que el agente entre por navegador a wp-admin, tendrías que estar delante para login/2FA — no sirve para irte a dormir sin supervisión.
