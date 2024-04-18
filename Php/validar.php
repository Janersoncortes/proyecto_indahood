<?php

include 'connect.php';

$login = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT nombres, apellidos, tipoUsuario  FROM registro WHERE login ='$login' AND contrasena = '$password'";
$result = mysqli_query($conn, $sql);

//mysqli_num_rows obtiene al numero de filas de unca consulta realizada

if (mysqli_num_rows($result) > 0) {
  
    while($row = mysqli_fetch_assoc($result)) //mysql_fetch_assoc() devuelve una matriz de los registros que ha encontrado.
    {
        // echo "El usuario existe en la base de datos ";
        //echo "consecutivo: " . $row["cont"]. " - Nombre: " . $row["nombres"]. " Apellidos " . $row["apellidos"]. " Tipo de Usuario" . $row["tipoUsuario"] . "<br>";
        // echo "Bienvenido". "<br>";
        $tipoUserDB = $row["tipoUsuario"];
        // echo $tipoUserDB;
        
        switch ($tipoUserDB)
            {
             case "super": {
                header("Location: ../Dweb/SuperAdmin.html");
                break;
             }

             case "admin": {
                header("Location: ../Dweb/inventario.html");
                break;
             }

             case "visitant": {
                header("Location: ../Dweb/tienda.html");
                echo"Estás en visitant";
                break;
             }



            }
        //

    }

    }  
    else 
     {
    echo "No existe en la base de datos ";
    header("Location: /Dweb/ErrorUsuario.html");
     }
  

mysqli_close($conn);

?>