<section class="scrollable padder">
    <ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Log Reports</li> </ul>

    <div class="m-b-md"> 
        <h3 class="m-b-none"></h3> 
        <small></small> </div>

    <br/>
</section>
<section class="panel panel-default">
    <header class="panel-heading text-right bg-light"> 
        <section class="panel panel-default">
            <div class="row m-l-none m-r-none bg-light lter">


                <div class="col-sm-6 col-md-4 padder-v b-r b-light lt">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-success"></i>
                        <i class="fa fa-money fa-stack-1x text-white"></i>
                        <span class="easypiechart pos-abt easyPieChart" data-percent="100" data-line-width="4" data-track-color="#fff" data-scale-color="false" data-size="50" data-line-cap="butt" data-animate="2000" data-target="#bugs" data-update="3000" style="width: 50px; height: 50px; line-height: 50px;">
                            <canvas width="50" height="50"></canvas>
                        </span>
                    </span> 
                    <a class="" href="">
                        <span class=" m-t-xs">
                            <table>
                                <thead>
                                    <?php
                                    $total_sms = 0;
                                    foreach ($sms as $message) {
                                        $total_sms += (int) $message->count;
                                        $type = $message->from_smart == 1 ? 'Android SMS' : 'Internet SMS';
                                        ?>
                                        <tr>
                                            <th><?= $type ?></th>
                                            <th><?= $message->count ?></th>
                                        </tr>
                                    <?php }
                                    ?>

                                    <tr>
                                        <th>Total</th>
                                        <th><?= $total_sms ?></th>
                                    </tr>
                                </thead>  
                            </table>
                        </span>
                        <small class="text-muted">Totat SMS Sent</small> </a>
                </div>

                <div class="col-sm-6 col-md-4 padder-v b-r b-light"> 
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-info"></i>
                        <i class="fa fa-arrow-up fa-stack-1x text-white"></i> 
                        <span class="easypiechart pos-abt easyPieChart" data-percent="100" data-line-width="4" data-track-color="#f5f5f5" data-scale-color="false" data-size="50" data-line-cap="butt" data-animate="3000" data-target="#firers" data-update="5000" style="width: 50px; height: 50px; line-height: 50px;">
                            <canvas width="50" height="50"></canvas>
                        </span> 
                    </span>
                    <a class="clear" href="#load_payments"> 
                        <span class="h3 block m-t-xs">
                            <strong id="firers">  </strong>
                        </span>
                        <small class="text-muted">Estimated Profit</small>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 padder-v b-r b-light"> 
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-danger"></i>
                        <i class="fa fa-comments-o fa-stack-1x text-white"></i> 
                        <span class="easypiechart pos-abt easyPieChart" data-percent="100" data-line-width="4" data-track-color="#f5f5f5" data-scale-color="false" data-size="50" data-line-cap="butt" data-animate="3000" data-target="#firers" data-update="5000" style="width: 50px; height: 50px; line-height: 50px;">
                            <canvas width="50" height="50"></canvas>
                        </span> 
                    </span>
                    <a class="clear" href="#"> 
                        <span class="h3 block m-t-xs">
                            <strong id="firers"></strong>
                        </span>
                        <small class="text-muted text-uc">SMS Remain</small>
                    </a>
                </div>

            </div> 
        </section>
    </header>
    <div class="panel-body"> 
        <div class="tab-content">

            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="media/code/modules/export-data.js"></script>

            <script type="text/javascript">
                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Number of SMS sent per each month'
                    },
                    subtitle: {
                        text: 'Source: karibusms.com'
                    },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'No of SMS'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} SMS</b></td></tr>',
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
                    series: [

                        {
                            name: 'Bulk SMS',
                            data: [
<?php
for ($p = 1; $p <= 12; $p++) {
    echo isset($logs[0][$p]) ? $logs[0][$p] . ',' : 0;
}
?>
                            ]

                        }

                        , {
                            name: 'Android SMS',
                            data: [<?php
for ($p = 1; $p <= 12; $p++) {
    echo isset($logs[1][$p]) ? $logs[1][$p] . ',' : 0;
}
?>]

                        }]
                });
            </script>



        </div> 
    </div>
</section>
<script src="<?= url('/') ?>/media/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?= url('/') ?>/media/css/table.css" rel="stylesheet">
<script type="text/javascript">
                mydatatable = function () {
                    $('#mytable').dataTable();
                };
                mydatatable();
</script>