@echo off
title GitHub Pull - GECM
echo ===================================================
echo             GECM - GIT PULL SCRIPT
echo ===================================================
echo.

echo [+] Pulling latest changes from origin main...
git pull origin main

echo.
if %errorlevel% equ 0 (
    echo ===================================================
    echo    SUCCESS: Project updated from GitHub!
    echo ===================================================
) else (
    echo ===================================================
    echo    ERROR: Pull failed! Please check for conflicts.
    echo ===================================================
)
echo.
pause
