<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD y formulario dinámico</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include './includes/_nav.php';?>

    <h1>CONSULTA A TABLA Y PAGINACIÓN POR GET</h1>
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
        if(isset($_GET['p'])){
            $numPaginaMostrar = $_GET['p'];
        }else{
            $numPaginaMostrar = 1;
        }

        include './includes/_conexion_bbdd.php';        
        $sql="SELECT * FROM usuarios INNER JOIN roles WHERE usuarios.id_rol=roles.id_rol";        
        $resultado=mysqli_query($con,$sql);
        if(mysqli_num_rows($resultado)>0){
            $numeroTotalRegistros = mysqli_num_rows($resultado);
            $registrosPorPagina=10;
            $numeroPaginasTotales=ceil($numeroTotalRegistros/$registrosPorPagina);
            $hastaRegistro=$numPaginaMostrar*$registrosPorPagina; //si es la página 4, debe mostrar desde el 41 hasta el 50 (4*10=40+10=50)
            $desdeRegistro=$hastaRegistro-$registrosPorPagina; //a efectos desde qué registro, restamos 9 al valor de hastaRegistro, en el ejemplo 50-9=41
            
            echo "Número total de registros: ".$numeroTotalRegistros."<br>";            
            echo "Registros por página: ".$registrosPorPagina."<br>";            
            echo "Número total de páginas".$numeroPaginasTotales."<br>";
            echo "Se muestran registros desde el ".$desdeRegistro." hasta el ".$hastaRegistro."<br>";

            unset($resultado,$sql);

            $sql="SELECT * FROM usuarios INNER JOIN roles WHERE usuarios.id_rol=roles.id_rol ORDER BY nombre ASC LIMIT $registrosPorPagina OFFSET $desdeRegistro";            
            $resultado=mysqli_query($con,$sql);
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
        ?>        
    </table>    
    <div class="paginacion">
    <?php
            for($i=1; $i<=$numeroPaginasTotales; $i++){
    ?>    
        <a href="index3.php?p=<?=$i?>"><?=$i?></a>     
    <?php
            }
            unset($resultado,$sql);       
        }else{
            unset($resultado,$sql);
            echo "No existen datos en la BBDD";
        }
    ?>
    </div>

</body>
</html>