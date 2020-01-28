<?php
require_once __DIR__."/api/API.php";
?>
<!DOCTYPE html>
<html lang="de-DE">
<head>
    <title>magicLogin</title>
    <link rel="stylesheet" href="link/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="UTF-8">
    <script src="link/qr.js"></script>
    <script src="link/crypto/jsbn.js"></script>
    <script src="link/crypto/random.js"></script>
    <script src="link/crypto/hash.js"></script>
    <script src="link/crypto/rsa.js"></script>
    <script src="link/crypto/aes.js"></script>
    <script src="link/crypto/api.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="header"></div>
    <div class="navi-wrap"><label for="togglenav">&#9776;</label><input type="checkbox" id="togglenav" /><div class="navi"><a href="index.php" class="current">Login</a><a href="addlogin.php">Login erstellen</a></div></div>
    <div class="content">
        <?php
        $loginexist = false;
        if (isset($_POST["domain"]) && isset($_POST["username"])) {
            $api = new API();

            if (isset($api->searchRemote($_POST["domain"], $_POST["username"])["error"])) {
                echo "<p>Dieser Login wurde nicht gefunden!</p>";
            } else {
                $loginexist = true;
                $api->addSession($_POST["id"], $_POST["pubkey"], $_POST["domain"], $_POST["username"]);
                ?>

                <div id="qrcode" style="border: 2px solid white; display: inline-block;"></div>

                <script>
                    new QRCode(document.getElementById("qrcode"), {text: "<?=$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].str_replace("index.php", "", $_SERVER["DOCUMENT_URI"])?>enterpass.php?id=<?=$_POST["id"]?>"});
                </script>

                <a href="login.php?id=<?=$_POST["id"]?>">Weiter</a>
                <?php
            }
        }
        if (!$loginexist) {
            ?>
            <script>
                function genRandom(length) {
                    var result = '';
                    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~!@#$%^&*()_+=-';
                    var charactersLength = characters.length;
                    for ( var i = 0; i < length; i++ ) {
                        result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    }
                    return result;
                }

                function genPrivKey() {
                    var secret = genRandom(32);
                    var privKey = cryptico.generateRSAKey(secret, 512);
                    var pubKeyString = cryptico.publicKeyString(privKey);
                    var sessionid = SHA256(pubKeyString);
                    localStorage.setItem("secret", secret);
                    document.getElementById("id").value = sessionid;
                    document.getElementById("pubkey").value = pubKeyString;
                }
            </script>
            <form action="index.php" method="post">
                <label>Domain: <input type="text" name="domain"></label><br/>
                <label>Username: <input type="text" name="username"></label><br/>
                <input type="text" id="id" name="id" hidden />
                <input type="hidden" id="pubkey" name="pubkey" />
                <button onclick="genPrivKey()">Weiter</button>
            </form>
            <?php
        }
        ?>
    </div>
    <footer><a href="https://github.com/magicbrothers/magicLogin">magicLogin</a> by <a href="https://github.com/magicbrothers">magicbrothers</a></footer>
</div>
</body>
</html>