<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/User2.php");

$limit = 7; //Number of messages to load

$notification = new User2($con, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>