# Laravel Valet For Windows [![License](https://poser.pugx.org/larawhale/valet4win/license.svg?format=flat-square)](https://packagist.org/packages/larawhale/valet4win) [![Analytics](https://vitr-analytics.appspot.com/UA-75628680-1/valet4win?flat-gif&useReferer)](https://github.com/vitr/google-analytics-beacon)

Windows version of the legendary [Laravel Valet](https://github.com/laravel/valet)

### WIP (work in progress)
This is a proof of concept. As a GO program, Caddy is a cross platform application, it works the same great on Windows.
I wanted to run Valet on Windows as quick as possible with minimal changes to the original package. It turned out that it's easier to create a new package specifically for Windows, as I'm not using DnsMasq, Brew, etc. I copied the original package in full on my Windows machine and tried to run it, every time I hit an error, I looked into the source code and fix it, in many cases I just commented a lot of stuff. On the second day I've got MVP and I believe the concept has been proven.
So far, it's straight Caddy plus php, with less magic than on Mac, but it's simpler and more transparent. Let's see how useful this version could be and if it proves itself, we can extend and improve it later on.

### MVP (minimum viable product) has arrived
From v0.5.0 valet4win could be comfortably used with minimum default configuration. I've managed to run it on my Windows10 notebook. There are two manual tasks you have to perform:  
1. Run valet4win using start.bat (tip: create a desktop shorcut for it)  
2. Run valet scan every time you create a new folder in your ~/Sites, as valet4win uses the old trick with hosts file. It's a small overhead in comparison to running an extra DNS service on your machine.  
Not all the valet commands are currently working, but it's something to start with, perhaps, it would be just enough for someone.


### Quick How To
!!! *you must have git-bash or something similar, this doesn't work in standard cmd.* !!! bash comes to windows soon, fingers crossed 

* Install php & composer
* composer global require laravel/installer larawhale/valet4win
* mkdir ~/Sites && cd ~/Sites
* laravel new blog
* valet install
* valet park
* valet scan (it updates your hosts file **C:\Windows\System32\drivers\etc\hosts**, so, you have to change its properties to allow full control for current user)
* run  %APPDATA%\Composer\vendor\larawhale\valet4win\start.bat in the **native windows cmd**
or you can make a desktop shortcut to this bat file
* cd blog && valet open (will open http://blog.dev in chrome)

### Advanced How To
#### Install php & composer
As we run php with Caddy in FastCGI mode download **NTS (Non Thread Safe)** version (x86 or x64) from http://windows.php.net/download#php-7.0  .   
Keep in mind Laravel's server requirement https://laravel.com/docs/master/installation#server-requirements  
_**Tokenizer PHP Extension** is included by default in all Windows builds_


### Unresolved Issues
* https://github.com/mholt/caddy/issues/732#issuecomment-207819773  
Caddy server couldn't be run as a service on Windows (means the cmd is always open), on a flip side could be easily closed)), here is more
https://forum.caddyserver.com/t/requested-plugins-ideas-for-developers/127
https://github.com/mholt/caddy/issues/293
it's requested as a plugin for Caddy, hopefully they implement this soon.
* Rescan parked folders manually after adding new subfolder(s) (could be resolved with some sort of filesystem watcher, e.g. node.js)


### Roadmap
- [ ] Implement the same tests as for Mac and maybe some more
- [x] Move caddy exec to bin, Caddyfile config to ~/.valet
- [ ] Port all original mac Valet commands
    - [x] open 
    - [ ] domain 
    - [ ] fetch-share-url 
    - [ ]  ...
    - [ ] uninstall (It only removes Caddy from services, what should I do? remove the desktop shortcut???)
- [ ] Clean up all the OS X leftovers
