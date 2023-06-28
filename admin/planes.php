<?php

global $mysqli;
include "./../database/database_connection.php";

function fetchPlanes(): string
{
    global $mysqli, $row;

    $sql = "SELECT tail_id, state_description, nickname FROM planes p JOIN states s on s.state_id = p.state_id;";
    $result = $mysqli->query($sql);

    $listOfPlanes = "<div class=\"container\">";

    $listOfPlanes .= <<< EOL
            <div class="row">
                <div class="col"><input class="form-control form-control-sm" type="text" name="tail_id" id="tail_id" placeholder="Registratie nr."></div>
                <div class="col"><input class="form-control form-control-sm" type="text" name="model_name" id="model_name" placeholder="Model"></div>
                <div class="col"><input class="form-control form-control-sm" type="text" name="year" id="year" placeholder="Bouwjaar"></div>
                <div class="col"><input class="form-control form-control-sm" type="text" name="manufacturer" id="manufacturer" placeholder="Fabrikant"></div>
                <div class="col"><input class="form-control form-control-sm" type="text" name="nickname" id="nickname" placeholder="Nickname"></div>
                <div class="col-{breakpoint}-auto">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addPlane(
                        document.getElementById('tail_id').value,
                        document.getElementById('model_name').value,
                        document.getElementById('year').value,
                        document.getElementById('manufacturer').value,
                        document.getElementById('nickname').value
                        )">🞥</button>
                </div>
            </div>
        </div>
        
        <div class="container">
        EOL;

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

function addPlane(string $tailId, string $modelName, int $year, string $manufacturer, string $nickname): void
{
    global $mysqli;

    $tailId = mysqli_real_escape_string($mysqli, $tailId);
    $modelName = mysqli_real_escape_string($mysqli, $modelName);
    $year = mysqli_real_escape_string($mysqli, $year);
    $manufacturer = mysqli_real_escape_string($mysqli, $manufacturer);
    $nickname = mysqli_real_escape_string($mysqli, $nickname);

    $sql = "INSERT INTO planes (tail_id, model_name, year, manufacturer, nickname)
                VALUES ('$tailId', '$modelName', '$year', '$manufacturer', '$nickname');";
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

$tailId = $_POST["tail_id"] ?? null;
$modelName = $_POST["model_name"] ?? null;
$year = $_POST["year"] ?? null;
$manufacturer = $_POST["manufacturer"] ?? null;
$nickname = $_POST["nickname"] ?? null;

$removeFlag = $_POST["remove_flag"] ?? null;

if (isset($tailId) && isset($modelName) && isset($year) && isset($manufacturer) && isset($nickname)) {
    addPlane($tailId, $modelName, $year, $manufacturer, $nickname);

}
$return = array(
    'status' => 200,
    'message' => fetchPlanes()
);
http_response_code(200);
print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
die(); 