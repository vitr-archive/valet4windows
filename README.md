# Laravel Valet For Windows [![License](https://poser.pugx.org/larawhale/valet4win/license.svg?format=flat-square)](https://packagist.org/packages/larawhale/valet4win) [![Analytics](https://vitr-analytics.appspot.com/UA-75628680-1/valet4win?flat-gif&useReferer)](https://github.com/vitr/google-analytics-beacon)

Windows version of the legendary [Laravel Valet](https://github.com/laravel/valet)

### WIP (work in progress)
This is a proof of concept. As a GO program, Caddy is a cross platform application, it works the same great on Windows.
I wanted to run Valet on Windows as quick as possible with minimal changes to the original package. It turned out that it's easier to create a new package specifically for Windows, as I'm not using DnsMasq, Brew, etc. I copied the original package in full on my Windows machine and tried to run it, every time I hit an error, I looked into the source code and fixed it, in many cases I just commented a lot of stuff. On the second day I've got MVP and I believe the concept has been proven.
So far, it's straight Caddy plus php, with less magic than on Mac, but it's simpler and more transparent. Let's see how useful this version could be and if it proves itself, we can extend and improve it later on.

### MVP (minimum viable product) has arrived
From v0.5.0 valet4win could be comfortably used with minimum default configuration. I've managed to run it on my Windows10 notebook. There are two manual tasks you have to perform:
1. Run valet4win using start.bat (tip: create a desktop shorcut for it)
2. Run valet scan every time you create a new folder in your ~/Sites, as valet4win uses the old trick with hosts file. It's a small overhead in comparison to running an extra DNS service on your machine.
Not all the valet commands are currently working, but it's something to start with, perhaps, it would be just enough for someone.

### Ground breaking release v0.7.0!!!
From this version you don't have to run manually the start.bat file.
Usual commands just work in git-bash
```
valet start
valet stop
```
In addition to this, ngrok service has been successfully integrated, so, you can use
```
valet share
valet fetch-share-url
```
to expose your local webserver to the Internet.

### Testing
I see the benefits of only integration testing here. I would test each valet command and check the outcomes. Unfortunately, travis doesn't support Windows, so, I perform them manually on Windows machine. Later on, I may try https://ci.appveyor.com/


### Quick How To
!!! *you must have git-bash or something similar, this doesn't work in standard cmd.* !!! bash comes to windows soon, fingers crossed 

* Install php & composer
* composer global require laravel/installer larawhale/valet4win
* mkdir ~/Sites && cd ~/Sites
* laravel new blog
* valet install
* valet park
* valet scan (it updates your hosts file **C:\Windows\System32\drivers\etc\hosts**, so, you have to change its properties to allow full control for current user)
* valet start
* cd blog && valet open (will open http://blog.dev in chrome)

### Advanced How To
#### Install php & composer
As we run php with Caddy in FastCGI mode download **NTS (Non Thread Safe)** version (x86 or x64) from http://windows.php.net/download#php-7.0. Extract downloaded archive to `C:\php`.
Copy `php.ini-development` as `php.ini` and open it in a text editor. Uncomment extension path for Windows
```
 ; Directory in which the loadable extensions (modules) reside.
 ; http://php.net/extension-dir
 ; extension_dir = "./"
 ; On windows:
  extension_dir = "ext"
```  
uncomment required extensions, e.g.  
```
; Windows Extensions
; Note that ODBC support is built in, so no dll is needed for it.
; Note that many DLL files are located in the extensions/ (PHP 4) ext/ (PHP 5+)
; extension folders as well as the separate PECL DLL download (PHP 5+).
; Be sure to appropriately set the extension_dir directive.
;
;extension=php_bz2.dll
extension=php_curl.dll
;extension=php_fileinfo.dll
;extension=php_gd2.dll
;extension=php_gettext.dll
;extension=php_gmp.dll
;extension=php_intl.dll
;extension=php_imap.dll
;extension=php_interbase.dll
;extension=php_ldap.dll
extension=php_mbstring.dll
;extension=php_exif.dll      ; Must be after mbstring as it depends on it
;extension=php_mysqli.dll
;extension=php_oci8_12c.dll  ; Use with Oracle Database 12c Instant Client
extension=php_openssl.dll
;extension=php_pdo_firebird.dll
extension=php_pdo_mysql.dll
;extension=php_pdo_oci.dll
extension=php_pdo_odbc.dll
extension=php_pdo_pgsql.dll
extension=php_pdo_sqlite.dll
;extension=php_pgsql.dll
;extension=php_shmop.dll
```
Keep in mind Laravel's server requirement https://laravel.com/docs/master/installation#server-requirements.

_**Tokenizer PHP Extension** is included by default in all Windows builds_
Add php path (e.g. `C:\php`) to your system path.

Install composer from https://getcomposer.org/download/.
Composer-Setup.exe windows installer does all the work for you, including putting the composer bin folder in your system path, so, later you can easily use commands like `laravel` or `valet`.

#### Install Composer packages
From this point use **git-bash** or or other **bash** compatible terminal, as windows cmd doesn't work for us here. It's too much work to completely rewrite all the valet commands in windows shell and hopefully bash support will be included officially in Windows 10 very soon. 
```
composer global require laravel/installer larawhale/valet4win
```

### Unresolved Issues
* https://github.com/mholt/caddy/issues/732#issuecomment-207819773
Caddy server couldn't be run as a service on Windows (means the cmd is always open), on a flip side could be easily closed)), here is more
https://forum.caddyserver.com/t/requested-plugins-ideas-for-developers/127
https://github.com/mholt/caddy/issues/293
it's requested as a plugin for Caddy, hopefully they implement this soon,
but my workaround with an extra cmd window works just fine.
* Rescan parked folders manually after adding new subfolder(s) (could be resolved with some sort of filesystem watcher, e.g. node.js)
* Working with symlinks on Windows requires run git-bash as administrator

### Roadmap
- [ ] Combine `scan` with `park, forget, link, unlink`
- [ ] Implement the same tests as for Mac and maybe some more
- [x] Move caddy exec to bin, Caddyfile config to ~/.valet
- [ ] Port all original mac Valet commands
    - [x] domain 
    - [x] fetch-share-url 
    - [x] forget 
    - [x] help 
    - [x] install 
    - [x] link (requires run git-bash as administrator)
    - [x] links 
    - [x] list 
    - [x] logs 
    - [x] on-latest-version 
    - [x] open 
    - [x] park 
    - [x] paths 
    - [ ] restart 
    - [x] secure (requires manual restart of Caddy, start.bat), to get rid of in-browser warning you have to manually install certificate (double click on ~\.valet\Certificates\blog.dev.crt) 
    - [x] share 
    - [x] start      
    - [x] stop 
    - [ ] uninstall 
    - [x] unlink 
    - [x] unsecure 
    - [x] which 
- [ ] Clean up all the OS X leftovers
