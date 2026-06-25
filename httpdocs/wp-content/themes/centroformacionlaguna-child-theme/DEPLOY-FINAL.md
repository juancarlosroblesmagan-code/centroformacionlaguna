# Despliegue final Centro Formacion Laguna (v1.3.0 child + mu-pack 2.0.0)

## Resumen

| Qué | Dónde en servidor |
|-----|-------------------|
| Mu-plugin único | `wp-content/mu-plugins/centroformacionlaguna-mu-pack.php` |
| Tema hijo completo | `wp-content/themes/centroformacionlaguna-child-theme/` |

## Qué NO subir a mu-plugins

Ver `tools/mu-plugins/_NO-SUBIR/README.md`. Especialmente **no** `centroformacionlaguna-site-fixes.php`.

## Orden recomendado

1. Tema activo temporalmente **Eduma** (padre) si el child dio pantalla blanca.
2. Limpiar `mu-plugins/` de archivos Centro Formacion Laguna viejos.
3. Subir `centroformacionlaguna-mu-pack.php` v2.0.0.
4. Vaciar caché WP Rocket.
5. Verificar home en incógnito.
6. Subir carpeta child completa y activar child (modo seguro por defecto).
7. Vaciar caché otra vez.
8. Opcional: `CENTROFORMACIONLAGUNA_CHILD_FULL` + Centro Formacion Laguna Setup.

## Modo seguro del child

Por defecto carga solo módulos estables (`performance`, CF7, WooCommerce cursos, etc.).

Con `CENTROFORMACIONLAGUNA_CHILD_FULL` se añaden: Conócenos, Cómo funciona, eventos, importación, setup.

## Coordinación mu-pack ↔ child

- `CENTROFORMACIONLAGUNA_MU_PACK_ACTIVE` evita doble CSS y doble `ob_start` en home.
- Conócenos: `inc/centroformacionlaguna-conocenos.php` + `assets/css/centroformacionlaguna-conocenos-page.css`

## IDs de referencia

- Conócenos: página 16705
- FAQ: 16729
- Menú Cursos: #menu-item-16477
- Catálogo CLM: slug `cursos-subvencionados-castilla-la-mancha`

## CF7 (opcional)

`tools/mu-plugins/centroformacionlaguna-cf7-config-fix.php` — solo administración; compatible PHP 7.4 (`strpos`).

## Documentación del proyecto

- `docs/DEPLOY-CENTROFORMACIONLAGUNA.md`
- `docs/WINSCP-SUBIDA.md`
- `tools/PASOS-ARREGLAR-AHORA.md`
