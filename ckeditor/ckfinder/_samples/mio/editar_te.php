<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
 * CKFinder
 * ========
 * http://ckfinder.com
 * Copyright (C) 2007-2010, CKSource - Frederico Knabben. All rights reserved.
 *
 * The software, this file and its contents are subject to the CKFinder
 * License. Please read the license.txt file before using, installing, copying,
 * modifying or distribute this file or part of its contents. The contents of
 * this file is part of the Source Code of CKFinder.
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>editar texto</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<link href="../sample.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../../../ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="../../ckfinder.js"></script>
	
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
</head>
<body>
<p align="center" class="class1 fuente"><a href="reg_texto.php">Volver</a></p>
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

<form name="Me" method="post" action="fun_edit_texto.php">
<input type="HIDDEN" name="hidden_id" size="" class="fuente" value="<?php echo $id ?>">
Título<input type="text" name="text_titulo" size="60" class="fuente" value="<?php echo $tit_texto ?>">
	<h1>
		CKFinder - Sample - CKEditor Integration
	</h1>
	<hr />
	<p>
		CKFinder can be easily integrated with CKEditor. Try it now, by clicking
		the "Image" or "Link" icons and then the "<strong>Browse Server</strong>" button.</p>
	<p>
	<textarea id="editor1" name="editor1" rows="10" cols="80"><?php echo $cont_texto ?></textarea>

		<script type="text/javascript">

// This is a check for the CKEditor class. If not defined, the paths must be checked.
if ( typeof CKEDITOR == 'undefined' )
{
	document.write(
		'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
		'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
		'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
		'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
		'value (line 32).' ) ;
}
else
{
	var editor = CKEDITOR.replace( 'editor1' );
	editor.setData( );
	//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
	

	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	CKFinder.setupCKEditor( editor, '../../' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
}

		</script>
		
	</p>
	<div align="center"><input type="submit" name="submit_agregar" value="Editar" onClick=""></div>
	
</form>
</body>
</html>

