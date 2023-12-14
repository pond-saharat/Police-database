<?php
    session_start();
    if (isset($_SESSION["user"]) && isset($_SESSION["id"])){
        session_destroy();
    echo "<script>location.href='../index.php';</script>";
    exit();
    } else {
        echo "<script>location.href='./index.php';</script>";
        exit();
    }
?>