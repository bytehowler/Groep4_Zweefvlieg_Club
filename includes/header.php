<style>
    .navbar {
        background: linear-gradient(to right, rgba(0, 0, 139, 0.3), rgba(65, 105, 225, 0.3), rgba(135, 206, 235, 0.3));
    }
</style>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="./index.php">Sky High</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./planner.php">Vluchtplanner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./contact.php">Contact</a>
                </li>
                <?php
                global $mysqli;
                $userId = null;
                $userFirstName = null;
                $is_admin = false;

                if (isset($_COOKIE["session_token"])) {
                    $sql = "SELECT user_id FROM sessions WHERE session_token = '{$_COOKIE["session_token"]}';";
                    $result = $mysqli->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $userId = $row["user_id"];

                        $sql = "SELECT role_id, first_name FROM users WHERE user_id = '$userId';";
                        $result = $mysqli->query($sql);
                        $row = $result->fetch_assoc();
                        $userFirstName = $row["first_name"];
                        $is_admin = function() use ($row) { return $row["role_id"] >= 5; };
                    }
                }

                if ($userId && $is_admin()) {
                    echo <<<EOL
                    <li class="nav-item">
                        <a class="nav-link" href="./admin.php">Admin Paneel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Uitloggen</a>
                    </li>
                    EOL;
                } elseif ($userId) {
                    echo <<<EOL
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Uitloggen</a>
                    </li>
                    EOL;
                } else {
                    echo <<<EOL
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Inloggen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./signup.php">Registreren</a>
                    </li>
                    EOL;
                }
                ?>
            </ul>
        </div>
    </nav>
</header>