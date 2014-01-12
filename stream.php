<?php
require_once('./config.php');
require_once( '../../php/xmlrpc.php' );

if (!isset($_GET['f']) || empty($_GET['f']) || !file_exists($_GET['f'])) {
    header('HTTP/1.0 404 Not Found');
    exit();
}

if ( USE_NGINX ) {
    header("Content-Type: application/octet-stream");
    header("X-Accel-Redirect: /stream{$_GET['f']}");
}
else{
    $file = $_GET['f'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    $mime = finfo_file($finfo, $file);
    finfo_close($finfo);
    $modules = apache_get_modules();
    if ( in_array('mod_xsendfile', $modules) ){
        // If mod_xsendfile is loaded, use X-Sendfile to deliver..
        header("Content-type: $mime");
        header("X-Sendfile: $file");
    }
    else{
        // Otherwise, use the traditional PHP way..
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $file . '"');
        @ob_end_clean();
        @ob_end_flush();
        readfile($file);
    }
}
?>
