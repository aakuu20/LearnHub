<?php 
require 'config/config.php' ;

if(isset($_GET['download'])){
    $path =$_GET['download'];
    
    
    header('content-Disposition: attachment; filename = '.$path.'');
    header('content-Type:application/octet-stream');
    header('content-Length='.filesize($path));
    readfile($path);
    exit;
}

?>