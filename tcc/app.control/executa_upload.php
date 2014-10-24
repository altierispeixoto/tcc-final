<?php 
 set_time_limit(0);
 include_once 'classes/imagem.class.php';
 $upload = new Imagem();
 $upload ->realizaUpload($_FILES['imagem']['tmp_name'],
         $_FILES['imagem']['name'],$_FILES['imagem']['size'],
         $_POST['patologia'],$_POST["obs"],$_POST["diagnostico"],
         $_POST["categoria"],$_POST["composicao"]);
?>