<?php
    global $mysqli;
    include "includes/database_connection.php";

    if (isset($_COOKIE["session_token"])) {
        header("Location: ./");
        die();
    }

    if (isset($_POST["email"]) && isset($_POST["password"])) {
        foreach ($_POST as $key => $value) {
            $value = mysqli_real_escape_string($mysqli, $value);
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $_POST[$key] = $value;
        }

        $sql = "SELECT password, user_id FROM users WHERE email = '{$_POST["email"]}';";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $encrypted_password = $row["password"];

            if (md5($_POST["password"]) == $encrypted_password) {
                $return = array(
                    'status' => 200,
                    'message' => "Login Successful."
                );
                $token = uniqid(session_create_id() . ".", true);
                $sql = "INSERT INTO sessions (session_token, user_id) VALUES ('$token', {$row["user_id"]})";
                $mysqli->query($sql);
                setcookie("session_token", $token);
                http_response_code(200);
            } else {
                $return = array(
                    'status' => 403,
                    'message' => "Login attempt denied."
                );
                http_response_code(403);
            }
        } else {
            $return = array(
                'status' => 403,
                'message' => "Login attempt denied."
            );
            http_response_code(403);
        }
        print_r(json_encode($return));
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inloggen</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>

</head>
<body>
<?php require "includes/header.php"; ?>
<form>
    <div class="form-group">
        <label for="email_field" class="font-weight-bold text-white" >Email address:</label>
        <input type="email" class="form-control" id="email_field" aria-describedby="emailHelp" placeholder="Enter email"
               required pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$">
        <small id="emailHelp" class="form-text text-muted">Jouw e-mail wordt nooit met derden gedeeld.</small>
    </div>
    <div class="form-group">
        <label for="password_field" class="font-weight-bold text-white" >Password:</label>
        <input type="password" class="form-control" id="password_field" placeholder="Password" required>
    </div>
    <button type="button" class="btn btn-light" id="submit_button">Inloggen</button>
</form>
</div>
<?php require "includes/footer.php"; ?>
</body>
</html>