# magicLogin

INSTALLATION:

Webserver (z.B. nginx) installieren.
PHP installieren.
MySQL Datenbank (z.B. MariaDB) installieren.
Eine magiclogin (Name egal) Datenbank erstellen.
Einen MySQL Nutzer anlegen, welcher Zugriff auf die magicLogin DB hat.

cd /var/www/html (Navigieren in den Webcontent Ordner)
git clone https://github.com/magicbrothers/magicLogin.git
nano magicLogin/src/link/config.php (DB-Daten und SHA-256 (1024 Iterationen) Hash des Masterpasswortes eintragen * )


Fertig!

EINRICHTUNG:

https://login.example.org/setup.php (Setup aufrufen, legt Tabellen an)
https://login.example.org/addlogin.php (Login erstellen)

Login erstellen:
Domain: Domain eintragen (muss nicht der echten Domain entsprechen, nur zur Identifizier0ung)
Username: Nutzernamen zu der Domain eintragen.
FieldPwId: ID des Passwortfeldes
Form: Das HTML-Anmeldeformular. Der Nutzername kann hardcodiert sein, das Passwortfeld muss die oben eingetragene ID haben. Die name-Attribute müssen auf den Zielserver angepasst werden, sowie das action-Attribut.
Masterpasswort: Das Masterpasswort, dessen Hash in der link/config.php festgelegt wurde.

Es darf mehrfach die gleiche Domain, sowie der gleiche Username verwendet werden. Nur die Kombination aus beiden muss einzigartig sein!

NUTZUNG:

https://login.example.org aufrufen und Domain und Username eines vorher eingerichteten Logins eingeben, dann auf 'Weiter' klicken.
Mit einem Smartphone den QR-Code scannen und die URL aufrufen.
Das Passwort zum vorher eingegebenen Login eingeben, dann auf 'Weiter' klicken.
Am PC, neben dem QR-Code, auf 'Weiter' klicken.
Es sollte ein fertiges Formular erscheinen. Mit einem Klick auf 'Decrypt password' wird das verschlüsselte Passwort in das Feld geschrieben, jetzt nur noch auf 'Login' klicken.
Fertig, jetzt werden die Anmeldedaten an den Zielserver geschickt!