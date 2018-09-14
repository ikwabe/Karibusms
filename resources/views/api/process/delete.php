<?php

$id=$_GET['id'];
$db->delete('developer_app', array("developer_id" => $id));
echo '<div class="alert alert-success">App deleted</div>';
?>