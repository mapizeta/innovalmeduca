
<div class="main-content" "margin-top: 65px;" >
  <div class="wrap-content container" id="container" style="margin-top: 23px;">      
    <div class="row">
      <div class="col-sm-12" style="margin-bottom: 100px;">
        <div class="nina" style="float: left; position: fixed; z-index: 5000; margin-top: 154px; margin-left: -252px;">
           <img style="margin-top: -103px; margin-left: -26px; margin-right: 13px; width: 230px;" src="<?php echo base_url().'assets/images/ninadialogo.png'; ?>">
        </div>    
        <div style=" margin-top: 31px;">
            <center>
              <img  src="<?php echo base_url()?>assets/images/colorrepresentativo.svg">
            </center>
        
            <div style=" height:67px; color: white!important;  background-color: #2f8fce ;margin-left: 1px; margin-bottom: -87px; margin-top: 4px;">
              <img style="margin-top: 6px; margin-left: 9px; margin-right: 13px; " src="<?php echo base_url().'assets/images/pruebasdisponibles.svg'; ?>">
              <strong>PRUEBAS DISPONIBLES</strong>
            </div >


            <div id="tabla1" style="display: none; margin-top: 88px;">
              <table class="table table-bordered table-hover table-striped" id="data">
              </table>
            </div>

            <div class="row">
              <div class="col-lg-offset-4" style="margin-top: 8%">
                <div id="loader" style="display: block">
                  <img src="<?php echo base_url().'assets/images/loader_nube.gif'; ?>">
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){


setTimeout(function(){    

    

    javascript:hiddenShowTable('tabla1');
    javascript:hiddenShowTable('loader');




    $(".btn").click(function(){

     var usuario_id=<?php echo $id_usuario;?>;
     //var prueba_id = $(this).attr('id_prueba');
     var asignacion_id = $(this).attr('id_asignacion');
     var dato={asignacion_id:asignacion_id};
     console.log(dato);


     $.ajax({
           url : '<?php echo site_url();?>/alumno/init',
           type: 'get',
           data: dato,
           success: function(response){
             var json = eval("(" + response + ")");

              if(json.success == 'success')
              {
                window.location.href = '<?php echo site_url();?>/ensayo/index/'+asignacion_id+'/'+usuario_id;
                //href='ensayo/index/".$id_asignacionprueba."/".$id_usuario."'
              }
              else
              {
                alert('ocurrió un error, comunicarse con el área de soporte');
              } 
          }
        });
     });     

},1000);

  $.ajax({

    url : '<?php echo site_url();?>/alumno/ensayo_asignado',
    type: 'get',
    //data: datos,
    beforeSend: function(){
    },
    success: function(response){
      //var data = $.parseJSON(response);
      var json = eval("(" + response + ")");
      $("#data").html(json.filas);
    }      
  });

});

function hiddenShowTable(id){
  showed  = 0;
  elem    = document.getElementById(id);
  if(elem.style.display=='block') showed=1;
  elem.style.display='none';
  if(showed!=1)elem.style.display='block';
  console.log(elem);
};



</script>