<?php

    global $mysqli;
    require "database/database_connection.php";

    $sql = "DELETE FROM sessions WHERE (session_token='{$_COOKIE["session_token"]}');";
    $mysqli->query($sql);
    setcookie("session_token", "", 1);

    header("Location: ./");