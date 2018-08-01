<?php   
    $mysqli = new mysqli('localhost', 'as', 'S0urd0ugh!', 'news');
    
    if($mysqli->connect_errno) {
        printf("Connection Failed: %s\n", $mysqli->connect_error);
        exit;
    }
?>