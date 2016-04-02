<?php
$titulo=$_POST["text_titulo"];

$texto=$_POST["editor1"];
//$texto_1=str_replace("""","''",$texto);
$buscar = stripslashes($texto); 

//echo $buscar;


include("../../conexion/conectar.php");
$link=Conectarse(); 
$sql = "SELECT max(te_id) AS maximocod FROM texto_te";
$recordset = mysql_query($sql,$link);  
$fila = mysql_fetch_array($recordset);
if (($fila['maximocod'])== NULL)
{
$max_texto = 1;
}
else
{
$max_texto=$fila['maximocod']+1;
}

$link=Conectarse(); 
$sql = "INSERT INTO texto_te(te_id,te_titulo,te_contenido,te_activo)VALUES('$max_texto','$titulo','$buscar','1')";
mysql_query($sql,$link); 

echo $sql;
header("Location: reg_texto.php");
?>