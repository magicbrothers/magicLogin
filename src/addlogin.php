<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/api/API.php";
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
    <div class="navi-wrap"><label for="togglenav">&#9776;</label><input type="checkbox" id="togglenav" /><div class="navi"><a href="index.php">Login</a><a href="addlogin.php" class="current">Login erstellen</a></div></div>
    <div class="content">
        <?php
        if(isset($_POST["domain"]) && isset($_POST["username"]) && isset($_POST["fieldpwid"]) && isset($_POST["form"]) && isset($_POST["masterpassword"])) {
            $hash = $_POST["masterpassword"];
            for ($i = 0; $i < 1024; $i++) {
                $hash = hash("sha256", $hash);
            }
            if($hash == Config::$masterpwhash) {
                $api = new API();
                $api->addLogin($_POST["domain"], $_POST["username"], $_POST["fieldpwid"], $_POST["form"]);
                echo "<p>Login hinzugef&uuml;gt!</p>";
            } else {
                echo "<p>Masterpasswort falsch.</p>";
            }
        }
        ?>
        <form action="addlogin.php" method="post">
            <label>Domain: <input type="text" name="domain"></label><br />
            <label>Username: <input type="text" name="username"></label><br />
            <label>FieldPwId: <input type="text" name="fieldpwid"></label><br />
            <label>Form: <textarea name="form">
<form action="https://example.org/login" method="post">
<label>Username: <input type="text" name="username" value="examplename" /></label><br />
<label>Passwort: <input type="password" name="password" id="pw" /></label><br />
<button>Login</button>
</form>
                </textarea></label><br />
            <label>Masterpassword: <input type="password" name="masterpassword"></label><br />
            <button>Weiter</button>
        </form>
    </div>
    <footer><a href="https://github.com/magicbrothers/magicLogin">magicLogin</a> by <a href="https://github.com/magicbrothers">magicbrothers</a></footer>
</div>
</body>
</html>