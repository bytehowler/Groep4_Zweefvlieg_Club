<?php

    global $mysqli;
    require "database/database_connection.php";

    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["message"])) {
        foreach ($_POST as $key => $value) {
            $value = mysqli_real_escape_string($mysqli, $value);
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $_POST[$key] = $value;
        }

        $email = $_POST["email"];
        $emailPattern = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';

        if (!preg_match($emailPattern, $email)) {
            $return = array(
                'status' => 422,
                'message' => "Unprocessable Content."
            );
            http_response_code(422);

            print_r(json_encode($return));
            die();
        }

        $sql = "INSERT INTO messages (name, email, subject, message) 
                    VALUES ('{$_POST["name"]}', '{$_POST["email"]}', '{$_POST["subject"]}', '{$_POST["message"]}')";

        $mysqli->query($sql);

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contactpagina</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        .container {
            background: linear-gradient(to right, rgba(0, 0, 139, 0.3), rgba(65, 105, 225, 0.3), rgba(135, 206, 235, 0.3));
        }
        .container {
            background-color: #F9F9F9;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #3494e3;
            border-color: #3494e3;
        }
        .btn-primary:hover {
            background-color: #023b6d;
            border-color: #023b6d;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php require "includes/header.php"; ?>
<main class="container">
    <h2>Contacteer ons</h2>
    <p>Heeft u vragen, opmerkingen of wilt u meer informatie? Neem gerust contact met ons op via onderstaand formulier of bel ons op:</p>
    <p>Telefoonnummer: <strong>+31 123 456 789</strong></p>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="contact.php" method="post">
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Onderwerp</label>
                    <input type="subject" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Bericht</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Verstuur</button>
            </form>
        </div>
    </div>
</main>

<?php require "includes/footer.php"; ?>

</body>
</html>
