# Laravel Valet For Windows [![Latest Stable Version](https://poser.pugx.org/vitr/valet4windows/v/stable?format=flat-square)](https://packagist.org/packages/vitr/valet4windows) [![License](https://poser.pugx.org/vitr/valet4windows/license.svg?format=flat-square)](https://packagist.org/packages/vitr/valet4windows) [![Analytics](https://vitr-analytics.appspot.com/UA-75628680-1/valet4windows?flat&useReferer)](https://github.com/vitr/google-analytics-beacon)

![Laravel Valet for Windows](https://cloud.githubusercontent.com/assets/2770290/17275120/52b52a80-5740-11e6-9e5a-22c4dfa5a977.png)

## Introduction
This is Windows version of [Laravel Valet](https://github.com/laravel/valet). Valet is a Laravel development environment for minimalists. This Windows version brings even less software than Valet for Mac and you still can share your sites publicly using local tunnels.

Laravel Valet for Windows configures your PC to run [Caddy](https://caddyserver.com/) on demand. Then, using `c:\Windows\System32\drivers\etc\hosts` file, Valet proxies all requests on the `*.dev` domain to point to sites installed on your local machine.

In other words, a blazing fast Laravel development environment that uses roughly 7mb of RAM(???have to double check this???). Valet isn't a complete replacement for Vagrant or Homestead, but provides a great alternative if you want flexible basics, prefer extreme speed, or are working on a machine with a limited amount of RAM.

Please, keep in mind, an arbitrary php application won't work in Valet, you need to support them via special drivers. Obviously [Laravel](https://laravel.com/) is supported, as well, as many others popular php headliners, like [Symfony](https://symfony.com/), [WordPress](https://wordpress.org/), [Joomla](https://www.joomla.org/), etc. See the full list [here](#list-of-supported-applications-and-frameworks)

## Important Notes
- Set **C:\Windows\System32\drivers\etc\hosts** file permissions to allow full control for current user/administrator 
- **_Windows 64-bit_** is supported (if anyone still needs 32-bit, please, make an issue)
- Run **git-bash** as Administrator, as only Administrator can handle symlinks on Windows


## Quick How To
This will set up and run a new Laravel application named `blog`, accessible on localhost http://blog.dev/. Only **php** and **composer** are required to run Valet for Windows. See [advanced how to](#advanced-how-to) if you don't have them yet.

**You must use git-bash or similar shell.** This doesn't work in standard Windows cmd, native bash will soon come to Windows, _fingers crossed_. 
```
composer global require laravel/installer vitr/valet4windows
mkdir ~/Sites && cd ~/Sites
laravel new blog
valet install
valet park
valet scan 
valet start
cd blog && valet open 
```
## Advanced How To
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
composer global require laravel/installer vitr/valet4windows
```
#### Updating your `hosts` file
```
valet scan
```
it updates your hosts file **C:\Windows\System32\drivers\etc\hosts**, so,
you have to change its properties to allow full control for current user.

#### Running Valet
If you're on Windows there is a chance that your ports 80 and 443 are already occupied by ISS or Skype.
Read more how to disable ISS here http://stackoverflow.com/questions/30901434/iis-manager-in-windows-10
and how to fix Skype here http://stackoverflow.com/questions/22994888/why-skype-using-http-or-https-ports-80-and-443  

#### Open Laravel site 
cd blog && valet open 
(will open http://blog.dev in chrome)

## List of supported applications and frameworks
- [Laravel](https://laravel.com/)
- [Symfony](https://symfony.com/) 
- [WordPress](https://wordpress.org/) 
- [Joomla](https://www.joomla.org/)
- Bedrock
- Cake
- Craft
- Jigsaw
- Katana
- Kirby
- Sculpin
- Statamic




## Unresolved Issues
* https://github.com/mholt/caddy/issues/732#issuecomment-207819773
Caddy server couldn't be run as a service on Windows (means the cmd is always open), on a flip side could be easily closed)), here is more
https://forum.caddyserver.com/t/requested-plugins-ideas-for-developers/127
https://github.com/mholt/caddy/issues/293
it's requested as a plugin for Caddy, hopefully they implement this soon,
but my workaround with an extra cmd window works just fine.
* Rescan parked folders manually after adding new subfolder(s) (could be resolved with some sort of filesystem watcher, e.g. node.js)
* Working with symlinks on Windows requires run git-bash as administrator

## Testing
I see the benefits of only integration testing here. I would test each valet command and check the outcomes. Unfortunately, travis doesn't support Windows, so, I perform them manually on Windows machine. Later on, I may try https://ci.appveyor.com/

## Roadmap
- [ ] demo how to install a certificate (so much fun:)
- [x] fix larawhale names in readme
- [ ] add actual tests
- [ ] Combine `scan` with `park, forget, link, unlink`
- [ ] Implement the same tests as for Mac and maybe some more
- [x] Move caddy exec to bin, Caddyfile config to ~/.valet
- [ ] Clean up all the OS X leftovers
- [x] update caddyserver (Latest release  v0.9.0), so broken((, filled the issue here https://github.com/mholt/caddy/issues/986
- [ ] update valet drivers
- [x] move the history into a standalone history file (see CHANGELOG.md)
- [x] Port all original mac Valet commands
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
    - [x] restart 
    - [x] secure, to get rid of in-browser warning you have to manually install certificate (double click on ~\.valet\Certificates\blog.dev.crt and install it in the root) 
    - [x] share 
    - [x] start      
    - [x] stop 
    - [x] uninstall 
    - [x] unlink 
    - [x] unsecure 
    - [x] which 
