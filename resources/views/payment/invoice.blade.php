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

                                            <div class="col-lg-12" role="tabpanel" data-example-id="togglable-tabs">
                                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Home</a>
                                                    </li>
                                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Invoice</a>
                                                    </li>

                                                </ul>
                                                <div id="myTabContent" class="tab-content">
                                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                     
                                                        <div class="">
                                                            <div class="">

                                                                <div class="header">

                                                                    <h4 class="modal-title" id="myModalLabel">Payment Methods</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h4>Choose your Preferred  method below</h4>
                                                                    <br/>
                                                                    <div class=" ">
                                                                        <header>
                                                                            <ul class="nav nav-tabs">
                                                                                <li class="active">
                                                                                    <a href="#stats" data-toggle="tab" aria-expanded="true">M-Pesa </a>
                                                                                </li>
                                                                                <li class="">
                                                                                    <a href="#report" data-toggle="tab" aria-expanded="false">TigoPesa</a>
                                                                                </li>
                                                                                <li class="">
                                                                                    <a href="#manual" data-toggle="tab" aria-expanded="false">Airtel Money</a>
                                                                                </li>
                                                                                <li class="">
                                                                                    <a href="#halopesa" data-toggle="tab" aria-expanded="false">HaloPesa</a>
                                                                                </li>
                                                                                <li class="">
                                                                                    <a href="#ezypesa" data-toggle="tab" aria-expanded="false">EZYPESA</a>
                                                                                </li>
                                                                                <li class="">
                                                                                    <a href="#tpesa" data-toggle="tab" aria-expanded="false">T-Pesa</a>
                                                                                </li>
                                                                                <li class="">
                                                                                    <a href="#selcom_card" data-toggle="tab" aria-expanded="false">SELCOM-CARD</a>
                                                                                </li>
                                                                                <li class="">
                                                                                    <a href="#mobile_banking" data-toggle="tab" aria-expanded="false"> Mobile Banking</a>
                                                                                </li>
                                                                            </ul>
                                                                        </header>
                                                                        <div class="body tab-content">
                                                                            <div id="stats" class="tab-pane clearfix col-lg-offset-1 active">
                                                                                <br/>
                                                                                <h2>M-pesa Payment instructions</h2>

                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial *150*00# to access your M-pesa Menu</li>
                                                                                    <li>Select option 4,Lipa by M-pesa</li>
                                                                                    <li>Select option 4, to enter business number </li>
                                                                                    <li>Enter Business Number <b> 123123</b></li>
                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>
                                                                                    <li>Enter pin to confirm </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>
                                                                                <p></p>
                                                                                <p>

                                                                                </p>

                                                                            </div>
                                                                            <div id="report" class="tab-pane col-lg-offset-1">
                                                                                <br/>
                                                                                <h2>Tigo-pesa Payment instructions</h2>

                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial *150*01# to access your Tigo pesa Menu</li>
                                                                                    <li>Select option 5, for Merchant payment</li>
                                                                                    <li>Select option 2, Pay Mastercard QR Merchant </li>

                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>
                                                                                    <li>Enter pin to confirm </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>
                                                                                <p></p>


                                                                            </div>
                                                                            <div id="manual" class="tab-pane col-lg-offset-1">
                                                                                <br/>
                                                                                <h2>Airtel Money Payment</h2>
                                                                                <p></p>
                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial *150*60# to access your Airtel-Money Menu</li>
                                                                                    <li>Select option 5, for payment</li>
                                                                                    <li>Select option 1, for Merchant payments  </li>
                                                                                    <li>Select option 1, Pay with Mastercard QR</li>

                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>
                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter pin to confirm </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>

                                                                                <p></p>
                                                                                <p>

                                                                                </p>

                                                                            </div>
                                                                            <div id="halopesa" class="tab-pane col-lg-offset-1">
                                                                                <br/>
                                                                                <h2>HaloPesa Payment</h2>
                                                                                <p></p>
                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial *150*88# to access your HaloPesa Menu</li>
                                                                                    <li>Select option 5, for payment</li>
                                                                                    <li>Select option 3, Pay with Mastercard QR</li>
                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>

                                                                                    <li>Enter pin to confirm </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>

                                                                                <p></p>
                                                                                <p>

                                                                                </p>

                                                                            </div>
                                                                            <div id="ezypesa" class="tab-pane col-lg-offset-1">
                                                                                <br/>
                                                                                <h2>EzyPesa Payment</h2>
                                                                                <p></p>
                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial *150*02# to access your EzyPesa Menu</li>
                                                                                    <li>Select option 5, for payment</li>
                                                                                    <li>Select option 1, for Lipa Hapa</li>
                                                                                    <li>Select option 2, Pay with Mastercard QR</li>
                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>

                                                                                    <li>Enter pin to confirm </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>

                                                                                <p></p>
                                                                                <p>

                                                                                </p>

                                                                            </div>

                                                                            <div id="tpesa" class="tab-pane col-lg-offset-1">
                                                                                <br/>
                                                                                <h2>T-Pesa Payment</h2>
                                                                                <p></p>
                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial *150*71# to access your T-Pesa Menu</li>
                                                                                    <li>Select option 6, for payment</li>

                                                                                    <li>Select option 2, Pay with Mastercard QR</li>
                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>

                                                                                    <li>Enter pin to confirm </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>

                                                                                <p></p>
                                                                                <p>

                                                                                </p>

                                                                            </div>
                                                                            <div id="selcom_card" class="tab-pane col-lg-offset-1">
                                                                                <br/>
                                                                                <h2>Selcom Card Payment</h2>
                                                                                <p></p>
                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial *150*50# to access your Selcom Card Menu</li>
                                                                                    <li>Enter pin to confirm </li>

                                                                                    <li>Select option 2, Pay with Mastercard QR</li>
                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>

                                                                                    <li>Confirm Payments by entering 1 </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>

                                                                                <p></p>
                                                                                <p>

                                                                                </p>

                                                                            </div>
                                                                            <div id="mobile_banking" class="tab-pane col-lg-offset-1">
                                                                                <br/>
                                                                                <h2>Pay with mobile banking or download Masterpass Tanzania App</h2>
                                                                                <p><img src="<?= url(config('app.server_url').'/public/assets/images/banks.JPG') ?>"/></p>
                                                                                <p></p>
                                                                                <ol>
                                                                                    <li>Dial  your bank's USSD code </li>
                                                                                    <li>Enter pin to confirm </li>

                                                                                    <li>Select Mastercard QR</li>
                                                                                    <li>Enter Reference Number : <b><?= $booking->token ?></b></li>
                                                                                    <li>Enter amount for your payment Tsh <b><?= number_format($booking->amount) ?></b></li>
                                                                                    <li>Confirm Payments by entering 1 </li>
                                                                                    <li>Once you get SMS confirmation, click "Proceed" to continue </li>
                                                                                </ol>

                                                                                <p></p>
                                                                                <p>

                                                                                </p>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="<?= url('#invoice/cancel/' . $booking->order_id) ?>" class="btn btn-default">Cancel </a>
                                                                    <a href="<?= url('#home') ?>" class="btn btn-success" >Proceed </a>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                                        <header class="header b-b b-light hidden-print">

                                                            <p>Invoice</p> <button style="margin-top:1%" class="pull-right btn btn-sm " onclick="print_section('printable')"><i class="fa fa-print"></i>Print</button></header>
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
                                                                    <p class="h4">#<?= $booking->token ?></p> 
                                                                    <h5><?= date('d M Y') ?></h5>

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
                                                            <p class="m-t m-b">Order date: <strong><?= date('d M Y') ?></strong>

                                                                <br> Invoice No: <strong>#<?= $booking->token ?></strong> </p>
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
                                                                        <td><?= round($quantity, 0) ?></td>
                                                                        <td><?= $total_price ?></td>
                                                                    </tr>
                                                                    <tr> 
                                                                        <td colspan="4" class="text-right no-border"><strong>Total</strong></td> 
                                                                        <td><strong><?= $total_price ?></strong></td> 
                                                                    </tr> 
                                                                </tbody> 
                                                            </table>
                                                            <ul>
                                                                <p>Total amount in words:
                                                                    <b> <?= numberToWords($total_price) ?></b> 
                                                                    <?= $currency ?>
                                                                </p>
                                                                <p></p>
                                                                <b>PAYMENT METHODS</b>
                                                                <p>To be paid via mobile payments, bank cheque, cash or direct bank deposits via </p>
                                                                <p>BANK NAME: <b>NMB BANK </b></p>
                                                                <p>Account name: <b>INETS COMPANY LIMITED</b></p>
                                                                <p>Account Number:  <b>22510028669</b></p>
                                                            </ul>
                                                        </section> 
                                                    </div>

                                                </div>
                                            </div>


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
        print_section=function(a){
            $('.'+a).show();
            window.print();
        }
            
        </script>
    </body>
</html>

