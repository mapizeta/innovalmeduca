<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>prueba</title>
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">
</head>


<body>
	<div class="modal-header modal-comun">
        <button type="button" class="close cerrar" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Editar Estado</b></h4>
  </div>
  <div class="modal-body" >
    <form method="post" id="formulario">
      <div id="data"><?php echo $data; ?></div>
  </div>      
  <div class="modal-footer">
    <button type="button" class="btn btn-cancelar cerrar" data-dismiss="modal">Cancelar</button>
    <button type="button" class="btn btn-crear" id="enviar">Continuar</button>
  </div>
    </form>

<script type="text/javascript">
  $(document).ready(function() {
	 $('#enviar').click(function(){
	   
	
		$.post("<?php echo site_url();?>/profesor/cambiar_estado/"+<?php echo $asignacion;?>+"/"+<?php echo $estado;?> ,
	        function(data){
	            var success = data.success;
	            //alert(success);
	            if( success == 'success'){
	            	alert('Operación exitosa');
	            	parent.location.reload();
	            }else{
	              alert('ocurrió un error, comunicarse con el área de soporte');
	            }
	        }, 'json');
		
	    return false;
	});
    $('.cerrar').click(function(){
      parent.$.fancybox.close();
      return false;
    })

});
</script>

</body>
</html>