<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">

<script type="text/javascript">
$(document).ready(function() {
		
	$('.habilitar').click(function(){
	    
	    var id_usuario = $(this).attr('id');
		var url = '<?php echo "/".$colegio."/".$id_asignacionprueba; ?>';

		
		$.ajax({
            url:'<?php echo site_url();?>/profesor/habilitar_alumno/'+id_usuario+url,
            success: function(response){
              var json = eval("(" + response + ")");

              if(json.success == 'success')
              {
              	alert('Operación exitosa');
	            parent.location.reload();
              }
              else
	          {
	            alert('ocurrió un error, comunicarse con el área de soporte');
	          }
          
          }});

	});

	$('.cerrar').click(function(){
		parent.$.fancybox.close();
		return false;
	})
});
</script>
<div class="modal-body" style="margin-top: -1px;">
	<?php echo $alumnos; ?>	
</div>

 