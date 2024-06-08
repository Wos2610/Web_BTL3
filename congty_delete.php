<?php
    include "session_check.php";
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $servername = "localhost";
        $username = "root";
        $password = "1234";
        $database = "student_database";

        $connection = new mysqli($servername, $username, $password, $database);

        if($connection->connect_error){
            die("Connection failed: " . $connection->connect_error);
        }

        $sql = "DELETE FROM congty WHERE id = $id";
        $result = $connection->query($sql);

        if($result){
            header("Location: congty_view.php");
            exit();
        } else {
            die("Query failed: " . $connection->error);
        }

    }
?>