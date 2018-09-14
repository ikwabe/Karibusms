<?php

$notifications = notification::find_where(array("client_id"=>$ses_user->id),'',6);

$total_number = count($notifications);
if (!empty($notifications)) {
    $message = '';
    foreach ($notifications as $notification) {

        $style=$notification->opened==1? 'style="color:#979797;"':'';
        
        $message.='<a href="#" class="media list-group-item" >
                      <span class="media-body block m-b-none" '.$style.'>' . $notification->content . '<br> 
                    <small class="text-muted">' . $input->make_time_ago($notification->time) . '</small></span></a>';
        
        $db->update('notification',array('is_opened'=>1),"client_id='".$ses_user->id."'");
    }
   
    echo json_encode(array(
        'total_number'=>$total_number,
        'message'=>$message
    ));
} else {
    echo json_encode(array(
        'total_number' => $total_number,
        'message' => ''
    ));
}
?>