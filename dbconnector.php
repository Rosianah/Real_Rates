<?php 
//theUssdDb.php

$servername = 'localhost';
$username = 'root';
$password = "";
$database = "real_rates";
$dbport = 3306;



    // Create connection
    $db = new mysqli($servername, $username, $password, $database, $dbport);

    // Check connection
    if ($db->connect_error) {
        header('Content-type: text/plain');
        //log error to file/db $e-getMessage()
        die("END An error was encountered. Please try again later");
    } 
    
