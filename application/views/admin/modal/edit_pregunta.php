<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>prueba</title>
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery-126.js"></script>
</head>


<body>
<div class="modal-content">
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Editar Pregunta</b></h4>
  </div>
  <div class="modal-body" >
    <form method="post" id="formulario">
      <div>
        <p>Eje: 
          
        </p>
      </div>
      <div id="data"></div>
      <br/>
      <button type="submit" class="btn btn-default">Editar</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    
    </form>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
   
       var id_pregunta = <?php echo $id_pregunta; ?>;
    $.ajax({
            url:'<?php echo site_url();?>/pregunta/edit_pregunta/'+id_pregunta,
            success: function(response){
              var json = eval("(" + response + ")");

              $("#data").html(json.data);
          
          }});

    $.ajax({
            url:'<?php echo site_url();?>/pregunta/ejes_apren_pregunta/'+id_pregunta,
            success: function(response){
              var json = eval("(" + response + ")");

              $("#eje").html(json.ejes);
          
          }});
    setTimeout(function(){
    $("#eje").change(function () {
           $("#eje option:selected").each(function () {
            elegido=$(this).val();
            $.post("<?php echo site_url();?>/pregunta/aprendizaje_eje", { elegido: elegido }, function(data){
            $("#aprendizaje").html(data);
            
            });            
        });
   });
}, 1000);
   
    
  
  

});
</script>

</body>
</html>