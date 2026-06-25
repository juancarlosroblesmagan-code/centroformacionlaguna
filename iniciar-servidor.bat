@echo off
title Encediendo Servidor Anti-Gravity - Centro Formacion Laguna
echo Levantando los contenedores locales de Docker...
cd /d "%~dp0"
docker compose up -d
echo ==========================================
echo   PROYECTO SEGURO LEVANTADO CON EXITO
echo   Tu web esta disponible en: http://localhost:8082
echo ==========================================
pause
