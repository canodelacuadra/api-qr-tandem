<?php
require '../config/cors.php';
require '../config/database.php';
// Obtener el cuerpo de la solicitud y decodificar el JSON
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id']) && isset($input['email']) && isset($input['role'])) {
    $userId = $input['id'];
    $email = $input['email'];
    $role = $input['role'];

    // Consulta SQL para actualizar el usuario
    $sql = "UPDATE users SET email = ?, role = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $role, $userId]);

    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['message' => 'Usuario actualizado exitosamente']);
    } else {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(404);
        echo json_encode(['message' => 'Usuario no encontrado']);
    }
} else {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(400);
    echo json_encode(['message' => 'Datos incompletos']);
}
?>.