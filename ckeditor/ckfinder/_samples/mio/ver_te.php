<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Ver texto</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../sample.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
$id=$_GET["id"];
include("../../conexion/conectar.php"); 
$link=Conectarse(); 
$sql = "SELECT te_id, te_titulo, te_contenido, te_activo FROM texto_te WHERE te_id='$id'";
$result=mysql_query($sql,$link);
$num_rows = mysql_num_rows($result);
while($row = mysql_fetch_array($result)) //bucle para mostrar los resultados 
{ 
	$id_texto=$row["te_id"];
	$tit_texto=$row["te_titulo"];
	$cont_texto=$row["te_contenido"];
}
mysql_free_result($result); 
?>

<?php echo $cont_texto ?>
</body>
</html>
