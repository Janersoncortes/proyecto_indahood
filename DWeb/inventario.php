<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos</title>
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
    <h1>Inventario de Productos</h1>

    <h2>Agregar Producto</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required><br><br>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria" required><br><br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required><br><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>
        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" required><br><br>
        <input type="submit" name="accion" value="Agregar">
    </form>

    <h2>Productos en Inventario</h2>
    <table>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Cantidad</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php

        $conn = mysqli_connect("localhost", "root", "", "inventario");

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"]) && $_POST["accion"] == "Agregar") {
            $codigo = $_POST["codigo"];
            $nombre = $_POST["nombre"];
            $categoria = $_POST["categoria"];
            $cantidad = $_POST["cantidad"];
            $descripcion = $_POST["descripcion"];
            $precio = $_POST["precio"];

            $sql = "INSERT INTO productos (codigo, nombre, categoria, cantidad, descripcion, precio) VALUES ('$codigo', '$nombre', '$categoria', '$cantidad', '$descripcion', '$precio')";

            if ($conn->query($sql) === TRUE) {
                echo "Producto agregado exitosamente";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["codigo"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["categoria"] . "</td>";
                echo "<td>" . $row["cantidad"] . "</td>";
                echo "<td>" . $row["descripcion"] . "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td>
                    <a href='editar.php?codigo=" . $row["codigo"] . "'>Editar</a>
                    <a href='eliminar.php?codigo=" . $row["codigo"] . "'>Eliminar</a>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay productos en el inventario</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>