<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Importar de Excel a la Base de Datos ::</title>
</head>

<body>
<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->
Selecciona el archivo a importar:
<form name="importa" method="post" action="<?php echo base_url();?>index.php/import/puntaje" enctype="multipart/form-data" >
<input type="file" name="excel" />
<input type='submit' name='enviar'  value="Importar"  />
<input type="hidden" value="upload" name="action" />
</form>

</body>
</html>