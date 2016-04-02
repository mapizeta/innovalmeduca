<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/pregunta-ensayo.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style_alumnos.css">

  
  <div class="modal-body" >
    <div id="data"></div>
  </div>    
  
     
  <script type="text/javascript">
  $(document).ready(function() {
    
    var id_pregunta = <?php echo $id_pregunta; ?>;
    var num_pregunta = <?php echo $num_pregunta; ?>;
      $.ajax({
            url:'<?php echo site_url();?>/pregunta/ver_pregunta/'+id_pregunta+'/'+num_pregunta,
            success: function(response)
            {
              var json = eval("(" + response + ")");

              $("#data").html(json.data);
              
            }
      });
    

});
</script>

</body>
</html>