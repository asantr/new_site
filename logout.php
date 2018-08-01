<?php
    session_start();
//    destroy that session and send to the front 
    session_destroy();
    header("Location: news_site.php");
    exit;

?>