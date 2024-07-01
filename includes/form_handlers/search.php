<?php 
require '../../config/config.php';
if (isset($_GET['classCode'])) {
    $courseCode = $_GET['classCode'];
    $search = "asdas";
	header("Location: ../../classRoom.php?classCode=$courseCode&search=$search");
}
?>