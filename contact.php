<?php require "includes/database_connection.php" ?>
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
            <form action="contact_process.php" method="post">
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
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
<footer>
    &copy; 2023 Sky High, Alle rechten voorbehouden.
</footer>
</body>
</html>
