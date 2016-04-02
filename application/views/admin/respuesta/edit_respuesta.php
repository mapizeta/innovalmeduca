<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	
	CKEDITOR.instances['editor'].on('change', function() {
	CKEDITOR.instances['editor'].updateElement() 
		
	});

	var id_pregunta = <?php echo $id_pregunta;?>;
	var id_respuesta = <?php echo $id_respuesta;?>;

	var muestra = { display : 'inline' };
    var esconde = { display : 'none' };

    $('#data_muestra').css(esconde);

	/*
	$.ajax({
            url:'<?php echo site_url();?>/respuesta/verificar_resp_cor/'+id_pregunta+'/'+id_respuesta,
            success: function(response){
              var json = eval("(" + response + ")");

              $("#data_muestra").html(json.filas);

          
          }});
	*/

	setTimeout(function()
	{	
		$("#escorrecta").change(function() {
    	//get the selected value
    	var selectedValue = this.value;

    	$.ajax({
        	
        	url:'<?php echo site_url();?>/respuesta/verificar_resp_cor/'+id_pregunta+'/'+id_respuesta,
        	type: 'POST',
        	data: {option : selectedValue},

        	success: function(response) 
        	{
        		 var json = eval("(" + response + ")");
            	//console.log(selectedValue);
            	//alert(selectedValue);
            	$("#data_muestra").html(json.filas);

            		console.log(json.filas);

            		if(json.filas!=""){
            			$('#enviar').attr("disabled", true);
            			$('#data_muestra').css(muestra);
            		}
            		else
            		{
            			$('#enviar').attr("disabled", false);
            			$('#data_muestra').css(esconde);
            		}
        	}
    	});
		});


	}, 500);



	 $('#enviar').click(function(){
		
	//console.log($("form").serialize());
	    		
		$.post("<?php echo site_url().'/respuesta/save/'.$id_respuesta;?>" , $("form").serialize(), 
	        function(data){
	        	alert(data.mensaje);
	            parent.location.reload();
	            /*
	            var success = data.success;
	            //alert(success);
	            if( success == 'success'){
	            	parent.location.reload();
	            }else{
	              alert("No se actualizo");
	            }
*/
	        }, 'json');
		
	    return false;
	
	});
    $('.cerrar').click(function(){
      parent.$.fancybox.close();
      return false;
    })
});
</script>
<div class="modal-header modal-comun">
        <button type="button" class="close cerrar" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-comun"><b>Editar Alternativa</b></h4>
        <div class='icono-add'><img src="<?php echo base_url();?>assets/images/icon-editarprueba.svg" height="32px"></div>
</div>
  <div class="modal-body">

	<?php echo $data; ?>	
	<!--<div id="data_muestra"></div>-->

	<div id="data_muestra" class="alert alert-danger" role="alert" style="padding-left:225px;padding-right:225px;"></div>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-cancelar cerrar" data-dismiss="modal">Cancelar</button>
    <a id="enviar" href="#" class="btn btn-crear">Editar</a>
  </div>