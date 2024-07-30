<?php
$host = 'localhost';
$db = 'tandem_qr_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsnWithoutDB = "mysql:host=$host;charset=$charset";
$dsnWithDB = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Conectar sin especificar la base de datos para poder crearla
    $pdo = new PDO($dsnWithoutDB, $user, $pass, $options);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    echo "Base de datos creada con éxito.\n";
    
    // Conectar a la base de datos recién creada
    $pdo = new PDO($dsnWithDB, $user, $pass, $options);

    // Crear tablas
    $sql = file_get_contents("init-db.sql");
    $pdo->exec($sql);
    echo "La base de datos y las tablas se han creado con éxito.\n";

    // Añadir usuario admin por defecto
    $adminName = 'admin';
    $adminEmail = 'admin@example.com';
    $adminPassword = 'admin_password'; // Cambia esta contraseña por la que desees
    $adminPasswordHashed = password_hash($adminPassword, PASSWORD_DEFAULT);
    $adminRole = 'admin';

    $stmt = $pdo->prepare("INSERT INTO users (nombre, email, password, role) VALUES (:nombre, :email, :password, :role)");
    $stmt->execute([
        'nombre' => $adminName,
        'email' => $adminEmail,
        'password' => $adminPasswordHashed,
        'role' => $adminRole
    ]);

    $adminId = $pdo->lastInsertId();

    // Añadir QR de inicio por defecto
    $qrData = 'Inicio QR';
    $qrNombreRef = 'QR de Inicio';
    $qrDescription = 'Este es un código QR de ejemplo para inicio.';
    
    $stmt = $pdo->prepare("INSERT INTO qr_codes (data, nombre_ref, description, created_by) VALUES (:data, :nombre_ref, :description, :created_by)");
    $stmt->execute([
        'data' => $qrData,
        'nombre_ref' => $qrNombreRef,
        'description' => $qrDescription,
        'created_by' => $adminId
    ]);

    echo "Usuario admin y QR de inicio creados con éxito.";

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
