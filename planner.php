<?php require "includes/database_connection.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vluchtplanner</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php require "includes/header.php"; ?>
<main>
    <h2>Vluchtplanner </h2>
    <p>Op deze pagina kunt u eigen vluchten en lessen plannen.</p>
</main>

<form>
    <label for="date">Datum:</label><br>
    <input type="date" id="date" name="fname"><br>
    <label for="time">Tijdstip:</label><br>
    <input type="time" name="timestamp" step="60"><br>
    <label for="text">Les of eigen vlucht:</label><br>
    <select id="lessonorflight" name="lessonorflight">
        <option value="lesson">Les</option>
        <option value="flight">Eigen vlucht</option>
    </select><br>
    <label for="text">Type zweefvliegtuig:</label><br>
    <select id="type" name="type">
        <option value="1">ASK-21</option>
        <option value="2">LS-4B</option>
        <option value="3">Duo Discus Turbo</option>
    </select>
</form>
<button type="button" class="btn btn-light" id="submit_button">Boek vlucht</button>

<footer>
    &copy; 2023 Sky High, Alle rechten voorbehouden.
</footer>
</body>
</html>