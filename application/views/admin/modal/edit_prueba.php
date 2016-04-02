<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>prueba</title>
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</head>


<body>
<div class="modal-content">
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Editar Prueba</b></h4>
  </div>
  <div class="modal-body" >
    <form method="post" id="formulario">
      <div id="data"></div>
        <button type="submit" class="btn btn-crear">Editar</button>
        <button type="button" id="cerrar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </form>
  </div>
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

    var id_prueba = <?php echo $id_prueba; ?>;

    $.ajax({
            url:'<?php echo site_url();?>/prueba/edit_prueba/'+id_prueba,
            success: function(response){
              var json = eval("(" + response + ")");

              $("#data").html(json.niveles);
            
           
          }});

    $("#formulario").submit(function(){
    
      $.ajax({
              url : '<?php echo site_url();?>/prueba/save/'+id_prueba,
              type: 'post',
              data: $('#formulario').serialize(),
        
              success:function(response){
                var json = eval("(" + response + ")");
                //console.log('datos guardados con exito');
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