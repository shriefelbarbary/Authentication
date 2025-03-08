<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../config/Database.php";
include_once "../models/User.php";
include_once "../helpers/jwt_helper.php";

$headers = getallheaders();
$token = isset($headers["Authorization"]) ? str_replace("Bearer ", "", $headers["Authorization"]) : "";

if ($token) {
    $decoded = JWTHandler::verifyToken($token);

    if ($decoded) {
        $database = new Database();
        $db = $database->connect();
        $user = new User($db);
        $user->id = $decoded->id;
        $userData = $user->getProfile();

        echo json_encode($userData);
    } else {
        echo json_encode(["message" => "Invalid token."]);
    }
} else {
    echo json_encode(["message" => "Token required."]);
}
?>
