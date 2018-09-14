<?php

if (isset($ses_user)) {
    $notifications = notification::find_where(array("client_id" => $ses_user->id, "is_opened" => 0));
    echo count($notifications);
}
?>