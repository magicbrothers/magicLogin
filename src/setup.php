<?php
require_once __DIR__."/link/db.php";

$db = new DB();
$db->getConnection();

$db->create("logins", "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, domain VARCHAR(63) NOT NULL, username VARCHAR(31) NOT NULL, fieldPwId VARCHAR(31) NOT NULL, form TEXT NOT NULL");
$db->create("sessions", "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, sessionid VARCHAR(256) NOT NULL, pubkey VARCHAR(128) NOT NULL, loginid INT(6) NOT NULL, password VARCHAR(512) NOT NULL");
echo $db->conn->error;
echo "Setup abgeschlossen.";