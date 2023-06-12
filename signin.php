<?php
global $mysqli;
include "database_connection.php";

    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $sql = "SELECT password FROM users WHERE email = '{$_POST["email"]}';";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $encrypted_password = $row["password"];

            if (md5($_POST["password"]) == $encrypted_password) {
                http_response_code(200);
            } else {
                http_response_code(418);
            }
        } else {
            http_response_code(418);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
<?php require "header.php"; ?>
<form>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address:</label>
        <input type="email" class="form-control" id="email_field" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password:</label>
        <input type="password" class="form-control" id="password_field" placeholder="Password">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="checkbox">Check me out</label>
    </div>
    <button type="button" class="btn btn-light" id="submit_button">Login</button>
</form>
</div>
<footer>
    &copy; 2023 Sky High, Alle rechten voorbehouden.
</footer>
</body>
<script src="js/signin.js"></script>
</html>