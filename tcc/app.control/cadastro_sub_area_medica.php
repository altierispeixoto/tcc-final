<?php
include 'classes/sub_area_medica_crud.class.php';
$subareamedica = new SubAreaMedica();
$subareamedica ->cadastraSubAreaMedica($_POST['sub_area'],$_POST['id_area_medica']);
?>
