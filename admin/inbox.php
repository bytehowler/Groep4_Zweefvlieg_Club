<?php
global $mysqli, $is_admin;
include "./../database/database_connection.php";

function fetchMessages(): string
{
    global $mysqli, $row;

    $sql = "SELECT message_id, subject, message FROM messages;";
    $result = $mysqli->query($sql);

    $listOfMessages = '<div class="container">';

    $index = 0;
    while ($row = $result->fetch_assoc()) {
        $subject = mb_strimwidth($row["subject"], 0, 15, "...");
        $message = mb_strimwidth($row["message"], 0, 45, "...");
        $color = "bg-white";

        if ($index % 2 == 0) {
            $color = "bg-light";
        }

        $listOfMessages .= <<<EOL
            <div class="row $color" style="margin-inline: -31px" onclick="fetchInbox({$row["message_id"]});">
                <div class="col-3">
                    <b>{$subject}</b>
                </div>
                <div class="col">
                    {$message}
                </div>
            </div>
            EOL;

        $index++;
    }

    $listOfMessages .= "</div>";

    return $listOfMessages;
}

function getMessage(int $messageId): string
{
    global $mysqli, $row;

    $sql = "SELECT * FROM messages WHERE message_id = '$messageId';";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    $timestamp = date("Y-m-d", strtotime($row["timestamp"]));
    $message = $row["message"];

    return <<<EOL
        <div class="container">
            <div class="row">
                <div class="col-{breakpoint}-auto font-weight-bold">
                    {$row["name"]}
                </div>
                <div class="col-md">
                    &lt;{$row["email"]}&gt;
                </div>
                <div class="col-{breakpoint}-auto text-secondary">
                    {$timestamp}
                </div>  
            </div>
            <br>
            <div class="row font-weight-bold">
                {$row["subject"]}
            </div>
            <div class="row">
                <div style="word-break:break-all">{$message}</div>
            </div>
            <br>
            <div class="row">
                <div class="col-md">
                </div>
                <div class="col-{breakpoint}-auto font-weight-bold">
                    <button type="button" class="btn btn-outline-danger" onclick="fetchInbox($messageId, 1)">Verwijder</button>
                </div>
            </div>
        </div>
        EOL;
}

function removeMessage(int $messageId): string
{
    global $mysqli, $row;

    $sql = "DELETE FROM messages WHERE message_id = '$messageId';";
    $mysqli->query($sql);

    return fetchMessages();
}

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
    $is_admin = function () use ($row) { return $row["role_id"] >= 5; };
}

if (!$is_admin()) {
    http_response_code(403);
    die();
}

$messageId = $_POST["message_id"] ?? null;
$removeFlag = $_POST["remove_flag"] ?? null;
if (!isset($messageId)) {
    $return = array(
        'status' => 422,
        'message' => "Unprocessable Content."
    );
    http_response_code(422);

    print_r(json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

    die();
}

if ($messageId === "0") {
    $return = array(
        'status' => 200,
        'message' => fetchMessages()
    );
    http_response_code(200);

    print_r(str_replace(["\\r", "\\n"], '', json_encode($return, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    die();
} elseif ($messageId >= 1 && !$removeFlag) {
    $return = array(
        'status' => 200,
        'message' => getMessage($messageId)
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

