<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD y formulario dinámico</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>CONSULTA A TABLA SEGÚN FILTRADO DE FORMULARIO</h1>
    <table>
        <tr>
            <th>Id Usuario</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Fecha de alta</th>
            <th>Rol</th>
        </tr>
        <?php
        include './includes/_conexion_bbdd.php';

        if(isset($_POST['nombre'])){
            $filtrarPorNombre=$_POST['nombre'];
            $filtrarPorRol=$_POST['rol'];
            $sql="SELECT * FROM usuarios INNER JOIN roles WHERE usuarios.id_rol=roles.id_rol AND nombre LIKE '%$filtrarPorNombre%' AND rol='$filtrarPorRol'";
        }else{
            $sql="SELECT * FROM usuarios INNER JOIN roles WHERE usuarios.id_rol=roles.id_rol";
        }
        
        $resultado=mysqli_query($con,$sql);
        if(mysqli_num_rows($resultado)>0){
            while($fila = mysqli_fetch_array($resultado)){
        ?>
        <tr>
            <td><?=$fila['id_usuario']?></td>
            <td><?=$fila['nombre']?></td>
            <td><?=$fila['email']?></td>
            <td><?=$fila['telefono']?></td>
            <td><?=$fila['fecha_alta']?></td>
            <td><?=$fila['rol']?></td>
        </tr>

        <?php
            }
        }
        ?>        
    </table>    
    
    <form action="./index.php" method="post">
        <input type="text" name="nombre">
        <select name="rol">
            <?php
            $sql="SELECT * FROM roles";
            $resultado=mysqli_query($con,$sql);
            if(mysqli_num_rows($resultado)>0){
                while($fila=mysqli_fetch_array($resultado)){
                    echo "<option value=".$fila['rol'].">".$fila['rol']."</option>";
                }
            }
            ?>            
        </select>
        <input type="submit" value="Buscar">
    </form>
    

</body>
</html>