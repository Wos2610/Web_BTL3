<?php
$servername = "localhost";
    $username = "root";
    $password = "1234";
    $database = "student_database";

    $connection = new mysqli($servername, $username, $password, $database);

    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }