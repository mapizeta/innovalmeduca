<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/modal.css">
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/slide.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jssor.slider.mini.js"></script>






    <!-- #region Jssor Slider Begin -->

    <!-- Generated by Jssor Slider Maker Online. -->
    <!-- This demo works with jquery library -->

    
    <!-- use jssor.slider.debug.js instead for debug -->
    <script>
        jQuery(document).ready(function ($) {
            
            var jssor_1_SlideoTransitions = [
              [{b:5500,d:3000,o:-1,r:240,e:{r:2}}],
              [{b:-1,d:1,o:-1,c:{x:51.0,t:-51.0}},{b:0,d:1000,o:1,c:{x:-51.0,t:51.0},e:{o:7,c:{x:7,t:7}}}],
              [{b:-1,d:1,o:-1,sX:9,sY:9},{b:1000,d:1000,o:1,sX:-9,sY:-9,e:{sX:2,sY:2}}],
              [{b:-1,d:1,o:-1,r:-180,sX:9,sY:9},{b:2000,d:1000,o:1,r:180,sX:-9,sY:-9,e:{r:2,sX:2,sY:2}}],
              [{b:-1,d:1,o:-1},{b:3000,d:2000,y:180,o:1,e:{y:16}}],
              [{b:-1,d:1,o:-1,r:-150},{b:7500,d:1600,o:1,r:150,e:{r:3}}],
              [{b:10000,d:2000,x:-379,e:{x:7}}],
              [{b:10000,d:2000,x:-379,e:{x:7}}],
              [{b:-1,d:1,o:-1,r:288,sX:9,sY:9},{b:9100,d:900,x:-1400,y:-660,o:1,r:-288,sX:-9,sY:-9,e:{r:6}},{b:10000,d:1600,x:-200,o:-1,e:{x:16}}]
            ];
            
            var jssor_1_options = {
              $AutoPlay: false,
              $SlideDuration: 800,
              $SlideEasing: $Jease$.$OutQuint,
              $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: jssor_1_SlideoTransitions
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };
            
            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
            
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 1920);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>

   

<body style="overflow-x: hidden;width: 816px;height: 350px; ">

    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1200px; height: 500px; overflow: hidden; visibility: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: default; position: relative; top: 20px; left: 0px; width: 1300px; height: 1612px; overflow: hidden;">
            
            <div data-p="225.00" style="display: none;">
                 <div style="position: absolute; top: -47px; left: 159px; width: 480px; height: 120px; font-size: 30px; color: #ffffff; line-height: 38px;"><img data-u="image" src="<?php echo base_url().'assets/images/instrucciones/2_t.svg'; ?>" /></div> 
                 <a  href='#' class='btn enviar ' style=" background-color: #EC9903; margin-top: 426px;  margin-left: 1027px; font-size: 25px; color: #FAFAFA;">Continuar</a>

            </div>
            <div data-p="225.00" style="display: none;">
                <div style="position: absolute; top: -191px; left: 159px; width: 480px; height: 120px; font-size: 30px; color: #ffffff; line-height: 38px;"><img data-u="image" src="<?php echo base_url().'assets/images/instrucciones/3_t.svg'; ?>" /></div> 
                <a  href='#' class='btn enviar ' style=" background-color: #EC9903; margin-top: 426px;  margin-left: 1027px; font-size: 25px; color: #FAFAFA;">Continuar</a>

            </div>
            <div data-p="225.00" style="display: none;">
                <div style="position: absolute; top: -75px; left: 159px; width: 480px; height: 120px; font-size: 30px; color: #ffffff; line-height: 38px;"><img data-u="image" src="<?php echo base_url().'assets/images/instrucciones/4_t.svg'; ?>" /></div> 
                <button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal' style="
                margin-top: 426px; margin-left: 1027px; font-size: 25px; background-color: #0D8D35; color: #FEFBFA; border-color: #0D8D35; ">Realizar</button>
            </div>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>
        
    </div>
</body>
    <!-- #endregion Jssor Slider End -->
<script>

$(".enviar").click(function(){
    $(".jssora22r").trigger("click");
});

$('.cerrar').click(function(){
    parent.$.fancybox.close();
    return false;
  })
 
</script>

