
<div class="main-content" >
  <div class="wrap-content container" id="container">
            
    <!-- start: FEATURED BOX LINKS -->
    <div class="container-fluid container-fullw bg-white">
      <div class="row">
        <div class="col-sm-12" style="width: 466px; margin-left: 210px;">

        
        <div id="container" ><!-- <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>--></div>

        </div>

      </div>
    </div>
    <!-- end: FEATURED BOX LINKS -->

  </div>
</div>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Gráfico Detalles de accesos para profesores por colegio'
        },
        subtitle: {
            text: 'Demostración acerca de uso de software'
        },
        xAxis: {
            categories: [
                <?php echo $colegios; ?>
            ],
            type: 'category',
            labels: 
            {
                rotation: -45,
                style: 
                {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            crosshair: true

        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad de accesos'
            }
        },
        /*
        legend: {
            enabled: false
        },*/
        tooltip: {
             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} Accesos</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
         plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: 
        [
        <?php echo $series; ?>

        ]
    });
});
    </script>
