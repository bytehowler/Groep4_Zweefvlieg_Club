<?php
    global $mysqli;
    include "includes/database_connection.php";

    if (isset($_COOKIE["session_token"])) {
        header("Location: ./");
        die();
    }

    $requiredFields = ["firstName", "lastName", "email", "password",
        "confirmationPassword", "phoneNumber", "birthDate", "verifyCode"];

    $postFilled = true;

    foreach ($requiredFields as $field) {
        if (!array_key_exists($field, $_POST)) {
            $postFilled = false;
            break;
        }
    }

    if ($postFilled) {
        foreach ($_POST as $key => $value) {
            $value = mysqli_real_escape_string($mysqli, $value);
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $_POST[$key] = $value;
        }

        $sql = "SELECT * FROM users WHERE email = '{$_POST["email"]}';";
        $result = $mysqli->query($sql);

        $encrypted_password = md5($_POST["password"]);

        $email = $_POST["email"];
        $phone = $_POST["phoneNumber"];
        $sqlDate = date('Y-m-d', strtotime($_POST["birthDate"]));
        $emailPattern = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';
        $phonePattern = '/^06[0-9]{8}$/';

        if ($result && $result->num_rows > 0) {
            $return = array(
                'status' => 422,
                'message' => "Unprocessable Content."
            );
            http_response_code(422);
        } elseif (!preg_match($emailPattern, $email) || !preg_match($phonePattern, $phone)) {
            $return = array(
                'status' => 422,
                'message' => "Unprocessable Content."
            );
            http_response_code(422);
        } else {
            $sql = "INSERT INTO users (first_name, last_name, birth_date, phone_number, email, password) 
                    VALUES ('{$_POST["firstName"]}', '{$_POST["lastName"]}', '$sqlDate',
                    '{$_POST["phoneNumber"]}', '{$_POST["email"]}', '$encrypted_password')";

            $mysqli->query($sql);

            $sql = "SELECT user_id FROM users WHERE email = '{$_POST["email"]}';";
            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_id = $row["user_id"];

                $token = uniqid(session_create_id() . ".", true);
                $sql = "INSERT INTO sessions (session_token, user_id) VALUES ('$token', {$row["user_id"]})";
                $mysqli->query($sql);
                $return = array(
                    'status' => 200,
                    'message' => "Login Successful."
                );
                setcookie("session_token", $token);
                http_response_code(200);
            }
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
<?php require "includes/header.php"; ?>

<form>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname_field" class="font-weight-bold text-white">Voornaam:</label>
            <input type="text" class="form-control" id="firstname_field" placeholder="Voornaam">
        </div>
        <div class="form-group col-md-6">
            <label for="lastname_field" class="font-weight-bold text-white">Achternaam:</label>
            <input type="text" class="form-control" id="lastname_field" placeholder="Achternaam">
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
        <label for="birthdate_field" class="font-weight-bold text-white">Geboortedatum:</label>
        <input type="date" class="form-control" id="birthdate_field">
    </div>

    <div class="form-group">
        <label for="verification_code_field" class="font-weight-bold text-white">Inlog code:</label>
        <input type="password" class="form-control" id="verification_code_field" placeholder="Verificatie Code">
    </div>

    <button type="button" class="btn btn-light" id="submit_button">Registreren</button>
</form>

</div>
<?php require "includes/footer.php"; ?>
</body>
</html>