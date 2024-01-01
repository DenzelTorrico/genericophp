<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<?php


require("../database/generictable.php");
//require("../modals/insertdata.php");

// Recupera la ruta desde el parámetro
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : '';
echo "<script>
alerta()
</script>";
//INSERTAR

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["eliminar"])){
            $id = $_POST["delete_id"];
           // echo $id;
            $genericTable->DeleteToTable($ruta,$id);
    }else{
        $datosPost = [];

        foreach ($_POST as $key => $values) {
            $datosPost[$key] = htmlspecialchars($values);
        }
        $genericTable->InsertIntoTable($ruta, $datosPost);
       
    }
}

// Define los mensajes correspondientes a las rutas

$listclass = $genericTable->GetTableCreated();
// Verifica si la ruta solicitada está definida
if (in_array($ruta, $listclass)) {
    // Muestra el mensaje para la ruta específica
?>

<div class="content">
        <div class="sidebar">

            <?php

                require("./layouts/sidebar.php");
            
            ?>
        </div>

        <div class="body container mt-2">
            <table class="table">
                <h1>Tabla de <?= $ruta ?></h1>


                <tr>
                    <?php
                    foreach ($genericTable->GetColumnTable($ruta) as $columns) {
                        echo "<th>" . $columns["Field"] . "</th>";
                    }
                    ?>
                    <th>Eliminar</th>
                    <th>Actualizar</th>
                </tr>
                <?php
foreach ($genericTable->GetDataTable($ruta) as $data) {
    echo "<tr>";
    foreach ($genericTable->GetColumnTable($ruta) as $columns) {
        echo "<td>" . $data[$columns["Field"]] . "</td>";
    }

    // Agregar botón de eliminación
    echo "<td>";
    echo "<form method='post' action='$ruta'>";
    echo "<input type='hidden' name='delete_id' value='" . $data['id'] . "'>"; // Ajusta según el nombre de tu clave primaria
    echo "<button type='submit' name='eliminar' class='btn btn-danger'>Eliminar</button>";
    echo "</form>";
    echo "</td>";

    // Agregar enlace de actualización
    echo "<td><a href='/actualizar?id=" . $data['id'] . "'>Actualizar</a></td>";

    echo "</tr>";
}
?>


            </table>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Agregar Data
            </button>

            <!-- Button trigger modal -->
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregando..</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form name="formulario" action="<?php echo $ruta ?>" method="post">
                            <div class="modal-body">
                                <?php
                                foreach ($genericTable->GetColumnTable($ruta) as $column) {
                                    if($column["Field"] != "id"){
                                        echo "<label class='form-label'>" . $column["Field"] . "</label>";
                                        echo '<input required type="text" class="form-control" name="' . $column['Field'] . '" />';
                                    }
                                }

                                ?>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Guardar Datos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
<?php
} else {
    // Muestra un mensaje de error si la ruta no se encuentra
    echo '404 - Ruta no encontrada';
}

?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>