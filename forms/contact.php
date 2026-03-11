<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Metodo no permitido');
}

$nombre   = trim($_POST['nombre'] ?? '');
$email    = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$motivo   = trim($_POST['motivo'] ?? '');
$mensaje  = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $email === '' || $motivo === '' || $mensaje === '') {
  exit('Faltan campos obligatorios');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  exit('Email invalido');
}

$host = '127.0.0.1';
$db   = 'contactos_porfolio';
$user = 'root';
$pass = 'nefertari25';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);

  $sql = "INSERT INTO contactos (Nombre, Email, Telefono, Motivo, Mensaje)
          VALUES (:nombre, :email, :telefono, :motivo, :mensaje)";
  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    ':nombre' => $nombre,
    ':email' => $email,
    ':telefono' => $telefono,
    ':motivo' => $motivo,
    ':mensaje' => $mensaje
  ]);

  echo 'OK';
} catch (PDOException $e) {
  echo 'Error al guardar: ' . $e->getMessage();
  echo 'Error al guardar';
}