<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<?php

require("../database/generictable.php");
//require("../modals/insertdata.php");




// Recupera la ruta desde el parámetro
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : '';

//INSERTAR

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $datosPost = [];
    
    foreach($_POST as $key => $values) {
        $datosPost[$key] = htmlspecialchars($values);
    }
    echo $genericTable->InsertIntoTable($ruta,$datosPost);
}

// Define los mensajes correspondientes a las rutas

$listclass = $genericTable->GetTableCreated();
// Verifica si la ruta solicitada está definida
if (in_array($ruta, $listclass)) {
    // Muestra el mensaje para la ruta específica
?>
    <table class="table container">
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
            echo "<td><a href=''>Eliminar</a></td>";
            echo "<td><a href='/actualizar'>Actualizar</a></td>";

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
            echo "<label class='form-label'>".$column["Field"]."</label>";
            echo '<input required type="text" class="form-control" name="' . $column['Field'] . '" />';
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

<?php
} else {
    // Muestra un mensaje de error si la ruta no se encuentra
    echo '404 - Ruta no encontrada';
}

?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>