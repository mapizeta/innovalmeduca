<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>


  <div class="modal-header modal-comun">
        <button type="button" class="close cerrar" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-comun"><b>Asignar Prueba</b></h4>
        <div class='icono-add'><img src="<?php echo base_url();?>assets/images/icon-crearprueba.svg" height="32px"></div>
  </div>
  <div class="modal-body" >
    <form method="post" id="formulario">
      <div class='input-group'>
        <span class='input-group-addon' id='basic-addon1'>Prueba</span>
          <select name='prueba' class='form-control' required>
            <option value=''>Click aquí</option>
            <?php echo $pruebas;?>
          </select>      
      </div>  
      <div id='espacio'></div>

      <div class='input-group'>
        <span class='input-group-addon' id='basic-addon1'>Colegio</span>
          <select id='colegio' name='colegio' class='form-control' required>
            <option value=''>Click aquí</option>
            <?php echo $colegios;?>
          </select>      
      </div>
      <div id='espacio'></div>
      
      <div id="data-curso" style='display:none'>
        <div  class='input-group'>
          <span class='input-group-addon' id='basic-addon1'>Curso</span>
            <select id='curso' name='curso' class='form-control' required>
            </select>       
        </div>  
      </div>

     <div id='espacio'></div>
      
      <div id='error' class='alert alert-danger' role='alert' style='margin-bottom:-10px;display:block;padding-left:225px;padding-right:225px;'>Ya existe una asignación relacionada.</div>      
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-cancelar cerrar" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-crear">Crear</button>
  </div>
    </form>

<script type="text/javascript">
  $(document).ready(function() {
    var muestra = { display : 'block' };
    var esconde = { display : 'none' };

    $("#formulario").submit(function(){
    
      $.ajax({
              url : '<?php echo site_url();?>/prueba/save/',
              type: 'post',
              data: $('#formulario').serialize(),
        
              success:function(response){
                
                var json = eval("(" + response + ")");
                console.log(json.mensaje);
                alert(json.mensaje);
                parent.$.fancybox.close();
                parent.location.reload();
                
              }      
            });
        return false;/*Detalle para firefox*/
      
    });

     $('#colegio').change(function()
      {
        if($(this).val() == ' ')
          {
            $('#data-curso').css(esconde);
          }
          else{
            $('#data-curso').css(muestra);
            carga_cursos($(this).val());
          }
    });
    
    $('.cerrar').click(function(){
      parent.$.fancybox.close();
      return false;
    })
 
});

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
</script>

</body>
</html>