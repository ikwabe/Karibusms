<?php

$notifications = nfcn::find_where(array("business_id"=>$ses_user->id));

$total_number = count($notifications);
if (!empty($notifications)) {
    $message = '';
    foreach ($notifications as $notification) {

        $style=$notification->opened==1? 'style="color:#979797;"':'';
        
        $message.='<a href="#" class="media list-group-item" >
                      <span class="media-body block m-b-none" '.$style.'>' . $notification->content . '<br> 
                    <small class="text-muted">' . $input->make_time_ago($notification->time) . '</small></span></a>';
    }
   
    echo $message;
} else {
    echo 'No any notification for you';
}