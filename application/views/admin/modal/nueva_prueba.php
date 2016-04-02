<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>prueba</title>
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</head>


<body>
<div class="modal-content">
  <div class="modal-header modal-comun">
        <button id="cerrar" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-comun"><b>Crear Prueba</b></h4>
        <div class='icono-add'><img src="<?php echo base_url();?>assets/images/icon-crearprueba.svg" height="32px"></div>
  </div>
  <div class="modal-body" >
    <form method="post" id="formulario">
      <div id="data"></div>
      <div id="datos"></div>
  </div>
  <div class="modal-footer">
    <button type="button" id="cerrar" class="btn btn-cancelar" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-crear">Crear</button>
  </div>
    </form>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    setTimeout(function(){   
      $('#tipo').change(function()
      {
        var muestra = { display : 'inline' };
        var esconde = { display : 'none' };
        
        if($(this).val() == 1)
          {
            $('#simce').css(muestra);
            $('#pme').css(esconde);

          }          
        else
          {
            $('#simce').css(esconde);
            $('#pme').css(muestra);  
          }
          

      });
      $('.ensayo').change(function()
      {
        $('#evaluacion').val($(this).val());    
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
    
      //console.log($(this).serialize());
    });

    
    $('#cerrar').click(function(){
      parent.$.fancybox.close();
      return false;
    })
    

});
</script>

</body>
</html>