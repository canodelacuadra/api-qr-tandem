<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require '../config/database.php';

$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'];
$password = $input['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode(['message' => 'Login exitoso', 'user' => $user]);
} else {
    echo json_encode(['message' => 'Credenciales incorrectas']);
}
?>
