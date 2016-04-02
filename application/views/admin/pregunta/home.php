<?php 

$data['title_page'] = "Ensayos | Profesor";
$this->load-> helper('url');

?>

<div class="main-content" >
  <div class="wrap-content container" id="container" style="margin-top: 23px;">      
    <div class="row">
      <div class="col-sm-12" style="margin-bottom: 100px;">


<div style="     margin-right: 4px; color: white!important; background-color:#364150 ; margin-left: 1px; float: left;float: right;width: 99.6%;height: 42px;">
        
                <div style=" float: left; margin-top: 8px;"> 
                    <i class="ti-file" style="font-size: 26px;color:white;    margin-left: 16px;"></i>
                </div>
                <div style="float: left; margin-left: 12px;margin-top: 12px;">  
                  <?php echo $cod_prueba." >> "?><strong>Vista Preguntas</strong>
                </div>
                <div class="product-photo" style="    margin-right: 0px;">
                  <a id="new_pregunta" style=" float: right;margin-top: -10px;margin-right: -3px;" data-fancybox-type="iframe"  target="_blank" href="<?php echo site_url()."/pregunta/new_pregunta/$id_prueba";?>">
                    <span class="c_pregunta" style="float: right;     margin-top: 20px;"></span>
                  </a>
               </div>
            </div>



         
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
    
<?php 
$data['close_menu'] = false;
$this->load->view('partial/footer', $data);
?>

<script type="text/javascript" charset="utf-8">
$(document).ready(function()
{
	
  lista_preguntas();
  filtrado(); 
  
  
  $(window).focus(function() {
    function startRefresh() 
    {
        $.get('', function(data) 
        {
            $(document.body).html(data); 
            location.reload();
        });
    }

    
    $(function() 
    {
        setTimeout(startRefresh,500);
    }); 
    
  });

  
});

function lista_preguntas()
{
  var id_prueba = <?php echo $id_prueba; ?>;
  $.ajax({
    url : '<?php echo site_url();?>/pregunta/tabla/'+id_prueba,
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
}

function filtrado()
{
  setTimeout(function(){          
    
    var data = $('#data').DataTable();          
    $('#filtro').keyup(function(){            
      data.search($(this).val()).draw();
    });
      javascript:hiddenShowTable('tabla1');
      javascript:hiddenShowTable('loader');

  },1000);
}

function hiddenShowTable(id){
  showed  = 0;
  elem    = document.getElementById(id);
  if(elem.style.display=='block') showed=1;
  elem.style.display='none';
  if(showed!=1)elem.style.display='block';
  console.log(elem);
};

$(".ver_pregunta").fancybox({
  maxHeight : 450,
  padding   : 0
});

$("#delete").fancybox({
  maxWidth :380,
  maxHeight : 220,
  padding   : 1,
  'closeBtn' : false,
});
</script>
