#RuTorrent Stream Plugin
===
## Description:
This is a fork of [rutorrent-stream-plugin](https://code.google.com/p/rutorrent-stream-plugin/) to add a couple of features viz.

1. Better streaming support for Apache
2. Stream In-Browser
3. Directly open the file in VLC.

## Requirements
1. Properly configured RuTorrent
2. `mod_xsendfile` apache module installed and enabled.  
For Ubuntu 12.04, `mod_xsendfile` can be installed with:
    
        sudo apt-get install libapache2-mod-xsendfile
        sudo a2enmod xsendfile


## Installation

1. Copy the `stream` directory to `plugins/` directory of RuTorrent installation.

2. Whitelist your download location(s) for `XSendFile` by adding the following lines to `apache.conf` OR `httpd.conf` file:

        XSendFilePath /path/to/download/location1
        XSendFilePath /path/to/download/location2

    For Ubuntu 12.04, you would need to edit the `/etc/apache2/apache2.conf` file.

This will get the In-Browser stream working.

### VLC Stream:
This requires the in-browser stream to be working.

#### How it works?
Initially, the plugin generates the following URI:
    
    vlc://http://localhost/rutorrent/stream.php?f=%2fmedia%2fVideo.mp4
    
Let's break it down:

1.  `vlc://` : Your own custom protocol handler. Mind you, **VLC DOES NOT understand it** by default. It can be anything, as long as you make the necessary changes in the following steps.
2.  `http://` : The actual protocol on which the file will be served.
3.  `./stream.php` : The path on the webserver leading to `stream.php`. This file actually streams the data to the client.
4.  `f=%2fmedia..` : The absolute location of the download file. In this case it's `/media/Video.mp4` being passed as a GET value for `f`.

When the browser tries to open this URL, it doesn't understand how `vlc://` protocol is to be handled and relies on `xdg-open` to deal with it.

So, all we need to do is 

1. implement a handler which strips the leading `vlc://`
2. passes the stripped string to VLC as a command-line argument.
3. Register this handler with `xdg-open` using `xdg-mime`.

The following steps are for Ubuntu 12.04. Should work on all the latest Ubuntu versions.

1. Copy `resources/vlcstream` to any location in `$PATH`. Make sure it's exeutable.
2. Copy `resources/vlc-stream.desktop` to `~/.local/share/applications/`
3. Execute:

        xdg-mime default vlc-stream.desktop x-scheme-handler/vlc 

##Copyright and License
Released under MIT License.  
Copyright : 2013 [Jitesh Kamble](http://www.facebook.com/crusador)
