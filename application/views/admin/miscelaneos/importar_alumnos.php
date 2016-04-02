
<div class="main-content" >
  <div class="wrap-content container" id="container">
            
    <!-- start: FEATURED BOX LINKS -->
    <div class="container-fluid container-fullw bg-white">
      <div class="row">
        <div class="col-sm-12" style="width: 466px; margin-left: 135px;">


         <div id="container" style="width: 214%;">   

         <h1>Importar Alumnos</h1>
        
          <div id='cargar-excel' >
              <div class='input-group' id='data-colegio' style="width: 100%;">
              <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Seleccionar Colegio</span>
              <select id='colegio' style="width: 88%;" required><?php echo $colegios; ?></select>
              </div>
              <br> 
                      <div style="display:none;"  id='data-curso'>
              <div class='input-group'  style="width: 100%; ">
              <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Seleccionar Curso</span>
                  <select id='curso' style="width: 88%;" required></select>
          </div></div>
           <br> 
                    <div style="display: none;" id="importar" >
                      <br><br><h5>Solo formato .xls </h5>
                      <form enctype="multipart/form-data" >
                            
                              <input type="file" name="type_file" id='type_file'/> <br>
                              <a class='btn btn-default btn-sm btn-primary' id="submit" value="">Cargar archivo</a>

                       </form>
                       
                    </div>
                  

          </div>

                 <table id='encabezado' class='table'></table>
                <table id='data-importar' class='table'></table>
                <div id='button' ></div>
                </div>

               


        </div>

    </div>

  </div>
</div>
    <!-- end: FEATURED BOX LINKS -->

  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){

   var muestra = { display : 'block' };
   var esconde = { display : 'none' };
   var curso   = "";


   $('#colegio').change(function()
      {
        if($(this).val() == ' ')
          {
            $('#data-curso').css(esconde);
            $('#importar').css(esconde);
            
          }
          else{
            $('#data-curso').css(muestra);
            carga_cursos($(this).val());
          }
    });

   $('#curso').change(function()
      {
        if($(this).val() == ' ')
          {
            $('#importar').css(esconde);

          }
          else{
            $('#importar').css(muestra);
            curso = $(this).val();
          }
    });

setTimeout(function(){  


  $("#submit").click(function(){

     $('#cargar-excel').css(esconde);

      var inputFile = document.getElementById('type_file');
      var file = inputFile.files[0];
      var data = new FormData();

      data.append('archivo',file);

    $.ajax({

      url:'<?php echo base_url() ?>index.php/administrator/cargar_excel',
      type:'POST',
      contentType:false,
      data:data,
      processData:false,
      cache:false,

      success: function(response){
           setTimeout(function(){  
           
            var data = $.parseJSON(response);
            $("#encabezado").html(data.encabezado);
            $("#data-importar").html(data.filas);
            $("#button").html(data.boton);

            },500);

               setTimeout(function(){ 
                 save();
               },500);

        }
    });
       
  });

function save(){

  $(".btnRecorrer").click(function () { 
     
    var identificador=$(this).attr('identificador');
    var campo1, campo2, campo3;
    

          $("#tr"+identificador+" td").each(function(index)
          {
                switch (index) 
              {
                 case 0: campo1 = $(this).children().val();
                 break;
                 case 1: campo2 = $(this).children().val();
                 break;
                 case 2: campo3 = $(this).children().val();
                 break;
                 case 3: campo4 = $(this).children().val();
                 break;
              }
          
          });
          $.ajax({
                 url : '<?php echo site_url(); ?>/administrator/importar_alumno',
                 type: 'post',
                 data: {rut:campo2,nombre:campo3,apellido:campo4, curso:curso},
                 success: function(response)
                 {
                  var data = $.parseJSON(response);
                  
                  if(data.success == "success")
                    //console.log(data.success);
                    $("#tr"+identificador).css("background-color", "rgba(42, 169, 46, 0.46)");
                  else
                    //console.log(data.success);
                    $("#tr"+identificador).css("background-color", "rgba(25, 21, 21, 0.49)");
                           
                  console.log(data.mensaje);
                 
                }      
              });

          //console.log(curso);
   })

}   

},500);


function carga_cursos(id_colegio)
{
  $.ajax(
  {
    url:'<?php echo site_url();?>/administrator/get_cursos/'+id_colegio,
    success: function(response)
    {
      var json = eval("(" + response + ")");
      $("#curso").html(json.cursos);

    }
  });
} 

});


/*$.ajax({
            url:'<?php echo site_url();?>/prueba/new_prueba/',
            success: function(response){
              var json = eval("(" + response + ")");

              $("#data").html(json.niveles);
            
           
          }});*/

</script>