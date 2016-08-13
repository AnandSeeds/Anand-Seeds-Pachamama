echo off
set VerFIX=0.30
cls
title "FixUSB Ver. %VerFIX% por MiltonMO"
echo.
color 8E
echo.
echo ********************* FixUSB Ver. %VerFIX% por MiltonMO **********************
echo **********************************************************************
echo ** Lista de comandos que te ayuda a:                                **
echo ** + DESOCULTAr carpetas y archivos                                 **
echo ** + ELIMINAr accesos directos (creados por algun Virus/Malware).   **
echo ** + ELIMINAr Servieca, Microsoft, COOL, kroover, Recycler y otros  **
echo **                         Virus/Malwares. ... puedes agregar mas.  **
echo ** + PROTEGEr Unidades Removibles contra la infeccion (en windows)  ** 
echo **                                          de este tipo de virus.  **
echo ** *******************************************************************
echo ** Herramientas Externas Usadas:                                    **
echo ** + FileASSASSIN  http://es.malwarebytes.org/products/fileassassin **
echo ** + MXOne   (Antivirus portatil)  http://www.mxone.net             **
echo ** Estas Herramientas deben estar dentro de la Carpeta FixUSB       **
echo ** *******************************************************************
echo ****** Atte. MiltonMO *********** http://cocolibre.blogspot.mx *******
echo.
echo _________________________________________________________
REM determinando version de Windows
for /f "tokens=5-6 delims=. " %%i in ('ver') do ( set VERSION=%%i.%%j )
if "%VerW%" == "5.0" echo Corriendo sobre WINDOWS 2000
if "%VerW%" == "5.00" echo Corriendo sobre WINDOWS 2000
if "%VerW%" == "5.1" echo Corriendo sobre WINDOWS XP
if "%VerW%" == "5.1 " echo Corriendo sobre WINDOWS XP
if "%VerW%" == "5.2" echo Corriendo sobre WINDOWS Server 2003
if "%VerW%" == "6.0" echo Corriendo sobre WINDOWS Vista
if "%VerW%" == "6.1" echo Corriendo sobre WINDOWS 7
if "%VerW%" == "6.2" echo Corriendo sobre WINDOWS 8
if "%VerW%" == "6.3" echo Corriendo sobre WINDOWS 8.1
echo _________________________________________________________
echo.
echo.
echo ***  A C C I O N E S    D E    R E S T A U R A C I O N ***
echo "Borrando Accesos Directos"
if exist *.lnk attrib -h -s -r *.lnk
if exist *.lnk del /q *.lnk
echo _________________________________________________________
echo "Desocultando carpetas y archivos"
echo "Este proceso puede tardar mucho, depende de la cantidad de archivos"
echo "y de  la velocidad de lectura de su dispositivo"
echo "--- Ejem: 7.44GB con 6446 archivos en USB ver. 2.0, Aprox. 15 Minutos ---"
echo "... Trabajando ..."
echo "=== attrib -h -s -r * /d /s ==="
if "%VerW%" LEQ 5.2 attrib -h -s -r * /d /s
if "%VerW%" GEQ 6.0 attrib -h -s -r -i * /d /s
REM http://ss64.com/nt/chcp.html
chcp 1251
if exist " " ren " " R3CUP3RAD0S
if exist ".Trashes" ren ".Trashes" R3CUP3RA2
REM http://ss64.com/nt/chcp.html
chcp 850
REM if exist .Trashes\NUL ren .Trashes Recuperad0s
echo _________________________________________________________
echo "Borrando archivo autorun.inf (en caso de existir) en C,D,E, ..."
for /f "skip=1" %%x in ('wmic logicaldisk get caption') do ( if exist %%x\autorun.inf FixUSB\FileASSASSIN.exe /assassinate /silent %%x\autorun.inf )
echo "Eliminado Andromeda y parecidos de la USB..."
del /f *.ini *.init *.fat *.nil 2>NUL
del /f *.vbs *.vbe *.tmp *.js *.db *.WsF  2>NUL
echo.
echo _________________________________________________________
echo _________________________________________________________
echo.
echo.
echo ***  A C C I O N E S    D E    P R O T E C C I O N ***
echo "Protegiendo C,D,E, ..."
for /f "skip=1" %%x in ('wmic logicaldisk get caption') do ( mkdir %%x\autorun.inf )
chcp 1251
echo " ... Alto Malwares ... \n ... Lugar ocupado ..." > ".Trashes"
attrib +h +s +r ".Trashes"
echo " ... Alto Malwares ... \n ... Lugar ocupado ..." > " "
attrib +h +s +r " "
chcp 850
echo.
echo _________________________________________________________
echo "... Copiando este archivo a la Carpeta autorun.inf"
for /f "skip=1" %%x in ('wmic logicaldisk get caption') do ( copy %0 autorun.inf\FixUSB-v%VerW%.bat )
copy %0 autorun.inf\FixUSB.bat
copy %0 autorun.inf\
echo _________________________________________________________
echo "Protegiendo ..."
IF "%VerW%" LSS 6.0 (attrib +h +s +r autorun.inf /s /d) ELSE attrib +h +s +r +i autorun.inf /s /d
echo _________________________________________________________
echo _________________________________________________________

del /s /q %systemroot%\temp\*.*
del /s /q %temp%\*.*
rmdir /s /q %temp%\*

echo.
echo.
echo ***  A C C I O N E S    D E    D E S I N F E C C I O N ***
echo "Borrando malware Servieca.vbs (en caso de existir)."
echo "Deteniendo ejecucion de Servieca (wscript)"
echo "== taskkill /f /im wscript.exe =="
taskkill /f /im wscript.exe

if exist servieca.vbs del /q servieca.vbs
if exist *.vbs FixUSB\FileASSASSIN.exe /assassinate /silent servieca.vbs

if exist "%TEMP%\servieca.vbs" del /q "%TEMP%\servieca.vbs"
if exist "%TEMP%\servieca.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %TEMP%\servieca.vbs

if exist "%TEMP%\servieca.vbs" del /q "%TEMP%\servieca.vbs"
if exist "%TEMP%\servieca.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %TEMP%\servieca.vbs

if exist "%USERPROFILE%\Start Menu\Programs\Startup\Servieca.vbs" del /q "%USERPROFILE%\Start Menu\Programs\Startup\Servieca.vbs"
if exist "%USERPROFILE%\Start Menu\Programs\Startup\Servieca.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent %USERPROFILE%\Start Menu\Programs\Startup\Servieca.vbs
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\Servieca.vbs" del /q "%USERPROFILE%\Menú Inicio\Programas\Inicio\Servieca.vbs"
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\Servieca.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent %USERPROFILE%\Menú Inicio\Programas\Inicio\Servieca.vbs
IF "%VerW%" GEQ 6.0 (del /q "%USERPROFILE%\AppData\Roaming\Microsoft\Windows\Start Menu\Programs\Servieca.vbs") ELSE del /q "%USERPROFILE%\Start Menu\Programs\Startup\Servieca.vbs"

reg delete HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run\ /v servieca /f
reg delete HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run\ /v servieca /f

echo.
echo.
color 4E
echo "Burcar/Elimnar SERVIECA en: "
cd > Ruta.txt
set /P Ruta=<Ruta.txt
echo " [1] Ruta Actual (%Ruta%) "
echo " [2] Windows -Puede tardar mucho- "
echo " [3] NADA "
set /p val=
if %val% EQU 1 goto BuscaServiecaAqui
if %val% EQU 2 goto BuscaServiecaW
if %val% GEQ 3 goto NoBuscarServieca
:BuscaServiecaAqui
echo ... BUSCANDO SERVIECA ...
REM Buscar SERVIECA en ruta actual
del /q Servieca.vbs /s
goto NoBuscarServieca
:BuscaServiecaW
echo ... BUSCANDO SERVIECA ...
REM Buscar SERVIECA en Windows:
pushd %SYSTEMROOT%\..
del /q Servieca.vbs /s
popd
:NoBuscarServieca
color 8E

echo.
echo _________________________________________________________
echo "Borrando MicroSoft.vbs (en caso de existir), Malware parecido a Servieca"
echo "Deteniendo ejecucion de Microsoft (wscript)"
echo "=== taskkill /f /im wscript.exe ==="
taskkill /f /im wscript.exe
echo "=== del /q microsoft.vbs ==="

if exist microsoft.vbs del /q microsoft.vbs
if exist microsoft.vbs FixUSB\FileASSASSIN.exe /assassinate /silent microsoft.vbs

if exist "%USERPROFILE%\AppData\Roaming\microsoft.vbs" del /q "%USERPROFILE%\AppData\Roaming\microsoft.vbs"
if exist "%USERPROFILE%\AppData\Roaming\microsoft.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\AppData\Roaming\microsoft.vbs

if exist "%USERPROFILE%\Start Menu\Programs\Startup\Microsoft.vbs" del /q "%USERPROFILE%\Start Menu\Programs\Startup\Microsoft.vbs"
if exist "%USERPROFILE%\Start Menu\Programs\Startup\Microsoft.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Start Menu\Programs\Startup\Microsoft.vbs
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\Microsoft.vbs" del /q "%USERPROFILE%\Menú Inicio\Programas\Inicio\Microsoft.vbs"
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\Microsoft.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Menú Inicio\Programas\Inicio\Microsoft.vbs

reg delete HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run\ /v microsoft /f
reg delete HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run\ /v microsoft /f

echo.
echo.
color 4E
echo " Burcar/Elimnar MICROSOFT en: "
echo " [1] Ruta Actual (%Ruta%) "
echo " [2] Windows -Puede tardar mucho- "
echo " [3] NADA "
set /p val=
if %val% EQU 1 goto BuscaMICROSOFTAqui
if %val% EQU 2 goto BuscaMICROSOFTW
if %val% GEQ 3 goto NoBuscarMICROSOFT
:BuscaMICROSOFTAqui
echo ... BUSCANDO MICROSOFT ...
del /q Microsoft.vbs /s
goto NoBuscarMICROSOFT
:BuscaMICROSOFTW
echo ... BUSCANDO MICROSOFT ...
pushd %SYSTEMROOT%\..
del /q Microsoft.vbs /s
popd
:NoBuscarMICROSOFT
color 8E

echo.
echo _________________________________________________________
echo "Borrando COOL.vbs (en caso de existir), Malware parecido a Servieca"
echo "Deteniendo ejecucion de COOL (wscript)"
taskkill /f /im cool.exe
REM Elinidados algunos if creo que estan de mas.
if exist microsoft.vbs FixUSB\FileASSASSIN.exe /assassinate /silent microsoft.vbs
if exist "%USERPROFILE%\AppData\Roaming\cool.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\AppData\Roaming\cool.vbs
if exist "%USERPROFILE%\Start Menu\Programs\Startup\cool.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Start Menu\Programs\Startup\cool.vbs
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\cool.vbs" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Menú Inicio\Programas\Inicio\cool.vbs
reg delete HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run\ /v cool /f
reg delete HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run\ /v cool /f

echo.
echo.
color 4E
echo " Burcar/Elimnar COOL en: "
echo " [1] Ruta Actual (%Ruta%) "
echo " [2] Windows -Puede tardar mucho- "
echo " [3] NADA "
set /p val=
if %val% EQU 1 goto BuscaCOOLaqui
if %val% EQU 2 goto BuscaCOOLW
if %val% GEQ 3 goto NoBuscarCOOL
:BuscaCOOLaqui
echo ... BUSCANDO COOL ...
del /q cool.vbs /s
goto NoBuscarCOOL
:BuscaCOOLW
echo ... BUSCANDO COOL ...
pushd %SYSTEMROOT%\..
del /q cool.vbs /s
popd
:NoBuscarCOOL
color 8E

echo.
echo _________________________________________________________
echo "Borrando SuSoft.vbs (en caso de existir), viejo Malware"
echo "Deteniendo ejecucion de SuSoft (susoft o musica)"
taskkill /f /im susoft.exe
taskkill /f /im musica.exe

if exist susoft.exe del /q susoft.exe
if exist musica.exe del /q musica.exe
if exist susoft.exe FixUSB\FileASSASSIN.exe /assassinate /silent susoft.exe
if exist musica.exe FixUSB\FileASSASSIN.exe /assassinate /silent musica.exe

if exist "%USERPROFILE%\Escritorio\susoft.exe" del /q "%USERPROFILE%\Escritorio\susoft.exe"
if exist "%USERPROFILE%\Escritorio\musica.exe" del /q "%USERPROFILE%\Escritorio\musica.exe"
if exist "%USERPROFILE%\Desktop\susoft.exe" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Desktop\susoft.exe
if exist "%USERPROFILE%\Desktop\musica.exe" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Desktop\musica.exe

if exist "%USERPROFILE%\Start Menu\Programs\Startup\susoft.exe" del /q "%USERPROFILE%\Start Menu\Programs\Startup\susoft.exe"
if exist "%USERPROFILE%\Start Menu\Programs\Startup\susoft.exe" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Start Menu\Programs\Startup\susoft.exe
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\susoft.exe" del /q "%USERPROFILE%\Menú Inicio\Programas\Inicio\susoft.exe"
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\susoft.exe" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Menú Inicio\Programas\Inicio\susoft.exe

if exist "%USERPROFILE%\Start Menu\Programs\Startup\musica.exe" del /q "%USERPROFILE%\Start Menu\Programs\Startup\musica.exe"
if exist "%USERPROFILE%\Start Menu\Programs\Startup\musica.exe" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Start Menu\Programs\Startup\musica.exe
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\musica.exe" del /q "%USERPROFILE%\Menú Inicio\Programas\Inicio\musica.exe"
if exist "%USERPROFILE%\Menú Inicio\Programas\Inicio\musica.exe" FixUSB\FileASSASSIN.exe /assassinate /silent  %USERPROFILE%\Menú Inicio\Programas\Inicio\musica.exe

reg delete HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run\ /v susoft /f
reg delete HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run\ /v susoft /f
echo.

reg delete HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run\ /v musica /f
reg delete HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run\ /v musica /f

echo.
echo.
color 4E
echo " Burcar/Elimnar SUSOFT.exe y MUSICA.exe en: "
echo " [1] Ruta Actual (%Ruta%) "
echo " [2] Windows -Puede tardar mucho- "
echo " [3] NADA "
set /p val=
if %val% EQU 1 goto BuscaSyMaqui
if %val% EQU 2 goto BuscaSyMW
if %val% GEQ 3 goto NoBuscarSyM
:BuscaSyMaqui
echo ... BUSCANDO SUSOFT y MUSICA ...
del /q susoft.exe /s
del /q musica.exe /s
goto NoBuscarSyM
:BuscaSyMW
echo ... BUSCANDO SUSOFT y MUSICA ...
pushd %SYSTEMROOT%\..
del /q susoft.exe /s
del /q musica.exe /s
popd
:NoBuscarSyM
color 8E

echo.
echo _________________________________________________________
echo "Borrando kroover (en caso de existir), este es un Malware"
echo "Deteniendo ejecucion de kroover"
taskkill /im kroover.exe /F /T
echo "=== Borrando kroover.exe ==="
if exist attrib -r "%SYSTEMROOT%\System32\drivers\kroover.exe" attrib -r "%SYSTEMROOT%\System32\drivers\kroover.exe"
if exist del /q "%SYSTEMROOT%\System32\drivers\kroover.exe" del /q "%SYSTEMROOT%\System32\drivers\kroover.exe"
echo.
echo _________________________________________________________
echo "Borrando FPUS (en caso de existir FlashPlayerUpdateService.exe)[Troyano]"
echo "Deteniendo ejecucion de kroover"
taskkill /im FlashPlayerUpdateService.exe /F /T
if exist "%SYSTEMROOT%\System32\Macromed\FlashPlayerUpdateService.exe" attrib -r "%SYSTEMROOT%\System32\Macromed\FlashPlayerUpdateService.exe"
if exist "%SYSTEMROOT%\System32\Macromed\FlashPlayerUpdateService.exe" del /q "%SYSTEMROOT%\System32\Macromed\FlashPlayerUpdateService.exe"
if exist "%SYSTEMROOT%\System32\Config\FlashPlayerUpdateService.exe" attrib -r "%SYSTEMROOT%\System32\Config\FlashPlayerUpdateService.exe"
if exist "%SYSTEMROOT%\System32\Config\FlashPlayerUpdateService.exe" del /q "%SYSTEMROOT%\System32\Config\FlashPlayerUpdateService.exe"
if exist "%SYSTEMROOT%\FlashPlayerUpdateService.exe" attrib -r "%SYSTEMROOT%\FlashPlayerUpdateService.exe"
if exist "%SYSTEMROOT%\FlashPlayerUpdateService.exe" del /q "%SYSTEMROOT%\FlashPlayerUpdateService.exe"
echo.
echo _________________________________________________________
echo "Borrando Recycler (en caso de existir y sea posible)"
attrib -r RECYCLER
rmdir /s /q RECYCLER
echo "Borrando carpeta ICE (creada por un virus) "
attrib -r ice
rmdir /s /q ice

echo "Borrando diedioh (en caso de existir), este es otro Malware"
echo "=== attrib -r diedioh.exe ==="
attrib -r diedioh.exe
echo "=== del /q diedioh.exe ==="
del /q diedioh.exe
echo "=== attrib -r diedioh.scr ==="
attrib -r diedioh.scr
echo "=== del /q diedioh.scr ==="
del /q diedioh.scr
echo.
echo "Borrando zPharaoh (en caso de existir), este es otro Malware"
echo "=== attrib -r propagador.exe ==="
attrib -r propagador.exe
echo "=== del /q propagador.exe ==="
del /q propagador.exe
echo "=== attrib -r zPharaoh.exe ==="
attrib -r zPharaoh.exe
echo "=== del /q zPharaoh.exe ==="
del /q zPharaoh.exe
echo _________________________________________________________

echo _________________________________________________________
echo "Borrando Otros Malwares (en caso de existir)"
REM  " EDITA ESTE ARCHIVO Y ESCRIBE AQUI TU LISTA DE MALWARES A BORRAR "
REM  " ATTRIB -R MALWARE.EXE "
REM  " DEL -Q MALWARE.EXE  MALWARE.vbs MALWARE.js ... MALWARE.etc"

attrib -r g6jk.exe
del /q g6jk.exe

attrib -r thumbs_cache/instalador.exe
del thumbs_cache/instalador.exe
echo _________________________________________________________

echo.
echo "A continuacion se muestra una lista POSIBLES ARCHIVOS SOSPECHOSOS"
echo "**** VEFIRICA que CONOCES LOS siguientes ARCHIVOS (EXE's, VB*'s, JS's y WSF's) ****"
echo "==== PRESIONA cualquier TECLA para CONTINUA y Mostrar (en caso de Existir) ===="
pause > NUL
dir *.exe /b /w /s
dir *.vbs /b /w /s
dir *.vbe /b /w /s
dir *.js /b /w /s
dir *.wsf /b /w /s
echo " PRESIONA cualquier TECLA para CONTINUAR "
pause > NUL
echo _________________________________________________________
echo _________________________________________________________
echo.
echo.
REM "Personalizando carpetas FixUSB y autorun.inf
copy FixUSB\FixUSB.ico %USERPROFILE%\
IF "%VerW%" LSS 6.0 (attrib +h +s +r %USERPROFILE%\FixUSB.ico) ELSE attrib +h +s +r +i %USERPROFILE%\FixUSB.ico
copy FixUSB\desktop.ini c:\autorun.inf\
copy FixUSB\desktop.ini autorun.inf\
echo "Ejecutando MX One Antivirus"
echo "Dirijete a Escanear/Analisis Personalizado"
echo "y Seleciona esta Memoria"
if exist FixUSB\mog.exe call FixUSB\mog.exe else call FixUSB\MXOne.exe
if exist FixUSB\update.exe call FixUSB\update.exe
echo _________________________________________________________ 
del /f Ruta.txt
echo.
echo.
echo ".:::: Fin de lista de tareas ::::."
echo.
echo.
echo "visita -->>  http://cocolibre.blogspot.com"
start http://cocolibre.blogspot.com/2013/08/fixusb-desocultar-carpetasarchivos-en.html
echo.
echo.
echo "FIN de TAREAS"
pause > NUL
exit