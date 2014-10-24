<?php
   include 'classes/area_medica_crud.class.php';
   $am_cad = new AreaMedica();
   $ver = $am_cad->cadastraAreaMedica($_POST['area_medica']);
?>
