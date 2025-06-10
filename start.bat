@echo off
title E-ABSENSI - Server Lokal
echo Menjalankan E-ABSENSI di http://localhost:8000

REM Buka browser default ke alamat lokal
start http://localhost:8000

REM Jalankan server PHP
php\php.exe -S localhost:8000 -t public

pause