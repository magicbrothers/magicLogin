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
    <script src="link/crypto/jsbn.js"></script>
    <script src="link/crypto/random.js"></script>
    <script src="link/crypto/hash.js"></script>
    <script src="link/crypto/rsa.js"></script>
    <script src="link/crypto/aes.js"></script>
    <script src="link/crypto/api.js"></script>
    <script>
        function decryptPW(fieldPwId) {
            var encrypted = document.getElementById("pwencrypted").value;
            var privKey = cryptico.generateRSAKey(localStorage.getItem("secret"), 512);
            var result = cryptico.decrypt(encrypted, privKey);
            document.getElementById(fieldPwId).value = result.plaintext;
            localStorage.clear();
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
            $remote = $api->getRemote($session["loginid"]);
            $domain = $remote["domain"];
            $password = $session["password"];
            $fieldPwId = $remote["fieldPwId"];
            $form = $remote["form"];
            $api->deleteSession($_GET["id"]);
            ?>
            <p>Passwort ist verschl&uuml;sselt. Zum Entschl&uuml;sseln und Einsetzten 'Decrypt password' klicken.</p>
            <input type="hidden" id="pwencrypted" value="<?=$password?>"/>
            <button onclick='decryptPW("<?=$fieldPwId?>")'>Decrypt password</button><br /><br />
            <?=$form?>
            <?php
        } else {
            echo "<p>SessionID nicht vorhanden!</p>";
        }
        ?>
    </div>
    <footer><a href="https://github.com/magicbrothers/magicLogin">magicLogin</a> by <a href="https://github.com/magicbrothers">magicbrothers</a></footer>
</div>
</body>
</html>