
<div class="main-content" >
  <div class="wrap-content container" id="container">
            
    <!-- start: FEATURED BOX LINKS -->
    <div class="container-fluid container-fullw bg-white">
      <div class="row">
         <div class="col-sm-12" style="width: 466px; margin-left: 135px;">
         <div id="container" style="width: 214%;">   


        <h2>Asignación de cursos</h2>
        
        <form>

         <div class='input-group' id='data-colegio' style="width: 100%;">
            <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Seleccionar Colegio</span>
            <select id='colegio' style="width: 88%;" required><?php echo $colegios; ?></select>
         </div>
         <br>
         <div class='input-group' id='data-categoria' style="width: 100%;">
            <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Categoría de Educación</span>
            <select id='categoria' style="width: 88%;" required>
              <option value=''>Click aquí</option>
              <option value='b'>Básica</option>
              <option value='m'>Media</option>
              <option value='bm'>Básica y Media</option>
            </select>
         </div>
         <br>
         <div class='input-group' id='data-letra' style="width: 100%;">
            <span class='input-group-addon' id='basic-addon1' style='color: white;background-color: #2f8fce; border-color: #2F8FCE; width: 19%;'>Letra Máxima</span>
            <select id='letra' style="width: 88%;" required>
               <option value=''>Click aquí</option>
              <option value='1'>A</option>
              <option value='2'>B</option>
              <option value='3'>C</option>
              <option value='4'>D</option>
              <option value='5'>E</option>
              <option value='6'>F</option>
              <option value='7'>G</option>
              <option value='8'>H</option>
              <option value='9'>I</option>
              <option value='10'>J</option>
            </select>
         </div>
         <br>

            </form>

                <div id='button' style="margin-top: 22px;">
                  <button id="submit" class="btn btn-default btn-sm btn-primary">Asignar</button>
                </div>

        </div>

        </div>

      </div>
    </div>
    <!-- end: FEATURED BOX LINKS -->

  </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
 
});
  $("#submit").click(function(){

    var colegio   = $('#colegio').val();
    var categoria = $('#categoria').val();
    var letra     = $('#letra').val();

    $.ajax({
           url : '<?php echo site_url(); ?>/administrator/add_cursos/'+colegio+'/'+categoria+'/'+letra,
           
           success: function(response)
           {

            var data = $.parseJSON(response);
            console.log(data.errores);

              if(data.errores==''){
              $.jAlert({
                'title': 'Mensaje',
                'content': 'Cursos creados con éxito',
                'theme': 'blue',
                'btns': { 'text': 'close' }
              }); 
            }             
            else{
               $.jAlert({
                 'title': 'Mensaje',
                 'content': data.errores,
                 'theme': 'blue',
                 'btns': { 'text': 'close' }
               });
             }
    
          }      
        });
    });
</script>