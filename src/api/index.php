<?php
header("Content-Type: application/json; charset=UTF-8");
require_once $_SERVER["DOCUMENT_ROOT"]."/api/API.php";

$api = new API();
$response = array();

if(!isset($_GET["id"])) {
    echo json_encode(array("error" => "no session id"));
    return;
}

$queries = explode("&", $_SERVER["QUERY_STRING"]);
$posts = json_decode(file_get_contents("php://input"));
$args = array();

foreach ($queries as $query) {
    $query = explode("=", $query);
    $args[$query[0]] = $query[1];
}

$sessionid = $args["id"];

if(isset($args["pubkey"]) && isset($args["domain"]) && isset($args["username"])) {
    $response = $api->addSession($sessionid, $args["pubkey"], $args["domain"], $args["username"]);
} else if(isset($post["password"])) {
    $response = $api->setPassword($sessionid, $_GET["password"]);
} else {
    $response = $api->getSession($args["id"]);
}

http_response_code(200);
echo json_encode($response);