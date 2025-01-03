<?php
$host = "db";
$db_name = "restaurant_menu_system";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo json_encode(["message" => "Connection error: " . $exception->getMessage()]);
    die();
}
?>
