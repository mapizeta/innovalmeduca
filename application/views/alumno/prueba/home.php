
 
<div class="main-content" >

	<div class="wrap-content container" id="container">
	
     				
		<!-- start: FEATURED BOX LINKS -->
		<div class="container-fluid container-fullw bg-white">
    <div class="nina" style="float: left; position: fixed; z-index: 5000; margin-top: 154px; margin-left: -252px;">
           <img style="margin-top: -110px; margin-left: -39px; margin-right: -2px; width: 244px;" src="<?php echo base_url().'assets/images/ninaindicando.png'; ?>">
    </div>
    <div class="demo2" style="float: left;
    position: fixed;
    z-index: 5000;
    margin-top: 240px;
    margin-left: -252px;"></div>
    <div id='data-respondidas'style="float: left;
    background-color: #2C3541;
    font-size: 19px;
    width: 216px;
    position: fixed;
    z-index: 5000;
    margin-top: 332px;
    margin-left: -270px;"></div>
    <button type='button' id='finalizar' style=" background-color: #2F8FCE; border-color: #2F8FCE; float: left; position: fixed; z-index: 5000; margin-top: 465px; margin-left: -219px;" class='btn btn-primary btn-sm ' data-fancybox-type='iframe' href='<?php echo base_url('index.php/alumno/modal_finalizar_prueba/');?><?php  echo '/'; echo $id_asignacionprueba; echo '/'; echo $id_usuario; ?>'><i class='glyphicon glyphicon-off'></i> Finalizar Prueba</button>

      <div class="row">
				<div class="col-sm-12">
					<div class="table-responsive" style="padding-left: 94px; width: 1337px;">
              <div id='titulo'><?php echo $cabecera;?></div>
              <div id='titulo-separador'></div>
						  <div id='data-ensayo'><?php echo $ensayo; ?></div>
					</div>
				</div>
			</div>
		</div>
		<!-- end: FEATURED BOX LINKS -->

	</div>
</div>



<script type="text/javascript">
 
$(document).ready(function(){ 

  $.fancybox({
        'type'      : 'iframe',
        'href'      : '<?php echo site_url();?>/alumno/modal_instrucciones',
        'closeBtn'  : false,
        maxWidth    : 1800,
        maxHeight   : 1600,

         helpers    : { 
            overlay : { closeClick: false } // same as "hideOnOverlayClick" : false, in v1.3.4
         },
         keys : {
            close   : null // same as "enableEscapeButton" : false, in v1.3.4
         }
    });
  
  temporizador();


//setTimeout(function(){  

$('input[type="radio"]').click(function()
    {
        var id_respuesta = $(this).attr('id_respuesta');

        if($(this).attr('previousValue') == 'true')
        {      
          $(this).prop('checked', false)
          id_respuesta = '';  
        } 
        else 
        {
          $(this).attr('previousValue', false);
        }

        $(this).attr('previousValue', $(this).prop('checked')); 
        
        var id_pregunta = $(this).attr('id_pregunta');
        var id_asignacionprueba=<?php echo $id_asignacionprueba; ?>;
        var check = $("input").is(':checked');
        
        save(check, id_pregunta, id_respuesta, id_asignacionprueba);
    });


segundo();

//},500);

});

 function segundo(){

 
      var id_prueba= <?php echo $id_prueba;?>;
      var id_asignacionprueba = <?php echo $id_asignacionprueba;?>;
      var id_colegio          = <?php echo $id_colegio;?>;
      var id_usuario          = <?php echo $id_usuario;?>;
        
        $.ajax({
             url : '<?php echo site_url(); ?>/ensayo/respondidas/'+id_prueba+'/'+id_asignacionprueba+'/'+id_colegio+'/'+id_usuario,
           success: function(response){
             var data = $.parseJSON(response);
             $("#data-respondidas").html(data.filas);
          }      
        });
      
      setTimeout(function(){  

          $(".focus").click(function (e) {
          e.preventDefault();
          var id = $(this).attr('id');
          var x=$("#goto"+id).offset().top;
         
            $('html,body').animate({
                scrollTop: x-68
            }, 2000);
          });

      },1000);
}

/*
  function inicial(){
        
        var id_prueba           = <?php echo $id_prueba;?>;
        var id_asignacionprueba = <?php echo $id_asignacionprueba;?>;
        var id_colegio          = <?php echo $id_colegio;?>;
        var id_usuario          = <?php echo $id_usuario;?>;

        $.ajax({
             url : '<?php echo site_url(); ?>/ensayo/ensayo/'+id_prueba+'/'+id_asignacionprueba+'/'+id_colegio+'/'+id_usuario,
           success: function(response){
             var data = $.parseJSON(response);
             $("#data-ensayo").html(data.filas);
             temporizador();
          }      
        });  
      }
  */
  function temporizador(){
        
        var id_asignacionprueba = <?php echo $id_asignacionprueba;?>;
        
        $.ajax({
             url : '<?php echo site_url(); ?>/alumno/temporizador',
             type: 'post',
             data: {id_asignacionprueba:id_asignacionprueba},
           success: function(response){
             var data = $.parseJSON(response);
             //$("#data-ensayo").html(data.fecha);
             var termino= data.fecha;
             console.log(termino);

            
              $('.demo2').dsCountDown({

                        endDate: new Date(termino),
                        theme: 'black'
                      });


          }      
        });  
    
 }

      
  function save(check, pregunta, respuesta, ap)
  {
    var dato={check:check,id_pregunta:pregunta,id_respuesta:respuesta,id_asignacionprueba:ap};
    
    $.ajax({
            url : '<?php echo site_url();?>/alumno/save',
            type: 'get',
            data: dato,
            success: function(response){
            var data = $.parseJSON(response);
            if(data.option == 'logout')
               window.location = '<?php echo site_url();?>';  
            
            segundo();
                      
                  }
              });
  }   


$("#finalizar").fancybox({
  maxWidth :381,
  maxHeight : 240,
  padding   : 1,
  'closeBtn' : true,
});


  

 </script>

 

