<?php 
require '../../config/config.php';

//Delete only post
if (isset($_GET['post_id'])) {
	$post_id = $_GET['post_id'];
	$courseCode = $_GET['classCode'];

	$query = mysqli_query($con, "DELETE FROM posts WHERE id='$post_id'");
	header("Location: ../../classRoom.php?classCode=$courseCode");
}


//Delete Comment
if(isset($_GET['comment_id'])){
	$id = $_GET['comment_id'];
	$post_id = $_GET['post_id'];
	$courseCode = $_GET['classCode'];
	
	$query = mysqli_query($con, "DELETE FROM comments WHERE id='$id'");
	header("Location: ../../comment_frame.php?post_id=$post_id");
  }

//Delete only file or assignment
if (isset($_GET['postid'])) {
	$post_id = $_GET['postid'];
	$courseCode = $_GET['classCode'];

	$query = mysqli_query($con, "DELETE FROM posts WHERE id='$post_id'");
	header("Location: ../../classRoom.php?classCode=$courseCode&uploadsuccess");
}

//Delete teaching class
if (isset($_GET['createClass_id'])) {
	$createClass_id = $_GET['createClass_id'];
	$courseCode = $_GET['courseCode'];
	
	$query = mysqli_query($con, "DELETE FROM createclass WHERE id='$createClass_id'");
	$query2 = mysqli_query($con, "DELETE FROM posts WHERE courseCode='$courseCode'");
	$query3 = mysqli_query($con, "DELETE FROM comments WHERE courseCode='$courseCode'");
	header("Location: ../../index.php");
}

//Delete  enrolled class
if (isset($_GET['Enrolled_Student'])) {
	$enrolled_Student = $_GET['Enrolled_Student'];
	$courseCode = $_GET['classCode'];

	$query = mysqli_query($con, "UPDATE createclass SET student_array = REPLACE(student_array, '$enrolled_Student', '') WHERE courseCode LIKE '$courseCode' AND student_array  LIKE '%$enrolled_Student%'");
	header("Location: ../../index.php");
}
 