<?php global $userId, $userFirstName;
require "includes/database_connection.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mijn Homepagina</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php require "includes/header.php"; ?>

<main>
    <?php
    if ($userId) {
        echo <<<EOL
        <h2>Welkom terug, $userFirstName.</h2>
        EOL;
    } else {
        echo <<<EOL
        <h2>Welkom bij Zweefvliegclub Sky High! </h2>
        EOL;
    }
    ?>
    <p>Welkom op Sky High! Ontdek zweefvliegtuigen, training en prachtige locaties. Word lid van onze enthousiaste gemeenschap en begin je zweefvliegavontuur. Laat de lucht jouw speeltuin worden - welkom aan boord! </p>
</main>

<p align="center"><iframe src="https://gadgets.buienradar.nl/gadget/zoommap/?lat=52.22333&lng=5.17639&overname=2&zoom=11&naam=Hilversum&size=2b&voor=1" scrolling=no width=330 height=330 frameborder=no></iframe></p>
<p align="center"><IFRAME SRC="//gadgets.buienradar.nl/gadget/forecastandstation/6260" NORESIZE SCROLLING=NO HSPACE=0 VSPACE=0 FRAMEBORDER=0 MARGINHEIGHT=0 MARGINWIDTH=0 WIDTH=300 HEIGHT=190></IFRAME></p>
<?php require "includes/footer.php"; ?>
</body>
</html>
