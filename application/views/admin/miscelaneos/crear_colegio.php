<div class="main-content" >
  <div class="wrap-content container" id="container">
            
    <!-- start: FEATURED BOX LINKS -->
    <div class="container-fluid container-fullw bg-white">
      <div class="row">
        <div class="col-sm-12" style="width: 466px; margin-left: 135px;">
         <div id="container" style="width: 214%;">   

        <h2>Nuevo Colegio</h2>

        <form>
        
         <div class='input-group' style=" width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Colegio</span>
         <input type='text' id='colegio' placeholder="Colegio"  style="width: 88%;" autocomplete="off" required/>
         </div>
         <br>
        <div class='input-group' style="width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Rbd</span>
         <input type='text' id='rbd' placeholder="rbd" style="width: 88%" required/>
         </div>
         <br>
         <div class='input-group' style="width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Director</span>
        <input type='text' id='director' placeholder="Director" style="width: 88%;" autocomplete="off" required/>
         </div>
         <br>
         <div class='input-group' style="width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Dirección</span>
         <input type='text' id='direccion' placeholder="Dirección" style="width: 88%;" autocomplete="off" />

         </div>
         <br> 
        
         <div class='input-group' style="width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Contacto</span>
              <input type='text' id='contacto' placeholder="Contacto ( Celular - Telefono Fijo )" id='numero' autocomplete="off" style=" width: 88%;" />

         </div>
         <br> 
        
         <div class='input-group' style=" width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;' >Email</span>
              <input type='text' id='email' placeholder="Email: usuario@dominio.cl" id='numero' autocomplete="off" style="width: 88%;" />

         </div>
         <br> 
         <div class='input-group' id='data-region' style="width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Región</span>
                <select id='region' style="width: 88%;" required></select>
         </div>
         <br> 
         <div  style="display: none;" id="data-provincia">
         <div class='input-group'  style="width: 100%;">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Provincia</span>
         <select id='provincia' style="width: 88%;" required></select>
         </div></div>
         <br> 

         <div  style="display: none;" id="data-comuna">
         <div class='input-group'  style="width: 100%; ">
         <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Comuna</span>
                <select id='comuna' style="width: 88%;" required></select>
         </div>
         </div>
         <br> 
              
                <div id='button' style="margin-top: 22px;" >
                  <button style=" color: white;" id="submit" class="btn btn-default btn-sm btn-primary">Crear</button>
                </div>

        </form>
        </div>
        

        </div>

      </div>
    </div>
    <!-- end: FEATURED BOX LINKS -->

  </div>
</div>
<script type="text/javascript">

$(document).ready(function(){

  carga_regiones();

   var muestra = { display : 'block' };
   var esconde = { display : 'none' };
   var curso   = "";

  

   $('#region').change(function()
      {
        if($(this).val() == '')
          {
            $('#data-provincia').css(esconde);
            $('#data-comuna').css(esconde);
          }
          else{
            $('#data-provincia').css(muestra);
            $('#data-comuna').css(esconde);
            carga_provincias($(this).val());
          }
    });



   $('#provincia').change(function()
      {
        if($(this).val() == '')
          {
            $('#data-comuna').css(esconde);

          }
          else{
            $('#data-comuna').css(esconde);
            $('#data-comuna').css(muestra);
            carga_comunas($(this).val());
          }
    });


     
    $("#submit").click(function(){

    var nombre_colegio   = $('#colegio').val();
    var rbd   = $('#rbd').val();
    var director = $('#director').val();
    var direccion = $('#direccion').val();
    var contacto   = $('#contacto').val();
    var email   = $('#email').val();
    var comuna   = $('#comuna').val();

    $.ajax({
           url : '<?php echo site_url(); ?>/administrator/add_colegio/',
           type: 'post',
           data: {nombre_colegio:nombre_colegio,rbd:rbd,director:director, direccion:direccion,contacto:contacto,email:email,comuna:comuna},
          
           success: function(response)
           {
           
          }      
        });
    });
  // números

 })


 

function carga_regiones()
{
  $.ajax(
  {
    url:'<?php echo site_url();?>/administrator/get_regiones/',
    success: function(response)
    {
      var json = eval("(" + response + ")");
      $("#region").html(json.regiones);



    }
  });
}

function carga_provincias(id_region)
{
  $.ajax(
  {
    url:'<?php echo site_url();?>/administrator/get_provincias/'+id_region,
    success: function(response)
    {
      var json = eval("(" + response + ")");
      $("#provincia").html(json.provincias);

    }
  });
} 

function carga_comunas(id_provincia)
{
  $.ajax(
  {
    url:'<?php echo site_url();?>/administrator/get_comunas/'+id_provincia,
    success: function(response)
    {
      var json = eval("(" + response + ")");
      $("#comuna").html(json.comunas);

    }
  });
}
</script>