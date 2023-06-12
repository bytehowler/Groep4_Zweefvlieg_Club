<?php
include "database_connection.php"

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
        <label for="exampleInputEmail1">Herhaal Email address:</label>
        <input type="email" class="form-control" id="email_field" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputtelefoonnummer1">Telefoon nummer:</label>
        <input type="tel" class="form-control" id="telefoonnummer_field" aria-describedby="telefoonnummerHelp" placeholder="Enter telefoonnummer">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password:</label>
        <input type="password" class="form-control" id="password_field" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Herhaal Password:</label>
        <input type="password" class="form-control" id="password_field" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Inlog code:</label>
        <input type="password" class="form-control" id="password_field" placeholder="Password">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="checkbox">Check me out</label>
    </div>
    <button type="submit" class="btn btn-light">registreren</button>
</form>
</div>
<footer>
    &copy; 2023 Sky High, Alle rechten voorbehouden.
</footer>
</body>
</html>