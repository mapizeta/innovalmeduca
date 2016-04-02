<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	 $('#enviar').click(function(){
	    		
		$.post("<?php echo site_url();?>/prueba/delete/" , $("form").serialize(), 
	        function(data){
	            var success = data.success;
	            //alert(success);
	            if( success == 'success'){
	            	console.log('fracaso');
	            	//parent.location.reload();
	            }else{
	              parent.location.reload();
	            }
	        }, 'json');
		
	    return false;
	});
	$('#cerrar').click(function(){
		parent.$.fancybox.close();
		return false;
	})
});
</script>
  <div class="modal-header">
    <h3>Eliminar Prueba:</h3>
  </div>
  <div class="modal-body">

	<?php echo $data; ?>	

  </div>
  <div class="modal-footer">
  	<a id="cerrar" href="#" class="btn">Cerrar</a>
    <a id="enviar" href="#" class="btn btn-danger">Continuar</a>
  </div>