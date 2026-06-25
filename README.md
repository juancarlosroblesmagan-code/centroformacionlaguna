# Centro de Formación Laguna — Portal Web

Este repositorio contiene la configuración de contenedores, scripts de automatización, base de datos inicial, tema hijo y extensiones imprescindibles (MU-plugins) para el sitio web del **Centro de Formación Laguna** (anteriormente conocido como Infosystem).

El entorno de desarrollo local está totalmente contenedorizado con Docker y configurado para replicar el comportamiento de producción, incluyendo todas las optimizaciones de SEO, imágenes profesionales integradas y diseño de la Home gestionable mediante Elementor.

---

## Estructura del Proyecto

El repositorio sigue un esquema limpio e ignora los archivos del núcleo de WordPress y directorios temporales, rastreando únicamente las partes personalizadas del proyecto:

```
├── compose.yaml                      # Configuración de Docker Compose (WordPress + MariaDB)
├── custom-php.ini                    # Configuración optimizada de PHP para el servidor local
├── iniciar-servidor.bat              # Script rápido para iniciar el entorno local
├── detener-servidor.bat              # Script rápido para detener los contenedores
├── restablecer-base-de-datos.bat     # Script para reiniciar la BD local e importar el volcado limpio
├── init-db/
│   └── db.sql.gz                     # Volcado inicial y final de la base de datos (comprimido en UTF-8)
└── httpdocs/
    └── wp-content/
        ├── mu-plugins/               # Plugins imprescindibles para SEO local, PWA y correcciones del entorno
        └── themes/
            └── centroformacionlaguna-child-theme/  # Tema hijo con estilos premium y funciones dinámicas
```

---

## Requisitos Previos

- Tener instalado **Docker Desktop** en tu máquina (Windows/Mac/Linux).
- Tener instalado **Git**.

---

## Inicio Rápido (Desarrollo Local)

### 1. Levantar los Contenedores
Para arrancar el sitio web localmente, haz doble clic en el archivo `iniciar-servidor.bat` o ejecuta desde la terminal:
```bash
docker compose up -d
```
Una vez iniciado, el portal estará disponible en tu navegador en:
**[http://localhost:8082](http://localhost:8082)**

### 2. Restablecer o Importar la Base de Datos
Si necesitas limpiar la base de datos local y reimportar la copia final/de producción contenida en `init-db/db.sql.gz`, haz doble clic en el archivo `restablecer-base-de-datos.bat` o ejecuta:
```bash
docker compose down -v
docker compose up -d
```
*Nota: Al limpiar el volumen `db_data_laguna` con `down -v`, la base de datos se recreará importando automáticamente el archivo `init-db/db.sql.gz` al iniciar el contenedor de MariaDB.*

---

## Componentes Personalizados y Optimizaciones

### 1. Tema Hijo (`centroformacionlaguna-child-theme`)
- **Estilos Premium en style.css**: Contiene el diseño adaptativo y estilos modernos para los botones del Hero ("Explorar programas" y "Conoce más") y las características en la parte inferior de la portada sobre el fondo, eliminando estilos antiguos obsoletos.
- **Functions php Dinámico**: Integra la función `centroformacionlaguna_get_hero_image_url()`, que extrae dinámicamente el fondo configurado por Elementor para inyectar una etiqueta `preload` en el `<head>`. Esto optimiza el LCP (Largest Contentful Paint) para SEO de manera automática sin hardcodear imágenes en el código.
- **Totalmente compatible con Elementor**: El diseño de la Home se realiza al 100% mediante Elementor, garantizando que el usuario pueda editar cualquier texto, imagen de fondo o enlace desde la interfaz visual sin depender de código externo.

### 2. Plugins Imprescindibles (`mu-plugins`)
- `centroformacionlaguna-mu-pack.php`: Contiene los hooks y filtros principales del portal rebranded.
- `centroformacionlaguna-plesk-user-query-fix.php`: Soluciona problemas de consulta de usuarios específicos de Plesk y el entorno de base de datos.
- `antigravity-seo-schema.php`: Inyecta automáticamente datos estructurados en formato JSON-LD para SEO Local, configurados para la entidad **Centro de Formación Laguna** en las páginas adecuadas.
- `antigravity-seo.php`: Ajustes generales de cabeceras, títulos y meta-etiquetas optimizadas para la indexación y visibilidad en buscadores.
- `disable-ssl-verify.php`: Desactiva la verificación estricta de SSL en peticiones locales de bucle de retorno para evitar fallos de cURL y Elementor en local.

---

## Instrucciones de Despliegue en Producción (Plesk)

Para subir tus cambios locales a producción en tu panel Plesk:
1. **Tema Hijo**: Sube por FTP o Git del panel Plesk los archivos dentro de `httpdocs/wp-content/themes/centroformacionlaguna-child-theme/` a su respectivo directorio en producción.
2. **MU-Plugins**: Sube todos los archivos dentro de `httpdocs/wp-content/mu-plugins/` al directorio `wp-content/mu-plugins/` de producción.
3. **Imágenes**: Sube las imágenes cargadas a la biblioteca de medios o expórtalas de local si es necesario.
4. **Base de Datos**: Si realizas una importación total de base de datos, asegúrate de reemplazar `http://localhost:8082` por el dominio real de producción de forma segura (ej. utilizando herramientas como WP-CLI `search-replace` o plugins de migración como All-in-One WP Migration).
