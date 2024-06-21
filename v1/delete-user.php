<?php
require '../config/cors.php';
require '../config/database.php';
// Obtener el cuerpo de la solicitud y decodificar el JSON
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id'])) {
    $userId = $input['id'];

    // Consulta SQL para eliminar el usuario
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);

    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['message' => 'Usuario eliminado exitosamente']);
    } else {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(404);
        echo json_encode(['message' => 'Usuario no encontrado']);
    }
} else {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(400);
    echo json_encode(['message' => 'ID de usuario no proporcionado']);
}
?>