@echo off
title Restablecer Base de Datos - Centro Formacion Laguna - Anti-Gravity
cd /d "%~dp0"

echo ====================================================
echo   RESTABLECIENDO E IMPORTANDO BASE DE DATOS ORIGINAL
echo ====================================================
echo.
echo Este script borrara la base de datos local vacia y volvera
echo a importar la copia de produccion (CentroFormacionLaguna.sql).
echo.
echo CUIDADO: Esto reemplazara cualquier cambio local de base de datos.
echo.
set /p confirmar="¿Estas seguro de que deseas continuar? (S/N): "
if /i "%confirmar%" neq "S" (
    echo Operacion cancelada.
    echo.
    pause
    exit /b
)

echo.
:: Comprobar si Docker se está ejecutando
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Docker no esta iniciado. 
    echo Por favor, abre "Docker Desktop" en tu PC y espera a que inicie.
    echo Luego, vuelve a ejecutar este archivo.
    echo.
    pause
    exit /b
)

echo Deteniendo y limpiando volumenes de base de datos anteriores...
docker compose down -v

echo.
echo Levantando contenedores e iniciando la importacion...
docker compose up -d

echo.
echo ====================================================
echo   ¡PROCESO EN CURSO!
echo ====================================================
echo.
echo Se estan levantando los contenedores.
echo MariaDB esta importando la base de datos de produccion en segundo plano.
echo.
echo IMPORTANTE: Espera unos 15-20 segundos antes de abrir la web
echo para dar tiempo a que termine la importacion de la base de datos.
echo.
echo Tu web estara disponible en: http://localhost:8082
echo.
pause
