<?php
require '../config/cors.php';
require '../vendor/autoload.php';

include "../config/database.php";

try {
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
    
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'message' => 'Esta es la lista de usuarios actualizada',
        'users' => $users
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'message' => 'Error al obtener los usuarios',
        'error' => $e->getMessage()
    ]);
}
?>
