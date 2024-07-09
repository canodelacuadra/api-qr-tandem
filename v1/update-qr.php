<?php
require '../config/cors.php';
require '../vendor/autoload.php';
require '../config/database.php';

$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'];
$data = $input['data'];
$nombre_ref = $input['nombre_ref'];
$description = $input['description'];

$sql = "UPDATE qr_codes SET data = ?,  description = ?, nombre_ref=? WHERE id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$data,$nombre_ref, $description, $id])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'message' => 'Código QR actualizado exitosamente',
        'id'=> $id
    ]);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['message' => 'Error al actualizar código QR']);
}
?>