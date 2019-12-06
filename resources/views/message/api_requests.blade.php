<?php
/**
 * Description of received_sms
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<aside class="bg-white  b-l" id="email-content"  style="min-height: 21em;">
    <section class="vbox">
        <section class="scrollable"> 
            <div class="wrapper b-b b-light"> 
                <a href="#" data-toggle="class" class="pull-left m-r-sm">
                    <!--<i class="fa fa-star-o fa-1x text"></i>-->
                    <i class="fa fa-star text-warning fa-1x text-active"></i>
                </a> 

                <h4 class="m-n">
                    <?php
//                    $category_name = $message->name == '' ? 'No category' : $message->name;
//                    echo 'Category: <span class="badge badge-info">' . $category_name . '</span>';
                    ?></h4> 
            </div> 
            <div class="text-sm padder m-t">
                <div class="block clearfix m-b"> 
                    <h3>SMS API Requests</h3>
                    <br/>
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Time</th>
                                <th>Content</th>
                                <th>Remote IP</th>
                                <th>Host name</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($messages as $message) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $message->created_at ?></td>
                                    <td><?= $message->content ?></td>

                                    <td><?= $message->remote_ip ?></td>
                                    <td><?= $message->remote_hostname ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <script src="<?= url('/') ?>/media/js/datatables/jquery.dataTables.min.js"></script>
                    <link href="<?= url('/') ?>/media/css/table.css" rel="stylesheet">
                    <script type="text/javascript">
                        $('.dataTable').dataTable();
                    </script>
                </div>


            </div>
            <!--	    <div class="padder"> 
                            <div class="panel text-sm bg-light"> 
                                <div class="panel-body"> Click here to <a href="#">Reply</a> or <a href="#">Forward</a> </div>
                            </div>
                        </div>-->

        </section> 
    </section> 
</aside>