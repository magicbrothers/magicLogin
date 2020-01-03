<?php
include $_SERVER["DOCUMENT_ROOT"]."/api/API.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>magicLogin</title>
    <link rel="stylesheet" href="link/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="UTF-8">
</head>
<body>
<div class="wrapper">
    <div class="header"></div>
    <div class="navi-wrap"><label for="togglenav">&#9776;</label><input type="checkbox" id="togglenav" /><div class="navi"><a href="index.php" class="current">Login</a><a href="addlogin.php">Login erstellen</a></div></div>
    <div class="content">
        <?php
        if (isset($_POST["masterpassword"])) {
            $hash = $_POST["masterpassword"];
            for ($i = 0; $i < 1024; $i++) {
                $hash = hash("sha256", $hash);
            }
            echo $hash;
        } else {
            ?>
            <form action="genpwhash.php" method="post">
                <label>Masterpasswort: <input type="password" name="masterpassword" /></label><br />
                <button>Hash berechnen</button>
            </form>
            <?php
        }
        ?>
    </div>
    <footer><a href="https://github.com/magicbrothers/magicLogin">magicLogin</a> by <a href="https://github.com/magicbrothers">magicbrothers</a></footer>
</div>
</body>
</html>