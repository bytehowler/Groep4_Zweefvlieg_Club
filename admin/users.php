<?php

global $mysqli, $is_admin;
include "./../database/database_connection.php";

function fetchUsers(): string
{
    global $mysqli, $row;

    $sql = "SELECT user_id, u.role_id, role_name, first_name, last_name FROM users u 
        JOIN roles r ON r.role_id = u.role_id;";
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
            <div class="row $color" style="margin-inline: -31px" onclick="getUser({$row["user_id"]});">
                <div class="col-xs-2 col-3">
                    <b>$name</b>
                </div>
                <div class="col">
                    {$row["role_name"]}
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
    $userId = mysqli_real_escape_string($mysqli, $userId);

    $sql = "SELECT * FROM roles;";
    $result = $mysqli->query($sql);

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $roles[$row["role_id"]] = $row["role_name"];
    }


    $sql = "SELECT * FROM users u JOIN roles r on r.role_id = u.role_id WHERE user_id = '$userId';";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    $roleSelector = "<select onchange=\"updateRank($userId, this.value)\">";
    foreach ($roles as $roleId => $roleName) {
        if ($row["role_id"] == $roleId) {
            $roleSelector .= "<option value=\"$roleId\" selected>$roleName</option>";
        } else {
            $roleSelector .= "<option value=\"$roleId\">$roleName</option>";
        }
    }

    $roleSelector .= "</select>";

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
                        $roleSelector
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-md">
                    </div>
                    <div class="col-{breakpoint}-auto font-weight-bold">
                        <button type="button" class="btn btn-outline-danger" onclick="removeUser($userId)">Verwijder</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    EOL;
}

function removeUser(int $userId): void
{
    global $mysqli;

    $userId = mysqli_real_escape_string($mysqli, $userId);

    $sql = "DELETE FROM users WHERE user_id = '$userId';";
    $mysqli->query($sql);

}

function updateRole(int $userId, int $roleId): void
{
    global $mysqli;

    $userId = mysqli_real_escape_string($mysqli, $userId);
    $roleId = mysqli_real_escape_string($mysqli, $roleId);

    $sql = "UPDATE users SET role_id = '$roleId' where user_id = '$userId';";
    $mysqli->query($sql);
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

if (!sizeof($_POST)) {
    $return = array(
        'status' => 200,
        'message' => fetchUsers()
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();

} elseif (isset($_POST["user_id"]) && isset($_POST["role_id"])) {
    $return = array(
        'status' => 204,
        'message' => updateRole($userId, $_POST["role_id"])
    );

    http_response_code(204);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();

} elseif (isset($_POST["user_id"]) && isset($_POST["remove_flag"])) {
    removeUser($userId);

    $return = array(
        'status' => 200,
        'message' => fetchUsers()
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();

} elseif (isset($_POST["user_id"])) {
    $return = array(
        'status' => 200,
        'message' => getUser($userId)
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();

}