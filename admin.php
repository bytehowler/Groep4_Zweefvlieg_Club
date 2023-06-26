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

    if (isset($_POST[""]))
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mijn Homepagina</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function fetchInbox(messageId = 0, removeMessage = 0) {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    document.getElementById("frame").innerHTML = response.message;
                }
            };
            xhr.open("POST", "./admin/inbox.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("message_id=" + messageId + "&remove_flag=" + removeMessage);
        }

        function fetchUsers(messageId = 0, removeMessage = 0) {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    document.getElementById("frame").innerHTML = response.message;
                }
            };
            xhr.open("POST", "./admin/users.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("message_id=" + messageId + "&remove_flag=" + removeMessage);
        }

        function fetchPlanes(messageId = 0, removeMessage = 0) {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    document.getElementById("frame").innerHTML = response.message;
                }
            };
            xhr.open("POST", "./admin/planes.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("message_id=" + messageId + "&remove_flag=" + removeMessage);
        }

        function deleteMail(id) {
            console.log(id);
        }
    </script>
    <style>
    </style>
</head>
<body>

<?php require "includes/header.php";?>

<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <div class="btn-group-vertical">
                <button class="btn btn-primary w-100" onclick="">Gebruikers</button>
                <button class="btn btn-primary w-100" onclick="">Vliegtuigen</button>
                <button class="btn btn-primary w-100" onclick="fetchInbox()">Berichten</button>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Frame to display content -->
            <div id="frame" class="border p-3 rounded" style="background-color: white;"></div>
        </div>
    </div>
</div>

<?php require "includes/footer.php"; ?>

</body>
</html>
