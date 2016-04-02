<?php
$id=$_POST["hidden_id"];
$titulo=$_POST["text_titulo"];

$texto=$_POST["editor1"];
$texto_def = stripslashes($texto); 

include("../../conexion/conectar.php");
$link=Conectarse(); 
$sql = "UPDATE texto_te SET te_titulo='$titulo',te_contenido='$texto_def' WHERE te_id='$id'"; 
mysql_query($sql,$link); 

//echo $sql;
header("Location: editar_te.php?id=$id");
?>