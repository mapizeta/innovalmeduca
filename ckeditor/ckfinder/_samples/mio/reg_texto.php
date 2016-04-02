<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro Texto</title>
<style type="text/css">
	.class1 A:link {text-decoration: none; color:#0000CC;}
	.class1 A:visited {text-decoration: none; color:#0000CC;}
	.class1 A:active {text-decoration: none; color:#0000CC;}
	.class1 A:hover {text-decoration: underline;color:#0000CC;}
	
	.class2 A:link {text-decoration: none; color:#990000;}
	.class2 A:visited {text-decoration: none; color:#990000;}
	.class2 A:active {text-decoration: none; color:#990000;}
	.class2 A:hover {text-decoration: underline;color:#990000;}
	
	.class3 A:link {text-decoration: none; color:#000000;}
	.class3 A:visited {text-decoration: none; color:#000000;}
	.class3 A:active {text-decoration: none; color:#000000;}
	.class3 A:hover {text-decoration: underline;color:#000000;}
	.Estilo2 {font-size: 12px;}
	
	.fuente{font-size:12px;font-family: Arial, Helvetica, sans-serif;}
	.fuente_arial{
		font-size:12px;
		font-family:Arial, Helvetica, sans-serif;
	}
</style>

<script>
function pregunta(formObj) 
{ 
	if(!confirm("Desea eliminar este enlace")) 
	{ 
    return false;
	} 
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body class="fuente_arial">
<p align="center" class="class1 fuente"><a href="../index.html">Volver</a></p>
<table width="" border="0" align="center" bordercolor="#FFFFFF" style="font-size:12px " class="fuente_negra">
	<tr>
		<td> Base de Datos</td>
	</tr>
</table>

<?php 
include("../../conexion/conectar.php"); 
$link=Conectarse(); 
$sql = "SELECT te_id, te_titulo, te_contenido, te_activo FROM texto_te";
$result=mysql_query($sql,$link);
$num_rows = mysql_num_rows($result);
?> 

<form name="Me">

<?php
if( $num_rows!=0){
?> 
<TABLE width="" border="0" align="center" bordercolor="#FFFFFF" style="font-size:12px ">
	<tr>
		<td align="center"><strong>Total de Registros:&nbsp;<?php echo $num_rows; ?> </strong></td>
	</tr>
</table>
<p align="center" class="class1 fuente"><a href="pag_01.php">Agregar Nuevo</a></p>

<TABLE  BORDER=1 align="center" CELLPADDING=0 CELLSPACING=0 > 
	<TR bgcolor="#000099" style="color:#FFFFFF;font-size:12px">
		<TD>&nbsp;NOMBRE&nbsp;</TD>
		<TD>&nbsp;</TD>
		<TD>&nbsp;</TD>
	 </TR>
	<?php
	$num_fila = 0; //creo e inicializo la variable para contar el número de filas 
	while($row = mysql_fetch_array($result)) //bucle para mostrar los resultados 
   	{ 
		$id_texto=$row["te_id"];
		$tit_texto=$row["te_titulo"];
		$cont_texto=$row["te_contenido"];
		
			if ($numero_fila++%2==0) 
	 		{
	 			$color_fila="#FFFFFF";
	 		}
	 		else
	 		{
	 			$color_fila="#D7F8FF";
	 		}
	  ?> 
   
 	<tr bgcolor='<?php echo $color_fila ?>'>
	  <td style='font-size:12px' class='class1' align='' valign='top'>&nbsp;<?php echo $tit_texto ?></td>
	   <td class='class1 fuente' valign="top">&nbsp;<a href="editar_te.php?id=<?php echo $id_texto ?>">EDITAR</a>&nbsp;</td>
	   <td class='class1 fuente' valign="top">&nbsp;<a href="ver_te.php?id=<?php echo $id_texto ?>"><img src="../../imagenes/search_48.png" border="0" height="20" width="20"></a>&nbsp;</td>
	</tr>
	 
	 <?php
  $num_fila++;
  } 
   mysql_free_result($result); 
   ?>
   </table>
	<?php
    }
	else{
  ?>
  
      <p style="font-size:12px " align="center"><span class="Estilo2">ACTUALMENTE NO HAY TEXTOS</span></p>
    
	    <?php
  }
  mysql_close($link);
  ?>


</form>
</body>
</html>



