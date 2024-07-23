<?php
require '../vendor/autoload.php'; // Cargar el autoloader de Composer
require '../config/auth_middleware.php';
$decoded = authenticate(); // Llama al middleware y almacena los datos decodificados si el token es válido
require '../config/cors.php';
require '../config/database.php';

$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
header('Content-Type: application/json; charset=utf-8');
echo json_encode(
    ["menssage" => "Esta es la lista de usuarios existentes", 
    'users' => $users, 
    'token-decoded' => $decoded]
);