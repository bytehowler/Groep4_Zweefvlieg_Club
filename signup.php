<?php
    global $mysqli;
    include "database_connection.php";

    if (isset($_COOKIE["session_token"])) {
        header("Location: ./");
        die();
    }

    if (isset($_POST["email"]) && isset($_POST["password"])) {
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
    <title>Registreren</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
<?php require "header.php"; ?>

<form>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="first_name_field" class="font-weight-bold text-white">Voornaam:</label>
            <input type="text" class="form-control" id="first_name_field" placeholder="Voornaam">
        </div>
        <div class="form-group col-md-6">
            <label for="last_name_field" class="font-weight-bold text-white">Achternaam:</label>
            <input type="text" class="form-control" id="last_name_field" placeholder="Achternaam">
        </div>
    </div>

    <div class="form-group">
        <label for="email_field" class="font-weight-bold text-white">E-mail adres:</label>
        <input type="email" class="form-control" id="email_field" aria-describedby="emailHelp" placeholder="E-mail">
        <small id="emailHelp" class="form-text text-muted">Jouw e-mail wordt nooit met derden gedeeld.</small>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password_field" class="font-weight-bold text-white">Wachtwoord:</label>
            <input type="password" class="form-control" id="password_field" placeholder="Wachtwoord">
        </div>
        <div class="form-group col-md-6">
            <label for="confirm_password_field" class="font-weight-bold text-white">Herhaal Wachtwoord:</label>
            <input type="password" class="form-control" id="confirm_password_field" placeholder="Herhaal Wachtwoord">
        </div>
    </div>

    <div class="form-group">
        <label for="phone_field" class="font-weight-bold text-white">Telefoonnummer:</label>
        <input type="tel" class="form-control" id="phone_field" aria-describedby="telefoonnummerHelp" placeholder="Bijv. 0612345678">
    </div>

    <div class="form-group">
        <label for="verification_code_field" class="font-weight-bold text-white">Inlog code:</label>
        <input type="password" class="form-control" id="verification_code_field" placeholder="Verificatie Code">
    </div>

    <button type="submit" class="btn btn-light">Registreren</button>
</form>

</div>
<footer>
    &copy; 2023 Sky High, Alle rechten voorbehouden.
</footer>
</body>
</html>