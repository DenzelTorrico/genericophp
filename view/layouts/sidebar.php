<?php
$output = null;
$returnCode = null;

// Ejecutar el comando Git y capturar la salida y el código de retorno
exec('git rev-parse --abbrev-ref HEAD 2>&1', $output, $returnCode);

if ($returnCode === 0) {
    $currentBranch = trim(implode("\n", $output));
} else {
    // Manejar el error, por ejemplo, mostrando un mensaje de error o registrándolo
    echo 'Error al obtener el nombre de la rama: ' . implode("\n", $output);
}
?>


<div class="sidebar-body">
    <div>
        <img style="width: 150px;" src="../images/logo.png" alt="" srcset="">
    </div>
    <div>
        <ul><a href="productos">productos</a></ul>
        <ul><a href="usuarios">Usuarios</a></ul>
        <ul><a href="comida">Comida</a></ul>
        <ul><a href="tables">Tablas</a></ul>

    </div>
</div>