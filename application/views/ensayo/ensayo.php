

<div class="main-content" >

	<div class="wrap-content container" id="container">
						
		<!-- start: FEATURED BOX LINKS -->
		<div class="container-fluid container-fullw bg-white">

			<div class="row">
				<div class="col-sm-12">
					<div class="table-responsive">
              <div id='titulo' style=" margin-left: 138px;"><?php echo $cabecera;?></div>
              <div id='titulo-separador'></div>
						  <div id='data-ensayo' style="margin-left: 138px;"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- end: FEATURED BOX LINKS -->

	</div>
</div>
<script type="text/javascript">
 
$(document).ready(function(){ 
  inicial();

});



  function inicial(){
        
        var id_prueba  = <?php echo $id_prueba;?>;

        $.ajax({
             url : '<?php echo site_url(); ?>/ensayo/visualizar_ensayo/'+id_prueba,
           success: function(response){
             var data = $.parseJSON(response);
             $("#data-ensayo").html(data.filas);
          }      
        });  
      }
      

 </script>

 

