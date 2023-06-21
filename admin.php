<?php
global $mysqli, $is_admin, $listOfMessages;
include "includes/database_connection.php";

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
        function changeContent(content) {
            var frame = document.getElementById('frame');
            frame.innerHTML = content;
        }
    </script>
</head>
<body>

<?php require "includes/header.php";?>

<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <div class="btn-group-vertical">
                <button class="btn btn-primary w-100" onclick="changeContent('Content 1')">Gebruikers</button>
                <button class="btn btn-primary w-100" onclick="changeContent('Content 2')">Vliegtuigen</button>
                <?php
                $highlight = false;
                $sql = "SELECT * FROM messages;";
                $result = $mysqli->query($sql);
                $listOfMessages = '<div class="container">';

                while ($row = $result->fetch_assoc()) {

                    $messageContent = <<<EOL
                    <b>{$row["name"]}</b> {$row["email"]}<br><br>
                    <p>{$row["subject"]}</p>
                    <p>{$row["message"]}</p>
                    EOL;

                    $messageContent = htmlspecialchars($messageContent, ENT_QUOTES);

                    if ($highlight) {
                        $class = "\"row bg-light\"";
                    } else {
                        $class = "\"row bg-white\"";
                    }

                    $subject = mb_strimwidth("{$row["subject"]}", 0, 15, "...");
                    $message = mb_strimwidth("{$row["message"]}", 0, 45, "...");

//                    echo $messageContent;

                    $listOfMessages .= <<<EOL
                    
                    <div class=$class onclick="alert("Test");">
                        <div class="col-3">
                            <b>$subject</b>
                        </div>
                        <div class="col">
                            $message
                        </div>
                    </div>
                    EOL;

                    $highlight = !$highlight;
                }

                $listOfMessages .= "</div>";

                echo '<button class="btn btn-primary w-100" onclick="changeContent(`' . htmlspecialchars($listOfMessages, ENT_QUOTES) . '`)">Berichten</button>';
                ?>
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
