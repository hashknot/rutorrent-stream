<?php

// Want auto-login? Add your username:password to rutorrent here
// Example: myusername:12345 or user:password
// This is for http (basic) auth, i.e. .htaccess/.htpasswd

$auth = '';


// If using nginx, you can pause, jump to specific places, etc... while streaming.
// Also required change in VLC settings for pause:
// Settings -> all/advanced -> access modules -> http, check auto reconnect
// Add this to your server {} block (excluding the /* */), and then change the below to true
/*
location ^~ /stream/ {
	internal;
	alias /;
}
*/

define('USE_NGINX', false);


// By default, use http.
// You can change this to https, but it can be difficult to get even a valid cert
// to work with VLC. http://trac.videolan.org/vlc/ticket/3666
// http://mailman.videolan.org/pipermail/vlc-devel/2010-December/078183.html

define('SCHEME', 'http');
