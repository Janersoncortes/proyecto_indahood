<?php

$conn = mysqli_connect("localhost", "root", "", "inventario");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$codigo = $_GET["codigo"];
$sql = "DELETE FROM productos WHERE codigo='$codigo'";

if ($conn->query($sql) === TRUE) {
    echo "Producto eliminado exitosamente";
} else {
    echo "Error al eliminar el producto: " . $conn->error;
}

$conn->close();
header("Location: index.php"); // Redirigir a la página principal
exit();
?>