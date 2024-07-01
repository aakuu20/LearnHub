<?php 
include("header.php");

$user_array = "";
$courseName = "";
$sec = "";
$body = "";
$post_id = "";
$searchedPost = "";

//fetching class room details
$classCode = $_GET['classCode'];
$user_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE courseCode='$classCode'");
$user_array = mysqli_fetch_array($user_details_query);
$courseName = $user_array['className'];
$sec = $user_array['section'];
$classMates  = $user_array['student_array'];
$classMates = str_replace(',', ' ', $classMates);
$array = explode(" ", $classMates);
$classID = $user_array['id'];

//fetching teacher details
$teacherName = $user_array['username'];
$user_details_query2 = mysqli_query($con, "SELECT * FROM users WHERE username='$teacherName'");
$teacherDetails = mysqli_fetch_array($user_details_query2);

//when hitting the post 
if (isset($_POST['post'])) {
    $post = new Post($con, $userLoggedIn2, $classCode);
    $post->submitPost($_POST['post_text'], 'none', 'none', $teacherName);
}

//edit
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $data_query = mysqli_query($con, "SELECT body FROM posts WHERE id='$post_id'");
    $body = mysqli_fetch_array($data_query);
    

    echo '
	<script>
		$(document).ready(function(){
			$("#modal2").show();
		});
	</script>
	';
} //edit
if (isset($_POST['update'])) {
    $post = new Post($con, $userLoggedIn2, $classCode);
    $post->submitEditPost($_POST['editedPost_text'], $post_id);
    header("Location: classRoom.php?classCode=$classCode");
}
//edit
if (isset($_POST['cancel'])) {
    header("Location: classRoom.php?classCode=$classCode");
}

//when uploading files

if (isset($_POST['upload'])) {

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed  = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'pptx', 'ppt');
    $res = str_replace($allowed, "", $fileName);

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000000000) {
                $fileNameNew = uniqid(" ", true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $res . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination); //file uploaded okay

                $post = new Post($con, $userLoggedIn, $classCode);
                $post->submitPost($_POST['assignment_text'], $fileNameNew, $fileDestination,$teacherName);
                //$post->getFileDestination($fileDestination); 

                header("Location: classRoom.php?classCode=$classCode&uploadsuccess");
            } else {
                echo "your file is too big";
            }
        } else {
            echo "Error uploading your file!  ";
        }
    } else {
        echo "You can't upload file of this";
    }
}

if (isset($_GET['uploadsuccess'])) {   // hold back the assignment div(#second) after delete or upload
    echo '<script>
                     $(document).ready(function(){
                         $("#first").hide();
                         $("#second").show();
                       });
                       </script>
                       ';
}

if(isset($_POST['search__btn'])){
    $searchedPost = $_POST['searched_text'];
    header("Location: search.php?classCode=$classCode&searchedPost=$searchedPost");
}
?>

<div class=Wrapper2>


    <div class="user_details cloumn">
        <center><h1> <i class="fa fa-chalkboard-teacher"></i> <?php echo $courseName ?></h1></center>
        <p style='line-height:30px; display: inline-block;'><b>Section:</b> <?php echo $sec ?>
            <br>
            <b>Class Code:</b> <?php echo $classCode ?><span id="code_expand"><i class="fas fa-expand-arrows-alt"></i></span>
        </p>
        <form action="" method="POST" class="search__form">
                <input type="text" placeholder='Search posts' autocomplete='off'  id='search-bar' name='searched_text'><button id="search__btn" name="search__btn"><i class="fas fa-search"></i></button>
        </form> 
        <div class="assignment_box">
            <a href="#" id="postBtn"><i class="fab fa-megaport" style='margin-right: 5px;'></i>Post</a>
            
            <a href="#" id="assignmentBtn"><i class="far fa-file-word" style='margin-right: 5px;'></i>Assignment Section</a>
            <?php  if(isset($_POST['upload'])) {
             echo'<span class="assgn-Btn_notification_badge" id="unread_notification"></span>';   
            }?>
        </div>
    </div>

    <div id="modal">
        <div id="modal_container">
            <span id="close_btn">&times;</span>
            <p id="code_modal"><?php echo $classCode ?></p>
        </div>
    </div>

    <div id="modal2">
        <div id="modal_bg"></div>
        <div id="edit_box">
            <form class="edit_form" method="POST">
                <textarea name="editedPost_text" id="edit_textarea"><?php echo $body; ?></textarea>
                <a href="classRoom.php?classCode=$classCode"><input type="submit" name="cancel" value="Cancel" class="edit_box_btn" id="update_cancel_btn"></a>
                <input type="submit" name="update" value="Update" class="edit_box_btn" id="update_btn">
            </form>
        </div>
    </div>

    <div class="people_column">
       <h4>Instructor:</h4><a href="<?php echo $teacherName; ?>"><img src='<?php echo $teacherDetails['profilePic'] ?>' width='40'><?php echo $teacherDetails['first_name'] . " " . $teacherDetails['last_name'] ?></a>
        <br>
        <!-- <?php echo "Posts: " . $user_array['num_posts'] . "<br>"; ?> -->
        <!-- <?php 
        $stundentsName  = new User($con, $classCode ,$userLoggedIn);
        echo "<p><b>Class Members: </b></p>"; ?>
             <?php $stundentsName=implode(', ',$array);
             echo $stundentsName; ?>  -->

    <?php 
        $stundentsName  = new User($con, $classCode ,$userLoggedIn);
        echo "<p><b>Class Members:</b> </p>"; ?>
             <?php $stundentsName->getStudentsInfo($classID); ?>
    </div>

    <div class="main_column">
        <div id="first">
            <form class="post_form" method="POST">
                <textarea name='post_text' id='post_text_area' placeholder='Share something...'></textarea>
                <input type='submit' name='post' id='post_button' value='post'>
                
            </form>

            <?php
            $post = new Post($con, $userLoggedIn, $classCode);
            $post->loadPosts();
            ?>
        </div>

        <div id="second">
            <form class="assignment_form" method="POST" enctype="multipart/form-data">
                <input type="file" name="file" id="fileToUpload">
                <textarea name='assignment_text' id='assignment-textarea' placeholder='Type here'></textarea>
                <a href='classRoom.php?classCode=$courseCode'><input type='submit' name='upload' id='assignment-upload-button' value='Upload'></a>
                <hr>
            </form>
            <?php
            $post = new Post($con, $userLoggedIn, $classCode);
            $post->loadFiles();
            ?>
        </div>
          
         
    </div>


</div>


<script>
    var expandBtn = document.getElementById('code_expand');
    var modal = document.getElementById("modal");
    var closeBtn = document.getElementById("close_btn");

    expandBtn.addEventListener('click', openModal);

    closeBtn.addEventListener('click', closeModal);

    window.addEventListener('click', clickOutsideModal);

    function openModal() {
        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    function clickOutsideModal(e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    }

    let editBtn = document.getElementsByClassName('edit_post_btn');
    let modal2 = document.getElementById("modal2");
    let updateBtn = document.getElementById("update_btn");
    let cancelBtn = document.getElementById('update_cancel_btn');

    // for (var i = 0; i < editBtn.length; i++) {
    //     editBtn[i].addEventListener('click', openModal2);
    // }

    updateBtn.addEventListener('click', closeModal2);
    // cancelBtn.addEventListener('click', closeModal2);

    // function openModal2() {
    //     modal2.style.display = 'block';
    // }

    function closeModal2() {
        modal.style.display = 'none';
    }

    $(document).ready(function() {
        $('edit_post_btn').click(function() {
            modal2.style.display = 'block';
        });
    });


    //slide up down of post and assignment 

    //on click signup, hide login and show registration form
    $(document).ready(function() {

        $("#assignmentBtn").click(function() { //show assignment form and hide post form 
            $("#first").slideUp("slow", function() {
                $("#second").slideDown("slow");
            });
        });

        $("#postBtn").click(function() {
            $("#second").slideUp("slow", function() { //vice versa
                $("#first").slideDown("slow");
            });
        });
    });
    
    
</script>
</body>

</html> 