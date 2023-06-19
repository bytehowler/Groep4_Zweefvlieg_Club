<?php
    global $mysqli;
    require "includes/database_connection.php";

    $sql = "DELETE FROM sessions WHERE (session_token='{$_COOKIE["session_token"]}');";
    $mysqli->query($sql);
    setcookie("session_token", "", 1, "/Groep4_Zweefvlieg_Club");

    header("Location: ./");

