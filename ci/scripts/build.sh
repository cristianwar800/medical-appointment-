@echo off
setlocal enabledelayedexpansion

echo Building Docker images...

set SERVICES=medical-app appointments-app chatbot-service

for %%s in (%SERVICES%) do (
    echo Building %%s...
    docker build -t %%s -f kubernetes/dockerfiles/%%s.Dockerfile .
    if !errorlevel! neq 0 (
        echo Error building %%s
        exit /b !errorlevel!
    )
)