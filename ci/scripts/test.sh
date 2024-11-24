@echo off
setlocal enabledelayedexpansion

echo Running CI/CD Tests...

REM Check PHP version
php -v
if !errorlevel! neq 0 (
    echo PHP not found
    exit /b !errorlevel!
)

REM Install dependencies
call composer install --no-interaction --no-progress
if !errorlevel! neq 0 (
    echo Composer install failed
    exit /b !errorlevel!
)

REM Create .env if not exists
if not exist ".env" (
    copy .env.example .env
    php artisan key:generate
    php artisan config:clear
)

REM Run unit tests
if exist "vendor/bin/phpunit" (
    call vendor/bin/phpunit --testdox
    if !errorlevel! neq 0 (
        echo PHPUnit tests failed
        exit /b !errorlevel!
    )
) else (
    echo PHPUnit not found
    exit /b 1
)

REM Check code style
if exist "vendor/bin/phpcs" (
    call vendor/bin/phpcs --standard=PSR12 app/
    if !errorlevel! neq 0 (
        echo Code style check failed
        exit /b !errorlevel!
    )
) else (
    echo PHP CodeSniffer not found
    exit /b 1
)

echo All tests completed successfully
exit /b 0