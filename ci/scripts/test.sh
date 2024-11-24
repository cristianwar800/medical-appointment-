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
composer install --no-interaction
if !errorlevel! neq 0 (
    echo Composer install failed
    exit /b !errorlevel!
)

REM Run unit tests
if exist "vendor/bin/phpunit" (
    vendor/bin/phpunit --testdox
) else (
    echo PHPUnit not found
    exit /b 1
)

REM Check code style
if exist "vendor/bin/phpcs" (
    vendor/bin/phpcs --standard=PSR12 app/
) else (
    echo PHP CodeSniffer not found
    exit /b 1
)

echo All tests completed successfully
exit /b 0