@echo off
setlocal enabledelayedexpansion

echo Deploying to Kubernetes...

:: Verificar si kubectl está instalado
where kubectl >nul 2>nul
if !errorlevel! neq 0 (
    echo kubectl no encontrado
    exit /b 1
)

:: Aplicar configuraciones
kubectl apply -f kubernetes/configs/
if !errorlevel! neq 0 (
    echo Error aplicando configuraciones
    exit /b !errorlevel!
)

:: Verificar deployments
kubectl get deployments -n default
if !errorlevel! neq 0 (
    echo Error verificando deployments
    exit /b !errorlevel!
)