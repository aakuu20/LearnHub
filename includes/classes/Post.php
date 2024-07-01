 <?php
	class Post
	{
		private $user;
		private $user_obj;
		private $con;
		private $code;
		public $fileDestination;

		public function __construct($con, $user, $code)
		{
			$this->con = $con;
			$this->user = $user;
			$this->code = $code;
			$this->user_obj = new User($con, $code, $user);
		}

		public function submitPost($body, $fileName, $fileDestination,$user_to)
		{
			$body = strip_tags($body); //removes html tags 
			$body = mysqli_real_escape_string($this->con, $body);
			$check_empty = preg_replace('/\s+/', '', $body); //Deletes all spaces 

			if ($check_empty != "" && $fileName == "") {
				
				//Current date and time
				$date_added = date("Y-m-d H:i:s");
				//Get username
				$added_by = $this->user_obj->getUsername();
				
				;
				//If user is on own class room, user_to is 'none'
				if($added_by == $user_to) {
					$user_to = 'none';
				}

				//insert post 
				$query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$check_empty', '$added_by','$this->code', '$user_to', '$date_added', 'no', 'no','','')");
				$returned_id = mysqli_insert_id($this->con);

                //Insert notification 
                if($user_to != 'none') {
					$notification = new  User2($this->con, $added_by);
					$notification->insertNotification($returned_id, $user_to, "classRoom_post");
				} 
				//Update post count for user 
				// $num_posts = $this->user_obj2->getNumPosts();
				// $num_posts++;
				// $update_query = mysqli_query($this->con, "UPDATE createclass SET num_posts='$num_posts' WHERE courseCode='$course_code'");
			}
			if ($fileName != "") {  //only assignment
				//Current date and time
				$date_added = date("Y-m-d H:i:s");
				//Get username
				$added_by = $this->user_obj->getUsername();
				//If user is on own class room, user_to is 'none'
				if($added_by == $user_to) {
					$user_to = 'none';
				}
				//Insert notification 
                if($user_to != 'none') {
					$notification = new  User2($this->con, $added_by);
					$notification->insertNotification($returned_id, $user_to, "classRoom_post");
				} 
				//Get course Code
				$course_code = $this->user_obj->getCourseCode();
				//insert post
				$query = mysqli_query($this->con, "INSERT  INTO posts VALUES('', '$body', '$added_by','$this->code', '$user_to', '$date_added', 'no', 'no','$fileName','$fileDestination')");
				$returned_id = mysqli_insert_id($this->con);
			}
		}

		public function submitEditPost($edited_body, $id)
		{

			//edited post
			$edited_body = strip_tags($edited_body); //removes html tags
			$edited_body = mysqli_real_escape_string($this->con, $edited_body);
			$check_empty = preg_replace('/\s+/', '', $edited_body); //Deletes all spaces

			if ($check_empty != "") {
				$query = mysqli_query($this->con, "UPDATE posts SET body = '$edited_body ', edited ='Yes' WHERE id='$id'");

				//Insert notification
			}
		}

		public function loadPosts()
		{

			$userLoggedIn = $this->user_obj->getUsername();


			$str = ""; //String to return 
			$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE courseCode='$this->code' AND files ='none'   ORDER BY id DESC");

			if (mysqli_num_rows($data_query) > 0) {

				while ($row = mysqli_fetch_array($data_query)) {
					$id = $row['id'];
					$body = $row['body'];
					$added_by = $row['added_by'];
					$date_time = $row['date_added'];
					$edited = $row['edited'];

					//Prepare user_to string so it can be included even if not posted to a user
					if ($row['user_to'] == "none") {
						$user_to = "";
					} else {
						$user_to_obj = new User($this->con,$this->code ,$row['user_to']);
						$user_to_name = $user_to_obj->getFirstAndLastName();
						$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
					}


					//Check if user who posted, has their account closed
					$added_by_obj = new User($this->con,$this->code ,$added_by);
					if ($added_by_obj->isClosed()) {
						continue;
					}
					$editPost_button = "";
					
					if ($userLoggedIn == $added_by) {
						$deletePost_button = "<a class='delete_button' href='includes/form_handlers/delete_post.php?post_id=$id&amp;classCode=$this->code'><input id='delete_post_btn' type='button' value='Delete'></a>";
						$editPost_button = "<a href='classRoom.php?post_id=$id&amp;classCode=$this->code'><input  class='edit_post_btn' type='button' name='edit' value='Edit'></a>";
					} else {
						$deletePost_button = "";
					}


					$user_logged_obj = new User($this->con, $this->code, $userLoggedIn);
					if ($user_logged_obj->isStudent($added_by)) {

						$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profilePic FROM users WHERE username='$added_by'");
						$user_row = mysqli_fetch_array($user_details_query);
						$first_name = $user_row['first_name'];
						$last_name = $user_row['last_name'];
						$profilePic = $user_row['profilePic'];

						?>
 <script>
     function toggle<?php echo $id; ?>() {
         var element = document.getElementById("toggleComment<?php echo $id; ?>");

         if (element.style.display == "block")
             element.style.display = "none";
         else
             element.style.display = "block";
     }
 </script>
 <?php


	$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
	$comments_check_num = mysqli_num_rows($comments_check);

	//Timeframe
	$date_time_now = date("Y-m-d H:i:s");
	$start_date = new DateTime($date_time); //Time of post
	$end_date = new DateTime($date_time_now); //Current time
	$interval = $start_date->diff($end_date); //Difference between dates 
	if ($interval->y >= 1) {
		if ($interval == 1)
			$time_message = $interval->y . " year ago"; //1 year ago
		else
			$time_message = $interval->y . " years ago"; //1+ year ago
	} else if ($interval->m >= 1) {
		if ($interval->d == 0) {
			$days = " ago";
		} else if ($interval->d == 1) {
			$days = $interval->d . " day ago";
		} else {
			$days = $interval->d . " days ago";
		}


		if ($interval->m == 1) {
			$time_message = $interval->m . " month" . $days;
		} else {
			$time_message = $interval->m . " months" . $days;
		}
	} else if ($interval->d >= 1) {
		if ($interval->d == 1) {
			$time_message = "Yesterday";
		} else {
			$time_message = $interval->d . " days ago";
		}
	} else if ($interval->h >= 1) {
		if ($interval->h == 1) {
			$time_message = $interval->h . " hour ago";
		} else {
			$time_message = $interval->h . " hours ago";
		}
	} else if ($interval->i >= 1) {
		if ($interval->i == 1) {
			$time_message = $interval->i . " minute ago";
		} else {
			$time_message = $interval->i . " minutes ago";
		}
	} else {
		if ($interval->s < 30) {
			$time_message = "Just now";
		} else {
			$time_message = $interval->s . " seconds ago";
		}
	}

	$checkEdit = "";
	if ($edited == "Yes") {
		$checkEdit = "Edited";
	}


	$str .= "<div class='status_post' >
										<div class='post_profile_pic'>
											<img src='$profilePic' width='50'>
										</div>
										<div class='posted_by' style='color:#ACACAC;'>
										     
											<a href='$added_by'> $first_name $last_name </a>  &nbsp;&nbsp;<span style='font-size: 12px; '>$time_message </span> 
											$deletePost_button $editPost_button
											</div>
										<div id='post_body'>
											<p>$body</p>
										</div>
										 <div class='commentOption' onClick='javascript:toggle$id()'> 
										   Comments($comments_check_num)<span class='edited-det'>$checkEdit  </span> 
										 </div>
								       </div>
								          <div class='post_comment' id='toggleComment$id' style='display:none;'>
											<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' ></iframe>
								    
										</div>
									<hr>";
}
?>
 <script>
     $(".delete_button").click(function() {
         return confirm("Are you sure you want to delete this post?"); // this js is not working
     });
 </script>
 <?php

} //End of the while loop

echo $str;
}
}

// public function getFileDestination($fileDestination){
//    $this->fileDestination = $fileDestination;
// }

public function loadFiles()
{

	$userLoggedIn = $this->user_obj->getUsername();

	$str = ""; //String to return
	$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE courseCode='$this->code' AND files !='none'   ORDER BY id DESC");

	if (mysqli_num_rows($data_query) > 0) {

		while ($row = mysqli_fetch_array($data_query)) {
			$id = $row['id'];
			$body = $row['body'];
			$added_by = $row['added_by'];
			$date_time = $row['date_added'];
			$file = $row['files'];
			$path = $row['fileDestination'];

			$user_to_obj = new User($this->con,$this->code,  $row['user_to']);
			$user_to_name = $user_to_obj->getFirstAndLastName();
			$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";


			//Check if user who posted, has their account closed
			$added_by_obj = new User($this->con,$this->code, $added_by);
			if ($added_by_obj->isClosed()) {
				continue;
			}

			//edit and delete option
			if ($userLoggedIn == $added_by) {
				$deletePost_button = "<a class='delete_button' href='includes/form_handlers/delete_post.php?postid=$id&amp;classCode=$this->code'><input id='delete_post_btn' type='button' value='Delete'></a>";

				$editPost_button = "<a href='classRoom.php?post_id=$id&amp;classCode=$this->code'><input  class='edit_post_btn' type='button'  value='Edit'></a>";

				// $deleteComment_button ="<a class='delete_button' href='includes/form_handlers/delete_post.php?post_id=$id&amp;classCode=$this->code'><input type='button' value='X'></a>";
			} else {
				$deletePost_button = "";
				$editPost_button = "";
			}

			$user_logged_obj = new User($this->con, $this->code, $userLoggedIn);
			if ($user_logged_obj->isStudent($added_by)) {

				$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profilePic FROM users WHERE username='$added_by'");
				$user_row = mysqli_fetch_array($user_details_query);
				$first_name = $user_row['first_name'];
				$last_name = $user_row['last_name'];
                $profilePic = $user_row['profilePic'];
				?>
 <script>
     function toggle<?php echo $id; ?>() {
         var element = document.getElementById("toggleComment<?php echo $id; ?>");

         if (element.style.display == "block")
             element.style.display = "none";
         else
             element.style.display = "block";
     }
 </script>
 <?php

	$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
	$comments_check_num = mysqli_num_rows($comments_check);

	//Timeframe
	$date_time_now = date("Y-m-d H:i:s");
	$start_date = new DateTime($date_time); //Time of post
	$end_date = new DateTime($date_time_now); //Current time
	$interval = $start_date->diff($end_date); //Difference between dates
	if ($interval->y >= 1) {
		if ($interval == 1) {
			$time_message = $interval->y . " year ago";
		}
		//1 year ago
		else {
			$time_message = $interval->y . " years ago";
		}
		//1+ year ago
	} else if ($interval->m >= 1) {
		if ($interval->d == 0) {
			$days = " ago";
		} else if ($interval->d == 1) {
			$days = $interval->d . " day ago";
		} else {
			$days = $interval->d . " days ago";
		}

		if ($interval->m == 1) {
			$time_message = $interval->m . " month" . $days;
		} else {
			$time_message = $interval->m . " months" . $days;
		}
	} else if ($interval->d >= 1) {
		if ($interval->d == 1) {
			$time_message = "Yesterday";
		} else {
			$time_message = $interval->d . " days ago";
		}
	} else if ($interval->h >= 1) {
		if ($interval->h == 1) {
			$time_message = $interval->h . " hour ago";
		} else {
			$time_message = $interval->h . " hours ago";
		}
	} else if ($interval->i >= 1) {
		if ($interval->i == 1) {
			$time_message = $interval->i . " minute ago";
		} else {
			$time_message = $interval->i . " minutes ago";
		}
	} else {
		if ($interval->s < 30) {
			$time_message = "Just now";
		} else {
			$time_message = $interval->s . " seconds ago";
		}
	}


	$fileExt = explode('.', $file);
	$fileActualExt = end($fileExt);
	$allowed  = array('jpg', 'jpeg', 'png');
	$fileDiv = "";

	if (in_array($fileActualExt, $allowed)) {
		$fileDiv = "<div id='postedFile'>
			<img src='$path' onclick='window.open(this.src)' title='Click Here To View Full Screen'>
				</div>";
	}

	$res = str_replace("uploads/", "", $path);
	$downloadFile = "<div id='downloadFile'>
							<a href ='downloadFiles.php?download=$path' title='Click Here To Download'>$res</a>
						</div>";

	$str .= "<div class='status_post' >
											<div class='post_profile_pic'>
											<img src='$profilePic' width='50'>
										</div>
											<div class='posted_by' style='color:#ACACAC;'>
												<a href='$added_by'> $first_name $last_name </a> &nbsp;&nbsp;<span style='font-size: 12px'>$time_message</span>
												$deletePost_button 
												</div>
											<div id='post_body'>
											<div class='tooltip'></div>
												<p>$body</p>
												$fileDiv
												$downloadFile
											</div>
											<div class='commentOption' onClick='javascript:toggle$id()'>
											Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
											</div>
										</div>
											<div class='post_comment' id='toggleComment$id' style='display:none;'>
												<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' ></iframe>

											</div>
										<hr>";
}
} //End of the while loop

echo $str;
}
}
public function checkTeachingClass(){
	$checkTeaching = false;
	$data_query = mysqli_query($this->con, "SELECT * FROM createclass where username='$this->user' ORDER BY id DESC");
	if (mysqli_num_rows($data_query) > 0) {
	   $checkTeaching = true;
	}
	return $checkTeaching; 
}
public function loadTeachingClasses()
{
	$this->checkTeaching = true;
	$str = ""; //String to return 
	$data_query = mysqli_query($this->con, "SELECT * FROM createclass where username='$this->user' ORDER BY id DESC");
	$userLoggedIn = $this->user_obj->getUsername();


	if (mysqli_num_rows($data_query) > 0) {
		while ($row = mysqli_fetch_array($data_query)) {
			$id = $row['id'];
			$className = $row['className'];
			$section = $row['section'];
			$subject = $row['subject'];
			$code = $row['courseCode'];
			$added_by = $row['username'];


			if ($userLoggedIn == $added_by) {
				$delete_teachingClass = "<a href='includes/form_handlers/delete_post.php?createClass_id=$id&courseCode=$code'><input type='button' id='delete_class_btn' value='Remove'></a>";
			} else {
				$delete_teachingClass = "";
			}

			$str .= "<div class='classBox'>
									
								
								<a href = 'classRoom.php?classCode=$code'> <h3>$className </h3></a> 
								Section: $section
								<br>
								$subject
								<br>
								<p> $delete_teachingClass </p>
				        </div> ";
		}
		echo $str;
	}
}
public function checkEnrolledClass(){
	$checkEnrolled = false;
	$data_query = mysqli_query($this->con, "SELECT * FROM createclass where student_array LIKE'%$this->user%' ORDER BY id DESC");
	if (mysqli_num_rows($data_query) > 0) {
		$checkEnrolled = true;
	}
	return $checkEnrolled; 
}
public function loadEnrolledClasses()
{
	$str = ""; //String to return 
	$data_query = mysqli_query($this->con, "SELECT * FROM createclass where student_array LIKE'%$this->user%' ORDER BY id DESC");


	if (mysqli_num_rows($data_query) > 0) {
		while ($row = mysqli_fetch_array($data_query)) {
			$className = $row['className'];
			$section = $row['section'];
			$subject = $row['subject'];
			$code = $row['courseCode'];

			$delete_EnrolledClass = "<a href='includes/form_handlers/delete_post.php?Enrolled_Student=$this->user&amp;classCode=$code'><input type='button' id='delete_class_btn' value='Leave'></a>";
			$str .= "<div class='EnrolledclassBox'>
					   <a href = 'classRoom.php?classCode=$code'> <h3>$className </h3></a>
					   Section: $section
					   <br>
					   $subject
					   <br>
					   <p> $delete_EnrolledClass </p>
					   </a>
				</div> ";
		}
		echo $str;
	}
}

public function searchPosts($searchedPost){
	if($searchedPost !=" "){
	$userLoggedIn = $this->user_obj->getUsername();
	$query = mysqli_query($this->con,"SELECT * FROM posts WHERE body LIKE '%$searchedPost%' AND courseCode='$this->code' ORDER BY id DESC");
	$str="";
	 
	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_array($query)) {
			$id = $row['id'];
			$body = $row['body'];
			$added_by = $row['added_by'];
			$date_time = $row['date_added'];
			$edited = $row['edited'];
			$file = $row['files'];
			$path = $row['fileDestination'];

			//Prepare user_to string so it can be included even if not posted to a user
				$user_to_obj = new User($this->con,$this->code ,$row['user_to']);
				$user_to_name = $user_to_obj->getFirstAndLastName();
				$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
			


			$editPost_button = "";
			
			if ($userLoggedIn == $added_by) {
				$deletePost_button = "<a class='delete_button' href='includes/form_handlers/delete_post.php?post_id=$id&amp;classCode=$this->code'><input id='delete_post_btn' type='button' value='Delete'></a>";
				$editPost_button = "<a href='search.php?post_id=$id&amp;classCode=$this->code'><input  class='edit_post_btn' type='button' name='edit' value='Edit'></a>";
			} else {
				$deletePost_button = "";
			}


			$user_logged_obj = new User($this->con, $this->code, $userLoggedIn);
			if ($user_logged_obj->isStudent($added_by)) {

				$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profilePic FROM users WHERE username='$added_by'");
				$user_row = mysqli_fetch_array($user_details_query);
				$first_name = $user_row['first_name'];
				$last_name = $user_row['last_name'];
				$profilePic = $user_row['profilePic'];
				?>
<script>
function toggle<?php echo $id; ?>() {
 var element = document.getElementById("toggleComment<?php echo $id; ?>");

 if (element.style.display == "block")
	 element.style.display = "none";
 else
	 element.style.display = "block";
}
</script>
<?php


$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
$comments_check_num = mysqli_num_rows($comments_check);

//Timeframe
$date_time_now = date("Y-m-d H:i:s");
$start_date = new DateTime($date_time); //Time of post
$end_date = new DateTime($date_time_now); //Current time
$interval = $start_date->diff($end_date); //Difference between dates 
if ($interval->y >= 1) {
if ($interval == 1)
	$time_message = $interval->y . " year ago"; //1 year ago
else
	$time_message = $interval->y . " years ago"; //1+ year ago
} else if ($interval->m >= 1) {
if ($interval->d == 0) {
	$days = " ago";
} else if ($interval->d == 1) {
	$days = $interval->d . " day ago";
} else {
	$days = $interval->d . " days ago";
}


if ($interval->m == 1) {
	$time_message = $interval->m . " month" . $days;
} else {
	$time_message = $interval->m . " months" . $days;
}
} else if ($interval->d >= 1) {
if ($interval->d == 1) {
	$time_message = "Yesterday";
} else {
	$time_message = $interval->d . " days ago";
}
} else if ($interval->h >= 1) {
if ($interval->h == 1) {
	$time_message = $interval->h . " hour ago";
} else {
	$time_message = $interval->h . " hours ago";
}
} else if ($interval->i >= 1) {
if ($interval->i == 1) {
	$time_message = $interval->i . " minute ago";
} else {
	$time_message = $interval->i . " minutes ago";
}
} else {
if ($interval->s < 30) {
	$time_message = "Just now";
} else {
	$time_message = $interval->s . " seconds ago";
}
}

$checkEdit = "";
if ($edited == "Yes") {
$checkEdit = "Edited";
}

$fileExt = explode('.', $file);
$fileActualExt = end($fileExt);
$allowed  = array('jpg', 'jpeg', 'png');
$fileDiv = "";

if (in_array($fileActualExt, $allowed)) {
	$fileDiv = "<div id='postedFile'>
		<img src='$path' onclick='window.open(this.src)' title='Click Here To View Full Screen'>
			</div>";
}

$res = str_replace("uploads/", "", $path);
if($path !=0){
$downloadFile = "<div id='downloadFile'>
						<a href ='downloadFiles.php?download=$path' title='Click Here To Download'>$res</a>
					</div>";
}else{
  $downloadFile ="";
}

$str .= "<div class='status_post' >
										<div class='post_profile_pic'>
											<img src='$profilePic' width='50'>
										</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$added_by'> $first_name $last_name </a>  &nbsp;&nbsp;<span style='font-size: 12px; '>$time_message </span> 
									$deletePost_button $editPost_button
									</div>
								<div id='post_body'>
									<p>$body</p>
									$fileDiv
									$downloadFile
								</div>
								 <div class='commentOption' onClick='javascript:toggle$id()'> 
								   Comments($comments_check_num)<span class='edited-det'>$checkEdit  </span> 
								 </div>
							   </div>
								  <div class='post_comment' id='toggleComment$id' style='display:none;'>
									<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' ></iframe>
							
								</div>
							<hr>";
}
?>
<?php

} //End of the while loop

echo $str;
} else{
	echo"There are no results matching your search!";
}
		}
	}
}


?> 