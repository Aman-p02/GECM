@echo off
title GitHub Push - GECM

if not "%~1"=="" (
    set "commit_msg=%*"
) else (
    echo ===================================================
    echo             GECM - GIT PUSH SCRIPT
    echo ===================================================
    echo.
    git status
    echo.
    set /p commit_msg="Enter commit message (Press Enter for auto-message): "
)

if "%commit_msg%"=="" set commit_msg=Update project changes (%date% %time%)

echo.
echo [+] Staging changes (git add -A)...
git add -A

echo [+] Committing: "%commit_msg%"
git commit -m "%commit_msg%"

echo [+] Pushing to origin main...
git push origin main

echo.
if %errorlevel% equ 0 (
    echo ===================================================
    echo    SUCCESS: Changes pushed to GitHub successfully!
    echo ===================================================
) else (
    echo ===================================================
    echo    ERROR: Push failed! Please check error above.
    echo ===================================================
)
echo.
if "%~1"=="" pause
