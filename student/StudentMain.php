<?php
session_start();

  if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
      header("location: http://localhost/ExaminationSystem/student/StudentMain.php ");
  }
  
?>
<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <style>
            <?php include '../css/StudentMain.css'; ?>
        </style>
   </head>
   <body>
   <nav class="navbar" id="menu">
        <div class="container-fluid" id="container">
                <ul class="nav navbar-nav" id="nav-link">   
                    <li><a href="http://localhost/ExaminationSystem/student/StudentExamPaper.php" id="link">Exam paper</a></li>
                    <li><a href="http://localhost/ExaminationSystem/student/StudentResult.php" id="link1">Result</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <div class="dropdown">
                            <button href="#" id="link-account" data-toggle="dropdown"> 
                                <?php echo $_SESSION['fullname']; ?>  <span class="material-icons md-38">account_circle</span>
                           </button>  
                            <div class="dropdown-menu" id="account-menu">
                                <?php 
                                include '../admin/connect.php';
                                $fullname = $_SESSION['fullname']; 
                                $sql = "select * from student where fullname = '$fullname'";
                                $result = mysqli_query($con,$sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo '<h4>'.$row['email'].'</h4>';
                                    echo '<h4>'.$row['pursuing_year'].'</h4>';
                                    echo '<h4>'.$row['class'].'</h4>';
                                }
                                ?>
                                <a onclick="logout()" href="#" class="btn btn-default" id="logout-link">Logout</a> 
                            </div>
                        </div>
                    </li>
                </ul>
        </div>
    </nav>
    <div  id="content">
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
                $("#link-account").click(function(){
                    $("#account-menu").fadeToggle("50")
                });
            });
    </script>
     <script>
        $(document).ready(function(){
            // initial 
            $('#content').load('http://localhost/ExaminationSystem/student/StudentExamPaper.php');
            // handle menu clicks
            $('nav#menu div#container ul#nav-link li a').click(function(){
                var page = $(this).attr('href');
                $('#content').load(page);
                return false;
            });
        });
        function logout(){
            window.location.href = "http://localhost/ExaminationSystem/student/StudentLogout.php/";
        }
    </script>
   </body> 
</html>
