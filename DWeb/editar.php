<?php

$conn = mysqli_connect("localhost", "root", "", "inventario");


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$codigo = $_GET["codigo"];
$sql = "SELECT * FROM productos WHERE codigo='$codigo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Editar Producto</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <h1>Editar Producto</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?codigo='.$codigo; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $row["nombre"]; ?>" required><br><br>
            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo $row["categoria"]; ?>" required><br><br>
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo $row["cantidad"]; ?>" required><br><br>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo $row["descripcion"]; ?></textarea><br><br>
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $row["precio"]; ?>" required><br><br>
            <input type="submit" name="accion" value="Actualizar">
        </form>
    </body>
    </html>
    <?php
} else {
    echo "No se encontró el producto.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"]) && $_POST["accion"] == "Actualizar") {
    $nombre = $_POST["nombre"];
    $categoria = $_POST["categoria"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    $sql = "UPDATE productos SET nombre='$nombre', categoria='$categoria', cantidad='$cantidad', descripcion='$descripcion', precio='$precio' WHERE codigo='$codigo'";

    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>