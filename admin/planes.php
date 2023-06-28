<?php

global $mysqli;
include "./../database/database_connection.php";

function fetchPlanes(): string
{
    global $mysqli, $row;

    $sql = "SELECT tail_id, state_description, nickname FROM planes p JOIN states s on s.state_id = p.state_id;";
    $result = $mysqli->query($sql);

    $listOfPlanes = '<div class="container">';

    $index = 0;
    while ($row = $result->fetch_assoc()) {
        $color = "bg-white";

        if ($index % 2 == 0) {
            $color = "bg-light";
        }

        $listOfPlanes .= <<<EOL
            <div class="row $color" style="margin-inline: -31px" onclick="fetchPlanes({$row["tail_id"]});">
                <div class="col-3">
                    <b>"{$row["nickname"]}"</b>
                </div>
                <div class="col">
                    {$row["tail_id"]}
                </div>
            </div>
            EOL;

        $index++;
    }

    $listOfPlanes .= "</div>";

    return $listOfPlanes;
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

$tailId = $_POST["tail_id"] ?? null;
$removeFlag = $_POST["remove_flag"] ?? null;
if (!isset($tailId)) {
    $return = array(
        'status' => 422,
        'message' => "Unprocessable Content."
    );
    http_response_code(422);

    print_r(json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

    die();
}

if ($tailId === "0") {
    $return = array(
        'status' => 200,
        'message' => fetchPlanes()
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();
} elseif ($tailId != 0 && !$removeFlag) {
    $return = array(
        'status' => 200,
        'message' => getMessage($tailId)
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();
} elseif ($messageId >= 1 && $removeFlag) {
    $return = array(
        'status' => 200,
        'message' => removeMessage($messageId)
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();
}