@echo off
rem This script will do the following:
rem - check for PHP_COMMAND env, if found, use it.
rem   - if not found detect php, if found use it, otherwise err and terminate

if "%OS%"=="Windows_NT" @setlocal

rem %~dp0 is expanded pathname of the current script under NT
set DEFAULT_CONSOLE_HOME=%~dp0..

goto init
goto cleanup

:init

if "%CONSOLE_HOME%" == "" set CONSOLE_HOME=%DEFAULT_CONSOLE_HOME%
set DEFAULT_CONSOLE_HOME=

if "%PHP_COMMAND%" == "" goto no_phpcommand

goto run
goto cleanup

:run
"%PHP_COMMAND%" -d html_errors=off -qC "%CONSOLE_HOME%\bin\console" %*
goto cleanup

:no_phpcommand
rem PHP_COMMAND environment variable not found, assuming php.exe is on path.
set PHP_COMMAND=php.exe
goto init

:err_home
echo ERROR: Environment var CONSOLE_HOME not set. Please point this
echo variable to your local console installation!
goto cleanup

:cleanup
if "%OS%"=="Windows_NT" @endlocal
rem pause
