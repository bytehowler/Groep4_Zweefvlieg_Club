<?php include "database/database_connection.php"; ?>




<!DOCTYPE html>

<html lang="en">
<head>
    <title>Vluchtplanner</title>
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

<main class="container text-center">
    <h2 class="mt-5">Vluchtplanner</h2>
    <p>Op deze pagina kunt u eigen vluchten en lessen plannen.</p>

    <form>
        <div class="form-group">
            <label for="date">Datum:</label>
            <input type="date" class="form-control" id="date" name="fname">
        </div>
        <div class="form-group">
            <label for="time">Tijdstip:</label>
            <input type="time" class="form-control" name="timestamp" step="60">
        </div>
        <div class="form-group">
            <label for="lessonorflight">Les of eigen vlucht:</label>
            <select class="form-control" id="lessonorflight" name="lessonorflight">
                <option value="lesson">Les</option>
                <option value="flight">Eigen vlucht</option>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Type zweefvliegtuig:</label>
            <select class="form-control" id="type" name="type">
                <option value="1">ASK-21</option>
                <option value="2">LS-4B</option>
                <option value="3">Duo Discus Turbo</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" id="submit_button">Boek vlucht</button>
    </form>
</main>

<footer class="text-center mt-5">
    &copy; 2023 Sky High, Alle rechten voorbehouden.
</footer>


</body>
</html>
