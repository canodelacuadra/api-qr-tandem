<?php
require '../config/cors.php';
require '../vendor/autoload.php';
require '../config/database.php';
// Obtener el cuerpo de la solicitud y decodificar el JSON
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['nombre']) AND $input['nombre']!=""  && isset($input['email'])AND $input['email']!="" && isset($input['delegacion'])AND $input['delegacion']!="") {
    $nombre = $input['nombre'];
    $email = $input['email'];
    $delegacion = $input['delegacion'];

    // Consulta SQL para actualizar el usuario
    $sql = "UPDATE users SET nombre = ?, delegacion = ? WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $delegacion, $email]);

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
    echo json_encode(['message' => 'Datos incompletos en la entrada, por favor rellenalos']);
}
?>