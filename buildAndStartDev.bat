@echo off

echo [CS4.0] Checking Dependencies . . .

docker --version >nul 2>nul
if %errorlevel%==0 goto continuedockerv
echo [CS4.0] Docker is not installed. Press any key to stop . . .
start "" https://www.docker.com/products/docker-desktop/
pause >nul
exit /b 1
:continuedockerv


docker-compose ls >nul 2>nul
if %errorlevel%==0 goto continuedocker
echo [CS4.0] Docker Engine is not running. Waiting . . .
:waitloopdocker
timeout /t 10
docker-compose ls >nul 2>nul
if %errorlevel%==1 goto waitloopdocker
:continuedocker


php -v >nul 2>nul
if %errorlevel%==0 goto continuephp
echo [CS4.0] PHP is not installed. After installation make sure you include all necessary extensions in php.ini like pdo_mysql, fileinfo, ...
echo [CS4.0] Press any key to stop . . .
start "" https://www.php.net/downloads
pause >nul
exit /b 1
:continuephp


node -v >nul 2>nul
if %errorlevel%==0 goto continuenpm
echo [CS4.0] NPM is not installed. Press any key to stop . . .
start "" https://nodejs.org/en/download/
pause >nul
exit /b 1
:continuenpm


WHERE composer >nul 2>nul
if %errorlevel%==0 goto continuecomposer
echo [CS4.0] PHP Composer is not installed. Press any key to stop . . .
start "" https://getcomposer.org/download/
pause >nul
exit /b 1
:continuecomposer


SET /P AREYOUSURE=[CS4.0] Do you want to check codestyle before starting the system? (Y/[N])?
IF /I "%AREYOUSURE%" NEQ "Y" GOTO continuecodestyle
cd src/
call .\vendor\bin\pint
echo Finished codestyle optimization. Press SPACE to continue . . .
pause >nul
cd ..
:continuecodestyle


echo [CS4.0] Building Project . . .
docker-compose build
npm install

echo [CS4.0] Booting DB . . .
call docker-compose -f docker-compose-dev.yml up -d 

cd src/

echo [CS4.0] Installing composer . . .
call composer install

echo [CS4.0] Init Project Files . . .
if not exist .env (
    echo [CS4.0] .env file missing! Creating . . .
    copy .env.example .env
    call php artisan key:generate
)

echo [CS4.0] Starting external systems . . .
pushd %~dp0
start cmd /k "cd src & php artisan serve"
start cmd /k "cd src & npm run dev"


echo [CS4.0] Initializing and filling database. This may take a while . . .
cd src/
timeout /t 1
:waitloopdb
php artisan db:show >nul 2>nul
if %errorlevel%==0 goto continuedb
echo [CS4.0] Database is not running or not reachable (.env correct? ). Waiting . . .
timeout /t 3
goto waitloopdb
:continuedb
call php artisan migrate:refresh --seed


echo [CS4.0] Clearing cache and old files . . .
call php artisan cache:clear
call php artisan view:clear
call php artisan config:clear
call php artisan route:clear
for /r "./storage/app/graphs" %%f in (*.json) do (
    echo Deleting "%%f"
    del "%%f"
)
for /r "./storage/app/reports" %%f in (*.json) do (
    echo Deleting "%%f"
    del "%%f"
)

echo [CS4.0] Ready - System should be running now!

echo [CS4.0] Opening Website in browser . . .
start "" http://localhost:8000
echo [CS4.0] Opening PhpMyAdmin in browser . . .
start "" http://localhost:8080

echo Druecke LEERTASTE um die Serverumgebung zu beenden und alle Container zu entfernen.
pause >nul
docker-compose -f ../docker-compose-dev.yml down