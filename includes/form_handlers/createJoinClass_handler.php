<?php
$cName="";
$sec= "";
$sub = "";
$date1= "";
$code = "";
$classCode="";
$username1=  "";
$user2= "";

	$userLoggedIn  = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
	
    //create class part

	if(isset($_POST['createClass_button'])){
		$cName = strip_tags($_POST['className']); //remove html tag
		$cName = str_replace(' ', '', $cName); //remove spaces
	    //$_SESSION['className'] = $cName;   // stores class name into session variable 
        
        $sec = strip_tags($_POST['section']); //remove html tag
		$sec = str_replace(' ', '', $sec); //remove spaces
	    //$_SESSION['section'] = $sec; 

		$sub = strip_tags($_POST['subject']); //remove html tag
		$sub= str_replace(' ', '', $sub);
		//$_SESSION['subject'] = $sub;
		
		
		
		$date1 = date("Y-m-d");
		
	    $code = strtolower($cName . "_" . $sec);
		$check_code_query = mysqli_query($con, "SELECT courseCode FROM createclass WHERE courseCode = '$code'");
			
		$i = 0;
		// if code exsits add user number to code
		while (mysqli_num_rows($check_code_query) != 0) {
			$i++;
			$code = $code . "_" . $i;
			$check_code_query = mysqli_query($con, "SELECT courseCode FROM createclass WHERE courseCode = '$code'");
		}
		$username1 =  $user['username'];	

		if(($cName != "") && ($sec != "") && ($sub != "")){
			$query = mysqli_query($con, "INSERT INTO createclass VALUES('', '$username1', '$cName', '$sec','$sub', '$code', '$date1', '', '' )");
		}

		$_SESSION['className'] = "";
		$_SESSION['section'] = "";
		$_SESSION['subject'] = "";
		header("Location: index.php");
        exit();   
	 }


	 //Join class part
	 
	 if(isset($_POST['joinClass_button'])){
		$classCode = strip_tags($_POST['code']); //remove html tag
		$classCode = str_replace(' ', '', $classCode); //remove spaces
		 
		
		$data_query = mysqli_query($con, "UPDATE createclass SET student_array=CONCAT(student_array,'$userLoggedIn ,') WHERE courseCode='$classCode'");
		$query1 = mysqli_query($con,"SELECT * FROM users WHERE username='$userLoggedIn'");
		$fetchQ = mysqli_fetch_array($query1);
		$userID = $fetchQ['id'];
		$query2 = mysqli_query($con,"SELECT * FROM createclass WHERE courseCode = '$classCode'");
		$fetchQ1 = mysqli_fetch_array($query2);
		$classID = $fetchQ1['id'];

		$query3 = mysqli_query($con, "INSERT INTO joinClass VALUES('$userID','$classID')");
		
      header("Location: index.php");
      exit();
	 }
    // cancel 
	 if(isset($_POST['cancel_button'])){
        header("Location: index.php");
		exit();
	 }

 ?>