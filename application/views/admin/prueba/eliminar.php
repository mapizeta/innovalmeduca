<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">

<script type="text/javascript">
$(document).ready(function() {
	 $('#enviar').click(function(){
	    		
		$.post("<?php echo site_url();?>/prueba/delete/" , $("form").serialize(), 
	        function(data){
	            var success = data.success;
	            //alert(success);
	            if( success == 'success'){
	            	alert('prueba eliminada con éxito');
	            	parent.location.reload();
	            }else{
	              alert('ocurrió un error al eliminar');
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

  <div class="modal-header modal-title-delete" style="height: 56px;">
  	<div style="float:right;margin-top:-15px;margin-left:326px;position:absolute;"><a href="#" class="cerrar"><img src="<?php echo base_url().'assets/images/modal-delete/x-normal.jpg'?>" onmouseover="this.src='<?php echo base_url().'assets/images/modal-delete/x-hover.jpg'?>';" onmouseout="this.src='<?php echo base_url().'assets/images/modal-delete/x-normal.jpg'?>';"></a></div>
  	    
  </div>
  <div class="modal-body modal-body-delete" style="margin-top: -1px;">

	<?php echo $data; ?>	

  </div>
  <div class="modal-footer">
  	<?php echo $data_button; ?>	
  </div>
 