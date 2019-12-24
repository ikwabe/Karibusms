<section class="scrollable padder">
    <ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Payment Reports</li> </ul>

    <div class="m-b-md"> 
        <h3 class="m-b-none"></h3> 
        <small></small> </div>
    <button class="btn btn-sm btn-success" onmousedown="call_page('create_payment')">Add Payment</button>
    <br/>
    <br/>
</section>
<section class="panel panel-default">
    <header class="panel-heading text-right bg-light"> 
        <ul class="nav nav-tabs pull-left">

            <li class="active">
                <a href="#messages-2" data-toggle="tab">
                    <i class="fa fa-comments text-default"></i>
                    Payments for Approval
                </a>
            </li>
            <li class="">
                <a href="#profile-2" data-toggle="tab">
                    <i class="fa fa-user text-default"></i>
                    Payment Summary Report
                </a>
            </li>

        </ul> 
        <span class="hidden-sm">payment</span> 
    </header>
    <div class="panel-body"> 
        <div class="tab-content">
            <div class="tab-pane  active" id="messages-2">
                <table class="table table-striped b-t b-light text-sm" id="mytable">
                    <thead>
                        <tr> 
                            <th>Name </th>
                            <th>Email</th>
                            <th>Phone number</th> 
                            <th>Payment date</th>
                            <th>Payment Method</th>
                            <th>Reference ID </th>
                            <th>Amount</th>
                            <th>SMS provided</th>
                            <th>Invoice</th>
                            <th>Receipt Code</th>
                            <th>Action</th>
                        </tr> 
                    </thead> 
                </table>
            </div>

            <div class="tab-pane fade" id="profile-2">

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
                            <a class="clear" href="">
                                <span class="h3 block m-t-xs">
                                 
                                </span>
                                <small class="text-muted">Total Amount Collected</small> </a>
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
                              
                                <small class="text-muted text-uc">SMS Remain</small>
                            </a>
                        </div>

                    </div>
                    <br/><br/><br/>
                    <h3>Payment history</h3>
                    <br/>
                    <table class="table">
                        <thead>
                            <tr> 
                                <th>Name </th>
                                <th>Email</th>
                                <th>Phone number</th> 
                                <th>Payment date</th>
                                <th>Payment Method</th>
                                <th>Reference ID </th>
                                <th>Amount</th>
                                <th>Receipt Code</th>
                               
                            </tr> 
                        </thead> 
                     
                    </table>
                </section>
            </div> 


        </div> 
    </div>
</section>
<script src="<?= url('/') ?>/media/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?= url('/') ?>/media/css/table.css" rel="stylesheet">
<script type="text/javascript">
                                            mydatatable = function () {
                                                $('.table').dataTable();
                                            };
                                            mydatatable();
                                            accept_payment = function (a, b, c) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '<?= url('store_payment') ?>',
                                                    data: {payment_id: a, status: b, number: c},
                                                    success: function (data) {
                                                        alert(data);
                                                    }
                                                })
                                            }
</script>