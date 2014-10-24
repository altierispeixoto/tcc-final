<?php
include_once 'classes/patologia_crud.class.php';
$patologia = new PatologiaCrud();
$patologia->cadastraPatologia($_POST['id_area_medica'],$_POST['patologia'],$_POST['id_subarea']);
?>
