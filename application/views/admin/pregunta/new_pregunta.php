<?php 

$data['title_page'] = "Ensayos | Profesor";
$this->load-> helper('url');

?>

<div class="main-content" >
  <div class="wrap-content container" id="container" style="margin-top: 23px;">      
    <div class="row" style="margin-left: 54px;margin-right: -471px;">
      <div class="col-sm-8" style="margin-bottom: 100px;">
      
      <div style="color: white;background-color: #364150;height:47px;padding:13px;width:100%"><?php echo $cod_prueba; ?> >> Nueva Pregunta</div>
      <div id='espacio'>&nbsp;</div>
      <form id="formulario">
          <div id="data"></div>
          <div>
            <input type='hidden' id='id_prueba' name='id_prueba' value="<?php echo $id_prueba ?>"/>
            
          </div> 
          <br/>

          <button type="submit" class="btn btn-primary">Crear Pregunta</button>
      </form>

      </div>
    </div>
  </div>

<?php 
$data['close_menu'] = false;
$this->load->view('partial/footer', $data);
?>
<script type="text/javascript">
 $(document).ready(function() {
      var id_prueba = <?php echo $id_prueba;?>;

      
     $.ajax({
            url:'<?php echo site_url();?>/pregunta/select_new_pregunta',
            success: function(response){
              var json = eval("(" + response + ")");

              $("#data").html(json.data);
          
          }});

    setTimeout(function(){
      console.log($('#aprendizaje').val());
    }, 100);

    setTimeout(function(){
    /*
    $("#eje").change(function () {
           $("#eje option:selected").each(function () {
            elegido=$(this).val();
            $.post("<?php echo site_url();?>/pregunta/aprendizaje_eje", { elegido: elegido }, function(data){
            $("#aprendizaje").html(data);
            
            });            
        });
   });
    */
    CKEDITOR.instances['editor'].on('change', function() {
    CKEDITOR.instances['editor'].updateElement() 
    
      });
}, 500);

    

    $("#formulario").submit(function(){
    
     $.ajax({
              url : '<?php echo site_url();?>/pregunta/save/',
              type: 'post',
              data: $('#formulario').serialize(),
        
              success:function(response){
                var json = eval("(" + response + ")");
                
                //console.log(json.mensaje);
                alert('Pregunta creada con éxito');
                
                window.close();
              }      
            });
    });



    
   
   });


</script>


