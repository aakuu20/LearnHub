<?php 
include("header.php");

$user_array = "";
$courseName = "";
$sec = "";
$body = "";
$post_id = "";
$searchPost= "";

//fetching class room details
$classCode = $_GET['classCode'];
$user_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE courseCode='$classCode'");
$user_array = mysqli_fetch_array($user_details_query);
$courseName = $user_array['className'];
$sec = $user_array['section'];
// $classMates  = $user_array['student_array'];
// $classMates = str_replace(',', ' ', $classMates);
// $array = explode(" ", $classMates);
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
    $data_query = mysqli_query($con, "SELECT * FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($data_query);
    $body = $row['body'];

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
    header("Location: search.php?classCode=$classCode");
}
//edit
if (isset($_POST['cancel'])) {
    header("Location: search.php?classCode=$classCode");
}

//when uploading files


if(isset($_GET['searchedPost'])){
    $searchPost = $_GET['searchedPost'];
}

if(isset($_POST['search__btn'])){
    $searchPost = $_POST['searched_text'];
}
?>

<div class=Wrapper2>


    <div class="user_details cloumn">
    <center><h1> <i class="fa fa-chalkboard-teacher"></i> <a href="classRoom.php?classCode=<?php echo $classCode?>"><?php echo $courseName ?></a></h1></center>
        <p style='line-height:30px; display: inline-block;'><b>Section:</b> <?php echo $sec ?>
            <br>
            <b>Class Code:</b> <?php echo $classCode ?><span id="code_expand"><i class="fas fa-expand-arrows-alt"></i></span>
        </p>
        <form action="" method="POST" class="search__form">
                <input type="text" placeholder='Search posts' autocomplete='off'  id='search-bar' name='searched_text'><button id="search__btn" name="search__btn"><i class="fas fa-search"></i></button> 
        </form> 
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
                <a href="search.php?classCode=$classCode"><input type="submit" name="cancel" value="Cancel" class="edit_box_btn" id="update_cancel_btn"></a>
                <input type="submit" name="update" value="Update" class="edit_box_btn" id="update_btn">
            </form>
        </div>
    </div>

    <div class="people_column">
    <h4>Instructor:</h4><a href="<?php echo $teacherName; ?>"><img src='<?php echo $teacherDetails['profilePic'] ?>' width='40'><?php echo $teacherDetails['first_name'] . " " . $teacherDetails['last_name'] ?></a>
        <br>
        <?php 
        $stundentsName  = new User($con, $classCode ,$userLoggedIn);
        echo "<p><b>Class Members:</b> </p>"; ?>
             <?php $stundentsName->getStudentsInfo($classID); ?>
    </div>

    <div class="main_column">
        <?php 
            $post = new Post($con, $userLoggedIn2, $classCode);
            $post->searchPosts($searchPost);
        ?>
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

    
</script>
</body>

</html> 