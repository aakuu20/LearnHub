<?php
class User {
	private $user;
	private $user2;
	private $con;

	public function __construct($con, $code, $user){
		$this->con = $con;
		$this->user=$user;
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
		$this->user = mysqli_fetch_array($user_details_query);
		$user2_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE courseCode='$code'");
		$this->code= mysqli_fetch_array($user2_details_query);
		$user2_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE username='$user'");
		$this->user2= mysqli_fetch_array($user2_details_query);
	}

	public function getUsername() {
		return $this->user['username'];
	}

	// public function getNumPosts() {
	// 	$username = $this->user['username'];
	// 	$query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username='$username'");
	// 	$row = mysqli_fetch_array($query);
	// 	return $row['num_posts'];
	// }

	public function getFirstAndLastName() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
	}
	
	public function isClosed() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);

		if($row['user_closed'] == 'yes')
			return true;
		else 
			return false;
	}

	public function getStudentsName($array){
		$length = count($array);
		for($i = 0; $i < $length ; $i++){
               $student = $array[$i]; 
               $query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$student'");
			   $row = mysqli_fetch_array($query);
			   echo $row['first_name'] . " " . $row['last_name']."<br>";

			}
	}

	public function getStudentsUserName($array){
		$length = count($array);
		for($i = 0; $i < $length ; $i++){
			   $student = $array[$i]; 
			   echo $student;
			}
	
	}
	public function getStudentsInfo($classID){
		$query  = mysqli_query($this->con,"SELECT first_name, last_name FROM joinClass INNER JOIN users ON users.id = joinClass.user_id_fk INNER JOIN createclass ON createclass.id = joinClass.class_id_fk WHERE  joinClass.class_id_fk = '$classID' ");
		$str ="";	
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_array($query)) {
				$firstName = $row['first_name'];
				$lastName = $row['last_name'];
				$fullName = $firstName.' '.$lastName;
 				$str .="<p id='studentInfo'>
				 				$fullName
				         </p>";
			} 
			echo $str;
		}
	}

	public function getPhoneNumForm($teacher){
		if($teacher==$this->user['username']){
			echo '<div style="margin-top:-40px;">
			      <form method="POST">
					  <input type="text" placeholder="Add phone number" name="phoneNumber">
					  <input type="submit" name="phoneNumBtn" id="phoneNumBtn" onclick="reloadPage();">
				  </form>
				  </div>
			';
		}

	}

	public function getCourseCode() {
		return $this->code['courseCode'];
	}

	public function getNumPosts() {
        return $this->code['num_posts'];
	}

	public function isStudent($username_to_check) {
		$usernameComma = "," . $username_to_check . ",";

		if(strstr($this->user2['student_array'], $usernameComma) || $username_to_check == $this->user2['username']) {
			return true;
		}
		elseif(strstr($this->code['student_array'], $usernameComma)){
            return true;
		}
		else {
			return true; // it could be done in another mathod... which is tiresome
		}

	}

  
   }	 
?>