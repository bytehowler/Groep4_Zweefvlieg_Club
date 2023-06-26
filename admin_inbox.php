<?php
    global $mysqli, $is_admin, $listOfMessages;
    include "database/database_connection.php";

    if (!isset($_COOKIE["session_token"])) {
        http_response_code(401);
        die();
    }

    $sql = "SELECT user_id FROM sessions WHERE session_token = '{$_COOKIE["session_token"]}';";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row["user_id"];

        $sql = "SELECT role_id FROM users WHERE user_id = '$userId';";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $is_admin = function() use ($row) { return $row["role_id"] >= 5; };

        if (!$is_admin()) {
            http_response_code(403);
            die();
        }
    }

    function getMessages() {

    }

    function getMessage(int $messageId) {

    }