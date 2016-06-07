# valet4win
Windows version of the legendary Laravel Valet

### WIP (work in progress)
This is a proof of concept. As a GO program, Caddy is a cross platform application, it works the same great on Windows.
I wanted to run Valet on Windows as quick as possible with minimal changes to the original package. It turned out that it's easier to create a new package specifically for Windows, as I'm not using DnsMasq, Brew, Ngrok, etc.  
So far, it's straight Caddy plus php, with less magic than on Mac, but it's simpler and more transparent. Let's see how useful this version could be and if it proves itself, we can extend and improve it later on.

### How to Use

1. Install php
2. Install composer
3. composer global require laravel/installer
4. composer global require larawhale/valet4win
5. mkdir %HOMEPATH%\Sites
6. cd %HOMEPATH%\Sites
7. valet install
8. valet park
9. laravel new blog
10. valet scan
11. visit http://blog.dev

### Unresolved Issues
* https://github.com/mholt/caddy/issues/732#issuecomment-207819773  
Caddy server couldn't be run as a service on Windows (means the cmd is always open), on a flip side could be easily closed))
* Rescan parked folders manually after adding new subfolder(s) (could be resolved with some sort of filesystem watcher, e.g. node.js)


### Roadmap
- [ ] Move caddy exec to bin, Caddyfile config to ~/.valet
- [ ] Port all original mac Valet commands
    - [ ] port domain command
    - [ ] port fetch-share-url command
    - [ ]  ...
- [ ] Clean up all the OS X leftovers