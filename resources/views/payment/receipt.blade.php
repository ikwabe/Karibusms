<?php
/**
 * @author Ephraim Swilla <ephraim@inetstz.com>
 * Date: 1/23/16
 */
$user = App\Http\Controllers\Controller::user_info();
$link = 'media/images/business/' . $user->client_id . '/' . $user->profile_pic;
$path = file_exists($link) ? url('/') . '/' . $link : url('/') . '/media/images/business/0/default.png';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="karibu, SMS web app, SMS business support, people get connected with business, Customer support application, be the first to know" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
        <meta charset="utf-8"/>
        <link href="media/images/logo.png" rel="shortcut icon" type="image/x-icon" />

        <meta name="google-translate-customization" content="AIzaSyAEswiv76lGpmcCBQC7yAmyzZzvHOnve_Y"></meta>


        <script type="text/javascript">
            function change_cost(cost, to) {
                switch (to) {
                    case 'usd':
                        return  Math.ceil(cost / 1620 * 1) / 1; //we need 2dp in us $
                        break;
                    default:
                        return cost;
                        break;
                }
            }
        </script> 
        <link href="<?= url('/') ?>/media/css/app.v2.css" rel="stylesheet">
        <link href="<?= url('/') ?>/media/css/landing.css" rel="stylesheet">
        <script src="<?= url('/') ?>/media/js/app.v2.js"></script>

        <script src="<?= url('/') ?>/media/js/custom.js"></script>
        <script src="<?= url('/') ?>/media/js/jquery.form.js"></script>
        <script src="<?= url('/') ?>/media/js/jquery.jcryption.3.0.1.js"></script>
        <script src="<?= url('/') ?>/media/js/jquery.loadmask.min.js"></script>

        <meta name="csrf-token" content="{{ csrf_token()}}" />

        <?php
        //css_media('font');
        ?>
        <!--[if lt IE 9]> 
        <script src="js/ie/html5shiv.js"></script> 
        <script src="js/ie/respond.min.js"></script>
        <script src="js/ie/excanvas.js"></script> 
        <![endif]-->
        <title>KaribuSMS</title>  
    </head>

    <body style="width: 80%; margin: 0 auto;">

        <!--<div class="container">-->
        <section class="vbox">

            <header class="bg-light dk header navbar navbar-fixed-top-xs"> 



            </header>




            <!--start section after banner-->

            <section> 
                <section class="hbox stretch">



                    <?php
                    /**
                     * -------------------------------------------
                     * End of navigation
                     * -------------------------------------------
                     */
                    ?>

                    <section id="content">

                        <section class="vbox">


                            <section> <section class="hbox stretch"> <!-- .aside --> 

                                    <!-- /.aside --> <section id="content"> 
                                        <section class="vbox bg-white"> 

                                            <header class="header b-b b-light hidden-print">

                                                <p>Receipt</p> <button style="margin-top:1%" class="pull-right btn btn-sm " onclick="print_section('printable')"><i class="fa fa-print"></i>Print</button></header>
                                            <section class="scrollable wrapper printable"> 
                                                <img src="<?= url('/') ?>/media/images/inets.jpg" width="80" height="50"/>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h4>Inets Company Limited.</h4> <p>
                                                            <a href="http://www.inetstz.com/">www.inetstz.com</a>
                                                        </p>
                                                        <p>11th Block, Bima Road, Mikocheni B <br> Dar es salaam<br> Tanzania </p> 
                                                        <p> Telephone: +255 22278 0228<br> Mobile: +255 655 406 004 </p>
                                                    </div> 
                                                    <div class="col-xs-6 text-right"> 
                                                        <p class="h4">#<?= $payment->invoice ?></p> 
                                                        <h5><?= date('d M Y',strtotime($payment->confirmed_time)) ?></h5>

                                                    </div>
                                                </div>
                                                <div class="well m-t"> 
                                                    <div class="row"> 
                                                        <div class="col-xs-6">
                                                            <strong>TO:</strong>
                                                            <h4><?= $client->name ?></h4> 
                                                            <p><?= $client->location ?><br> <?= $client->country ?>
                                                                <br> Phone: <?= $client->phone_number ?>
                                                                <br> Email: <?= $client->email ?><br> </p> 
                                                        </div>
                                                        <div class="col-xs-6"> 

                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="m-t m-b">Order date: <strong><?= date('d M Y',strtotime($payment->confirmed_time)) ?></strong>

                                                    <br> Invoice No: <strong>#<?= $payment->invoice ?></strong> </p>
                                                <div class="line"></div>
                                                <table class="table">
                                                    <thead>
                                                        <tr> 
                                                            <th width="60">QTY</th> 
                                                            <th>DESCRIPTION</th>
                                                            <th width="140">UNIT PRICE</th> 
                                                            <th width="140">QUANTITY</th> 
                                                            <th width="90">TOTAL</th>
                                                        </tr> 
                                                    </thead>
                                                    <tbody>

                                                        <tr> <td>1</td>
                                                            <td>Payment for Internet Messages</td>
                                                            <td><?= $sms_price ?></td> 
                                                            <td><?= round($payment->amount / $sms_price, 0) ?></td>
                                                            <td><?= number_format($payment->amount) ?></td>
                                                        </tr>
                                                        <tr> 
                                                            <td colspan="4" class="text-right no-border"><strong>Total</strong></td> 
                                                            <td><strong><?= number_format($payment->amount) ?></strong></td> 
                                                        </tr> 
                                                    </tbody> 
                                                </table>
                                                <ul>
                                                    <p>Total amount in words: PAID,
                                                        <b> <?= numberToWords($total_price) ?></b> 
                                                        <?= $currency ?>
                                                    </p>
                                                    <p></p>
                                                   
                                            </section> 


                                        </section> 
                                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                                    </section> 

                                </section> 
                            </section>
                        </section>
                    </section> 

                </section>
            </section>
        </section>
        <br/><br/>

        <footer id="footer" class="footer bg-white b-t b-light fixed">

            <div class="text-center padder"> 
                <p> <small>KaribuSMS web application<br>&copy; <?= date('Y') ?></small> </p> 

            </div>
        </footer>
        <?php
        $js_array = array(
            'charts/easypiechart/jquery.easy-pie-chart',
            'charts/sparkline/jquery.sparkline.min',
            'charts/flot/jquery.flot.min',
            'charts/flot/jquery.flot.tooltip.min',
            'charts/flot/jquery.flot.resize',
            'sortable/jquery.sortable'
        );
        foreach ($js_array as $js) {
            echo '<script src="' . url('/') . '/media/js/' . $js . '.js"></script>';
        }
        ?>
        <script>
            print_section = function (a) {
                $('.' + a).show();
                window.print();
            }

        </script>
    </body>
</html>

