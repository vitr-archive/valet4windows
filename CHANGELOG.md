# Change Log
All notable changes to this project will be documented in this file.

## [0.9.1] - 01 Aug 2016
### Added
- restart command
- uninstall command
### News
- All commands have been implemented, finally

## [0.9.0] - 31 Jul 2016
### News  
- Project moved from `larawhale/valet4win` to `vitr/valet4windows`
- Updated readme
- Created change log   

## [0.7.0] - 15 Jun 2016
### Ground breaking release
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

## [0.5.0] - 08 Jun 2016
### MVP (minimum viable product) has arrived
From v0.5.0 valet4win could be comfortably used with minimum default configuration. I've managed to run it on my Windows10 notebook. There are two manual tasks you have to perform:
1. Run valet4win using start.bat (tip: create a desktop shorcut for it)
2. Run valet scan every time you create a new folder in your ~/Sites, as valet4win uses the old trick with hosts file. It's a small overhead in comparison to running an extra DNS service on your machine.
Not all the valet commands are currently working, but it's something to start with, perhaps, it would be just enough for someone.

##[0.3.1] - 07 Jun 2016
### WIP (work in progress)
This is a proof of concept. As a GO program, Caddy is a cross platform application, it works the same great on Windows.
I wanted to run Valet on Windows as quick as possible with minimal changes to the original package. It turned out that it's easier to create a new package specifically for Windows, as I'm not using DnsMasq, Brew, etc. I copied the original package in full on my Windows machine and tried to run it, every time I hit an error, I looked into the source code and fixed it, in many cases I just commented a lot of stuff. On the second day I've got MVP and I believe the concept has been proven.
So far, it's straight Caddy plus php, with less magic than on Mac, but it's simpler and more transparent. Let's see how useful this version could be and if it proves itself, we can extend and improve it later on.
