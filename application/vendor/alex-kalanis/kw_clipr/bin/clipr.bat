SETLOCAL EnableExtensions
set EXE=php.exe
FOR /F %%x IN ('tasklist /NH /FI "IMAGENAME eq %EXE%"') DO IF %%x == %EXE% goto FOUND

echo PHP required but cannot be found. Aborting.
goto FIN

:FOUND
php.exe clipr.php %*

:FIN
