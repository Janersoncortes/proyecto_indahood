<?php
    include "connect.php";

    $nombre = $_POST["name"];
    $apellido = $_POST["lastname"];
    $id = $_POST["id"];
    $edad = $_POST["age"];
    $genero = $_POST["gender"];
    $tipoUsuario = $_POST["kindUser"];
    $ciudad = $_POST["city"];
    $username = $_POST["username"];
    $password = $_POST["password"];




    $sql = "INSERT INTO registro (nombres, apellidos, id, edad, genero, ciudad, tipoUsuario, login, contrasena)VALUES ('$nombre', '$apellido', '$id', $edad, '$genero', '$ciudad', '$tipoUsuario', '$username', '$password')";

    if(mysqli_query($conn, $sql)) {
        echo "hecho";
    }else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

?>

