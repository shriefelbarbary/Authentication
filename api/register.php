<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../config/Database.php";
include_once "../models/User.php";

$database = new Database();
$db = $database->connect();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->username) && !empty($data->email) && !empty($data->password)) {
    $user->username = $data->username;
    $user->email = $data->email;
    $user->password = $data->password;

    if ($user->register()) {
        echo json_encode(["message" => "User registered successfully."]);
    } else {
        echo json_encode(["message" => "Registration failed."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
