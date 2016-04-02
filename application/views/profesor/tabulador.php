

  <style type="text/css">
    input[type=text] {
      width: 20px !important;
      font-family: Arial;
      font-size: 20pt; 
      /*background-color: #C5D5FE;*/
    }
  </style>


<div class="main-content" >

  <div class="wrap-content container" id="container">
    
 <div>
 <div id="tabla1" style="display: none">
 <div class="container-fluid container-fullw bg-white">
  <div id='data-respondidas'style="float: left;  font-size: 19px; width: 216px; position: fixed; z-index: 5000; margin-top: 214px;  margin-left: -270px; "></div>
    <div class="row">
      <div class="col-sm-12">
        <div class="table-responsive">
            <div>
              <strong><h3>Planilla De Tabulación</h3></strong>
            </div>
            <div>
              <form name="Me" method="post" action="rec_datos.php">
              <table class="table table-hover table-striped table-condensed"  id="data"  align="center" cellpadding="0" cellspacing="0" >
              </table>
              <p id ="botones" align="center"></p>
            </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>           
   <!-- start: FEATURED BOX LINKS -->
 
  <!-- end: FEATURED BOX LINKS -->

   <div class="row">
          <div class="col-lg-offset-4" style="margin-top: 8%">
          <div id="loader" style="display: block">
            <img src="<?php echo base_url().'assets/images/loader_nube.gif'; ?>">
          </div>
          </div>
        </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){   
      inicial();
      javascript:hiddenShowTable('loader');
});

      function inicial(){
        console.log('primero');
        $.ajax({
          url : '<?php echo site_url();?>/profesor/tabla_tabulado',
          type: 'get',
          data:  {id_asignacion:'<?php echo $id_asignacionprueba; ?>'},
          beforeSend: function()
          {
            javascript:hiddenShowTable('loader');
          },
          success: function(response){
            javascript:hiddenShowTable('tabla1');
            javascript:hiddenShowTable('loader');
            var data = $.parseJSON(response);
            
            $("#data").html(data.filas);
            $("#botones").html(data.botones);
          setTimeout(function(){

            
            save();
                  
          }, 500);

           
          }      
        });  
      }

function save(){

$('input').blur(function(){

             var dato = $(this).val(); //Capturamos el valor del input text
             var pregunta_id = $(this).attr('id_pregunta');  // Capturamos el id de la pregunta
             var alumno_id = $(this).attr('id_alumno'); 
             var colegio_id = $(this).attr('id_colegio');  // 
             var asignacion_id = $(this).attr('id_asignacion');  // 
             if (dato==""){   //Si no hay datos en el input se activa el alert
                var num_pregunta = $(this).attr('num_pregunta'); 
                alert("Acaba de omitir la pregunta "+num_pregunta);
             } 
            
                //var InputData = {dato:dato,pregunta:pregunta_id,alumno:alumno_id,id_colegio:colegio_id,id_asignacion:asignacion_id}; 
                //console.log(InputData);

                $.ajax({
                url : '<?php echo site_url();?>/profesor/save/'+dato+'/'+pregunta_id+'/'+alumno_id+'/'+colegio_id+'/'+asignacion_id,
                type: 'get',
               // data: InputData,

                success:function(response){
                  
                  
                } 
                }); 
             
       });
}


function isNumber(e) {
  k = (document.all) ? e.keyCode : e.which;
  if (k==8 || k==0) return true;
    patron = /[ABCDEabcde]/;
    n = String.fromCharCode(k);
    return patron.test(n);
}

function hiddenShowTable(id){
  showed  = 0;
  elem    = document.getElementById(id);
  
  if(elem.style.display=='block') 
    {
      showed=1;
      elem.style.display='none';
    }
  
  if(showed!=1)
    {
      elem.style.display='block';
      console.log(elem);
    }
};

$("#finalizar").fancybox({
  maxWidth :381,
  maxHeight : 240,
  padding   : 1,
  'closeBtn' : false
});

$("#reiniciar").fancybox({
  maxWidth :381,
  maxHeight : 215,
  padding   : 1,
  'closeBtn' : true,
});

$(".check").fancybox({
  maxWidth :410,
  maxHeight : 250,
  padding   : 1,
  'closeBtn' : true,
});


    </script>
