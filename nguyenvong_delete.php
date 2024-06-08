<?php
    include "session_check.php";
    include "database_connection.php";
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM nguyenvong WHERE id = $id";
        $result = $connection->query($sql);

        if($result){
            header("Location: nguyenvong_view.php");
            exit();
        } else {
            die("Query failed: " . $connection->error);
        }

    }
?>