
<?php 
include("header.php");


$ooo = "";
$username = $user['username'];
$userCode = $user2['courseCode'];
$post = new Post($con, $username, $userCode);
$checkTeaching = $post->checkTeachingClass();
$checkEnrolled = $post->checkEnrolledClass();
?>

<div class="bg">
    <div class="wrapper">

        <?php 
          if ($checkTeaching == true) {
               echo "<div class='teaching'>
             <h3><span class='header'>Teaching</span></h3>";
               $post->loadTeachingClasses();
               echo "</div>";
          }

          if ($checkEnrolled == true) {
               echo "<div class='enrolled'>
             <h3><span class='header'>Enrolled:</span></h3>";
               $post->loadEnrolledClasses();
               echo "</div>";
          }
          if (($checkEnrolled == false) && ($checkTeaching == false)) {
               echo "<div id='nullTeachingEnrolled'>
                         <p>It seems you haven't created or enrolled in any class yet!</p>
                         <p>Click the button below or <i class='fas fa-plus' style='padding:0.4rem; color:inherit'></i> above to start with your class</p>
                         
     <a href='createJoinClass.php'>
     <button class='null-button'>Create/Join</button></a>
                     </div>";
          }
          ?>





    </div>
</div>


</body>

</html> 