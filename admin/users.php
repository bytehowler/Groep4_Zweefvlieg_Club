<?php

global $mysqli, $is_admin;
include "./../database/database_connection.php";

function fetchUsers(): string
{
    global $mysqli, $row;

    $sql = "SELECT user_id, role_id, first_name, last_name FROM users;";
    $result = $mysqli->query($sql);

    $listOfUsers = '<div class="container">';

    $index = 0;
    while ($row = $result->fetch_assoc()) {
        $name = $row["first_name"][0] . ". " . $row["last_name"];
        $color = "bg-white";

        if ($index % 2 == 0) {
            $color = "bg-light";
        }

        $listOfUsers .= <<<EOL
            <div class="row $color" style="margin-inline: -31px" onclick="fetchUsers({$row["user_id"]});">
                <div class="col-3">
                    <b>{$name}</b>
                </div>
                <div class="col">
                    {}
                </div>
            </div>
            EOL;

        $index++;
    }

    $listOfUsers .= "</div>";

    return $listOfUsers;
}

function getUser(int $userId): string
{
    global $mysqli, $row;

    $sql = "SELECT * FROM users u JOIN roles r on r.role_id = u.role_id WHERE user_id = '$userId';";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    return <<<EOL
    <div class="container">
        <div class="row">
            <div class="col-{breakpoint}-auto">
                <img src="./img/default_pfp.jpg" alt="" width="120" height="120">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <b>Naam:</b> {$row["first_name"]} {$row["last_name"]}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <b>E-mail:</b> {$row["email"]}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <b>Tel:</b> {$row["phone_number"]}
                    </div>
                </div>
                <br>
                <div class="row font-weight-bold">
                    <div class="col">
                        {$row["role_name"]}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-md">
                    </div>
                    <div class="col-{breakpoint}-auto font-weight-bold">
                        <button type="button" class="btn btn-outline-danger" onclick="fetchUsers($userId, 0)">Verwijder</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    EOL;
}



if (!isset($_COOKIE["session_token"])) {
    http_response_code(401);
    die();
}

$sessionToken = mysqli_real_escape_string($mysqli, $_COOKIE["session_token"]);
$sql = "SELECT * FROM users u 
JOIN sessions s on u.user_id = s.user_id 
JOIN roles r on r.role_id = u.role_id 
     WHERE session_token = '$sessionToken';";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $is_admin = function() use ($row) { return $row["role_id"] >= 5; };

    if (!$is_admin()) {
        http_response_code(403);
        die();
    }
} elseif (!$result || $result->num_rows == 0) {
    http_response_code(401);
    die();
}


$userId = $_POST["user_id"] ?? null;
$removeFlag = $_POST["remove_flag"] ?? null;
if (!isset($userId)) {
    $return = array(
        'status' => 422,
        'message' => "Unprocessable Content."
    );
    http_response_code(422);

    print_r(json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

    die();
}

if ($userId === "0") {
    $return = array(
        'status' => 200,
        'message' => fetchUsers()
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();
} elseif ($userId >= 1 && !$removeFlag) {
    $return = array(
        'status' => 200,
        'message' => getUser($userId)
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();
} elseif ($userId >= 1 && $removeFlag) {
    $return = array(
        'status' => 200,
        'message' => getUser($userId)
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();
}