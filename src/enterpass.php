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
    <script src="link/crypto/jsbn.js"></script>
    <script src="link/crypto/random.js"></script>
    <script src="link/crypto/hash.js"></script>
    <script src="link/crypto/rsa.js"></script>
    <script src="link/crypto/aes.js"></script>
    <script src="link/crypto/api.js"></script>
    <script>
        function encryptPW(pubKeyString) {
            var pw = document.getElementById("pw").value;
            var result = cryptico.encrypt(pw, pubKeyString);
            document.getElementById("pw").value = result.cipher;
        }
    </script>
</head>
<body>
<div class="wrapper">
    <div class="header"></div>
    <div class="navi-wrap"><label for="togglenav">&#9776;</label><input type="checkbox" id="togglenav" /><div class="navi"><a href="index.php" class="current">Login</a><a href="addlogin.php">Login erstellen</a></div></div>
    <div class="content">
        <?php
        $loggedin = false;
        $api = new API();
        if(isset($_GET["id"]) && !isset($api->getSession($_GET["id"])["error"])) {
            $session = $api->getSession($_GET["id"]);
            $pubKey = $session["pubkey"];
            if(!isset($_POST["pw"])) {
                ?>
                <form action="enterpass.php?id=<?= $_GET["id"] ?>" method="post">
                    <label>Password: <input type="password" id="pw" name="pw"></label><br/>
                    <button onclick='encryptPW("<?=$pubKey?>")'>Weiter</button>
                </form>
                <?php
            } else {
                $api->setPassword($_GET["id"], $_POST["pw"]);
                echo "<p>Passwort erfolgreich gesetzt.</p>";
                ?>
                <?php
            }
        } else {
            echo "<p>SessionID nicht vorhanden!</p>";
        }
        ?>
    </div>
    <footer><a href="https://github.com/magicbrothers/magicLogin">magicLogin</a> by <a href="https://github.com/magicbrothers">magicbrothers</a></footer>
</div>
</body>
</html>