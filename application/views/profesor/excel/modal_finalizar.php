<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">

<script type="text/javascript">
$(document).ready(function() {
	 $('#enviar').click(function(){
	    		
		$.post("<?php echo site_url();?>/profesor/finalizar_prueba/" , $("form").serialize(), 
	        function(data){
	            var success = data.success;
	            //alert(success);
	            if( success == 'success'){
	            	alert('La prueba ha sido finalizada con éxito');
	            	parent.location.reload();
	            }else{
	              alert('ocurrió un error al finalizar, comunicarse con el área de soporte');
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

  <div class="modal-header modal-title-alert" style="height: 56px;">
  	<strong style="color:white; margin-left: 120px;">FINALIZAR PRUEBA</strong>
  </div>
  <div class="modal-body modal-body-alert" style="margin-top: -1px;">

	<?php echo $data; ?>	

  </div>
  <div class="modal-footer">
  	<?php echo $data_button; ?>	
  </div>
 