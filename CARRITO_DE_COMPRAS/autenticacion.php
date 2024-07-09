<?php

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'login-php';

// conexion

$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Fallo en la conexión de MySQL:' . mysqli_connect_error());
}

// Se valida la información

if (!isset($_POST['username'], $_POST['password'])) {

    // Si no hay datos muestra error y redirecciona

    header('Location: index.html');
}

// evitar hackeo inyección sql

if ($stmt = $conexion->prepare('SELECT id,password FROM accounts WHERE username = ?')) {

    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
}

//validacion de datos en base a la base de datos

$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password);
    $stmt->fetch();

    if ($_POST['password'] === $password) {

        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;
        header('Location: inicio.php');
    }
} else {

    header('Location: index.html');
}

$stmt->close();
?>
<a href="producto.php" class="btn btn-primary">Ir a Productos</a>