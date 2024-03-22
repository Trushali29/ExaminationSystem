<?php 
  session_start();

  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
      header("location: http://localhost/ExaminationSystem/admin/AdminMain.php ");
  }
?>

        
<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <style>
            <?php include '../css/AdminMain.css'; ?>
        </style>
   </head>
   <body>
    <nav class="navbar"  id="menu">
        <div class="container-fluid" id="container">
                <ul class="nav navbar-nav" id="nav-link">   
                    <li><a href="http://localhost/ExaminationSystem/admin/AdminHome.php" id="link">Home</a></li>
                    <li><a href="http://localhost/ExaminationSystem/admin/Students.php" id="link">Student</a></li>
                    <li>
                        <div class="dropdown">
                            <button href="#" data-toggle="dropdown" id="link-btn">Exam paper <span class="caret"></span></button>
                            <div class="dropdown-menu" id="exam-menu">
                                <a href="http://localhost/examinationsystem/admin/Exam.php" id="link1">Create exam paper</a>
                                <a href="http://localhost/examinationsystem/admin/add_questions.php" id="link1">Create questions</a>
                            </div>
                        </div>
                    </li>
                    <li><a href="http://localhost/examinationsystem/admin/Result.php" id="link">Result</a></li>
                    <li><a href="http://localhost/ExaminationSystem/admin/notice.php" class="notice" id="link">Notice</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" id="profile-nav">
                    <li>
                        <div class="dropdown">
                            <button href="#" id="link-account" data-toggle="dropdown">
                                <?php echo  $_SESSION['username']?> <span class="material-icons md-38">account_circle</span> 
                                <!--<img  id="account-img" src="http://localhost/ExaminationSystem/images/home.jpg" />-->
                            </button>  
                            <div class="dropdown-menu" id="account-menu">
                                <?php 
                                include '../admin/connect.php';
                                $username = $_SESSION['username']; 
                                $sql = "select * from examiner where username = '$username'";
                                $result = mysqli_query($con,$sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo '<h4>'.$row['fullname'].'</h4>';
                                    echo '<h4>'.$row['email'].'</h4>';
                                }
                                ?>
                                <a href="http://localhost/ExaminationSystem/admin/Profile.php" class="btn btn-info" id="editProfile-btn">Edit Profile</a><br>
                                <a onclick="logout()" class="btn btn-primary" id="profile-btn">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
        </div>
    </nav> 
      <div class="container-fluid" id="content">
    </div> 
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
        // initial
        $('#content').load('http://localhost/ExaminationSystem/admin/AdminHome.php/');
        // handle menu clicks
        $('nav#menu div#container ul#profile-nav li a#editProfile-btn').click(function(){
            var page = $(this).attr('href');
            $('#content').load(page);
            return false;
            });
        $('nav#menu div#container ul#nav-link li a').click(function(){
            var page = $(this).attr('href');
            $('#content').load(page);
            return false;
        });
      
    });
    </script>
       <!-- jquery-->
       <script type="text/javascript ">
        $(document).ready(function(){
            $("#link-account").click(function(){
                $("#account-menu").fadeToggle("50")
            });
        });
        $(document).ready(function(){
            $("#link-btn").click(function(){
                $("#exam-menu").fadeToggle("50")
            });
        });
        function logout(){
            window.location.replace("http://localhost/ExaminationSystem/admin/Logout.php");
        }
    </script>
   </body> 
</html>
