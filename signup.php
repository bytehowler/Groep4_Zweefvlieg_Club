<?php
    global $mysqli;
    include "database_connection.php";

    if (isset($_COOKIE["session_token"])) {
        header("Location: ./");
        die();
    }

    $requiredFields = ["firstName", "lastName", "email", "password",
        "confirmationPassword", "phoneNumber", "verifyCode"];

    if (array_key_exists($_POST, $requiredFields)) {
        $sql = "SELECT * FROM users WHERE email = '{$_POST["email"]}';";
        $result = $mysqli->query($sql);

        $email = $_POST["email"];
        $pattern = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';

        if ($result && $result->num_rows > 0) {
            $return = array(
                'status' => 422,
                'message' => "Unprocessable Content."
            );
            http_response_code(422);
        } elseif (!preg_match($pattern, $email)) {
            $return = array(
                'status' => 422,
                'message' => "Unprocessable Content."
            );
            http_response_code(422);
        } else {
            //$sql = "INSERT INTO users (session_token, user_id) VALUES ('$token', {$row["user_id"]})";
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
    <script src="js/signup.js"></script>
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

    <button type="button" class="btn btn-light" id="submit_button">Registreren</button>
</form>

</div>
<footer>
    &copy; 2023 Sky High, Alle rechten voorbehouden.
</footer>
</body>
</html>