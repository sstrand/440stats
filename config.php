<?php
    $db = "localhost";
    $username = "csci440s_user";
    $password = "CSCI-440StatsWeb";
    $dbName = "csci440s_FBPLAYERS";
    $dbNameUsers = "csci440s_440Test";
    //$db = "localhost";
    //$username = "root";
    //$password = "";
    //$dbName = "csci440s_FBPLAYERS";
    //$dbNameUsers = "440";

    $conn = mysqli_connect($db, $username, $password, $dbName);
    $connUsers = mysqli_connect($db, $username, $password, $dbNameUsers);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>