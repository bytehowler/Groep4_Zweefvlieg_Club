<?php

    global $mysqli;
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
