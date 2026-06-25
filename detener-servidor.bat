@echo off
title Detener Centro Formacion Laguna - Anti-Gravity
cd /d "%~dp0"

echo ====================================================
echo    DETENIENDO CONTENEDORES (CENTRO FORMACION LAGUNA)
echo ====================================================
echo.

docker compose down

echo.
echo ====================================================
echo    ENTORNO DETENIDO CORRECTAMENTE
echo ====================================================
echo.
pause
