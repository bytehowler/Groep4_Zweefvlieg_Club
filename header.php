<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Sky High</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="vluchtplanner.html">Vluchtplanner</a>
                </li>
                <?php
                if (isset($_COOKIE["session_token"])) {
                    echo <<<EOL
                    <li class="nav-item">
                        <a class="nav-link" href="#">Uitloggen</a>
                    </li>
                    EOL;
                } else {
                    echo <<<EOL
                    <li class="nav-item">
                        <a class="nav-link" href="signin.php">Inloggen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Registreren</a>
                    </li>
                    EOL;
                }
                ?>

            </ul>
        </div>
    </nav>
</header>