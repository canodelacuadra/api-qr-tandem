<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


require '../config/database.php';

$input = json_decode(file_get_contents('php://input'), true);

$nombre = $input['nombre'];
$delegacion = $input['delegacion'];
$email = $input['email'];
$password = password_hash($input['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (nombre,delegacion, email, password) VALUES (?, ?, ?,?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nombre, $delegacion, $email, $password])) {
    echo json_encode([
        'message' => "$nombre registrado exitosamente ",
        'email'=> $email
    ]);
} else {
    echo json_encode(['message' => "Error al registrar $nombre"]);
}
?>

