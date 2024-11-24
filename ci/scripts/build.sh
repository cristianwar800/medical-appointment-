@echo off
setlocal enabledelayedexpansion

echo Building Docker images...

set SERVICES=medical-app appointments-app chatbot-service

for %%s in (%SERVICES%) do (
    echo Building %%s...
    
    REM Build the image
    docker build ^
        --file kubernetes/dockerfiles/%%s.Dockerfile ^
        --tag %DOCKER_USERNAME%/%%s:latest ^
        --tag %DOCKER_USERNAME%/%%s:%GITHUB_SHA% ^
        .
    
    if !errorlevel! neq 0 (
        echo Failed to build %%s
        exit /b !errorlevel!
    )
    
    REM Push to Docker Hub
    docker push %DOCKER_USERNAME%/%%s:latest
    docker push %DOCKER_USERNAME%/%%s:%GITHUB_SHA%
    
    if !errorlevel! neq 0 (
        echo Failed to push %%s
        exit /b !errorlevel!
    )
    
    echo %%s built and pushed successfully
)

echo All builds completed successfully
exit /b 0