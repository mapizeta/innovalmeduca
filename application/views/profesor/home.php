<?php 

$data['title_page'] = "Ensayos | Profesor";
$this->load->view('partial/header_profesor_filtro', $data);
$this->load-> helper('url');

?>

<div class="main-content" >

  <div style="padding-left:200px;padding-top:20px">
    
  </div>

  <div class="wrap-content container" id="container" style="margin-top: 23px;">      
    <div class="row">
      <div class="col-sm-12" style="margin-bottom: 100px;">
        <!-- <a href="javascript:hiddenTable('tabla1')">asdasdasd</a> -->
        <div id="tabla1" style="display: none">
          <table class="table table-bordered table-hover table-striped" id="data">
            
          </table>
        </div>
        <div class="row">
          <div class="col-lg-offset-4" style="margin-top: 8%">
          <div id="loader" style="display: block">
            <img src="<?php echo base_url().'assets/images/loader_nube.gif'; ?>">
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php 
$data['close_menu'] = false;
$this->load->view('partial/footer', $data);
?>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){

  var filter = {tipo:"", nivel:"", subsector:"", evaluacion:""};

	setTimeout(function()
  {          
    var data = $('#data').DataTable(
    {
      "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                /*"searchable": false*/
            },
            {
                "targets": [ 2 ],
                "visible": false,
                /*"searchable": false*/
            },
            {
                "targets": [ 3 ],
                "visible": false,
                /*"searchable": false*/
            },
            {
                "targets": [ 4 ],
                "visible": false,
                /*"searchable": false*/
            },
            {
                "targets": [ 5 ],
                "visible": false,
                /*"searchable": false*/

            },
            {
                "targets": [ 11 ],
                "searchable": false
                
            }
        ]
    });

    $('.genera_pdf').click(function(){
      var url = $(this).attr("data-href");

    $.ajax({
    url : url,
    success: function(response){
      //var data = $.parseJSON(response);
      var json = eval("(" + response + ")");
      console.log(json.success);
    }      
   });

    });

    $('#menu-filtro').click(function(){
      $('#menu-filtro-tipo').css("display", "block");
    });            

    $('#filtro').keyup(function(){            
      data.search($(this).val()).draw();
      
    });

    
    $('.tipo').click(function()
    {            
    
      var filtro = $('#filtro').val();
      var tipo = $(this).attr("value");

      if(filter.tipo == "")
        {
          filter.tipo = $(this).attr("value");
          $('#filtro').val(filtro+" "+$(this).attr("value"));  
        }
      else
        {
          var cadena = filtro.replace(filter.tipo, $(this).attr("value"));
          filter.tipo = $(this).attr("value");  
          $('#filtro').val(cadena);  
        }
      
      $('#filtro').keyup();

      if(tipo == 'simce')
        {
          $('#simce').css("display", "block");
          $('#pme').css("display", "none");
        }
      else
        {
          $('#simce').css("display", "none");
          $('#pme').css("display", "block");
        } 

      $('#menu-filtro-evaluacion').css("display", "block");
    
    });

    $('.evaluacion').click(function()
    {            
      
      var filtro = $('#filtro').val();
      console.log(filter.evaluacion);

      if(filter.evaluacion == "")
      {
        filter.evaluacion = $(this).attr("value");
        $('#filtro').val(filtro+" "+$(this).attr("value"));  
      }
      else
      {
        var cadena = filtro.replace(filter.evaluacion, $(this).attr("value"));
        filter.evaluacion = $(this).attr("value");  
        $('#filtro').val(cadena);  
      }
      
      $('#filtro').keyup();
      
      $('#menu-filtro-ensenanza').css("display", "block");

    });


    $('.ensenanza').click(function()
    {            
      
      $(this).parent().parent().css("display", "none");
     
      if($(this).attr("value") == 'basica')
      {
        $('#basica').css("display", "block");
        $('#media').css("display", "none");
      }
      else
      {
        $('#media').css("display", "block");
        $('#basica').css("display", "none");
      }

      $('#menu-filtro-nivel').css("display", "block");
    });

    $('.nivel').click(function()
    {            
      
      var filtro = $('#filtro').val();
      console.log(filter.nivel);

      if(filter.nivel == "")
      {
        filter.nivel = $(this).attr("value");
        $('#filtro').val(filtro+" "+$(this).attr("value"));  
      }
      else
      {
        var cadena = filtro.replace(filter.nivel, $(this).attr("value"));
        filter.nivel = $(this).attr("value");  
        $('#filtro').val(cadena);  
      }
      
      $('#filtro').keyup();

      $('#menu-filtro-subsector').css("display", "block");
    
    });

    $('.subsector').click(function()
    {            
      
      var filtro = $('#filtro').val();
      console.log(filter.subsector);

      if(filter.subsector == "")
      {
        filter.subsector = $(this).attr("value");
        $('#filtro').val(filtro+" "+$(this).attr("value"));  
      }
      else
      {
        var cadena = filtro.replace(filter.subsector, $(this).attr("value"));
        filter.subsector = $(this).attr("value");  
        $('#filtro').val(cadena);  
      }
      
      $('#filtro').keyup();
    
    });
    

    javascript:hiddenShowTable('tabla1');
    javascript:hiddenShowTable('loader');

    $('#data').css("width", "");
    
  },1000);

  $.ajax({
    url : '<?php echo site_url();?>/profesor/get_datos',
    type: 'get',
    //data: datos,
    beforeSend: function(){
    },
    success: function(response){
      //var data = $.parseJSON(response);
      var json = eval("(" + response + ")");
      $("#data").html(json.filas);
    }      
  });
});

function hiddenShowTable(id){
  showed  = 0;
  elem    = document.getElementById(id);
  if(elem.style.display=='block') showed=1;
  elem.style.display='none';
  if(showed!=1)elem.style.display='block';
  console.log(elem);
};

$("#alumnos").fancybox({
  maxWidth  :600,
  maxHeight : 500,
  padding   : 1,
  closeBtn  : true,
});

$(".cambiar_estado").fancybox({
  maxWidth  :600,
  maxHeight : 260,
  padding   : 1,
  closeBtn  : false
});

</script>

