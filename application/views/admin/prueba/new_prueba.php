<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>


  <div class="modal-header modal-comun">
        <button type="button" class="close cerrar" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-comun"><b>Crear Prueba</b></h4>
        <div class='icono-add'><img src="<?php echo base_url();?>assets/images/icon-crearprueba.svg" height="32px"></div>
  </div>
  <div class="modal-body" >
    <form method="post" id="formulario">
      <div id="data"></div>
      <div id="datos"></div>
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
    
    setTimeout(function(){

      $( "#codigo" ).focus();

      $( "#codigo" ).focus(function() {
        $('#error').css(esconde);
        $('.btn-crear').attr("disabled", false); 
      });

      $( "#codigo" ).blur(function() 
      {
        var codigo = $(this).val();
        var mensaje = 'El código ingresado ya existe. Prueba con otro.';
        $.ajax({
            url:'<?php echo site_url();?>/prueba/exist_codigo/',
            type: 'get',
            data: {codigo : codigo},
            success: function(response){
              var json = $.parseJSON(response);
                            
              if(json.success == 'success')
                {
                  $("#error").html(mensaje);
                  $('#error').css(muestra);
                  $('.btn-crear').attr("disabled", true);    
                }
              
            
           
          }});
      });

      $('#tipo').change(function()
      {
        var muestra = { display : 'inline' };
        var esconde = { display : 'none' };
        
        if($(this).val() == 1)
          {
            $('#simce').css(muestra);
            $('#simce').prop('required', true);
            $('#pme').css(esconde);
            $('#pme').prop('required', false);
          }          
        else
          {
            $('#simce').css(esconde);
            $('#simce').prop('required', false);
            $('#pme').css(muestra);  
            $('#pme').prop('required', true);
          }
          

      });
      
      $('.ensayo').change(function()
      {
        $('#evaluacion').val($(this).val());
        $('#simce').val($(this).val());
        $('#pme').val($(this).val());
        //console.log($('#evaluacion').val());
      });
    },500);

    $.ajax({
            url:'<?php echo site_url();?>/prueba/new_prueba/',
            success: function(response){
              var json = eval("(" + response + ")");

              $("#data").html(json.niveles);
            
           
          }});

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

    
    $('.cerrar').click(function(){
      parent.$.fancybox.close();
      return false;
    })
    

});
</script>

</body>
</html>