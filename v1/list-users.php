<?php
require '../config/auth_middleware.php';
$decoded = authenticate(); // Llama al middleware y almacena los datos decodificados si el token es válido
include "../config/database.php";
$sql = "SELECT * FROM users";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['users' => $users]);
    ?>