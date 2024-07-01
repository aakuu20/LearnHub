<?php 
require '../../config/config.php' ;

if(isset($_GET['download'])){
    $path =$_GET['download'];
    $fileDestination = '../../uploads/'.$path;

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; fileman="'.basename($fileDestination).'"');
    header('Content-Length: '.filesize($fileDestination));
    readfile($fileDestination);
    exit;
}

?>