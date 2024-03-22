<?php
 require_once '../functions/config.php';
 require_once '../functions/validate_data.php';

  //This script will handle login
  session_start();

  //check if user is already logged in 
  if(isset($_SESSION['fullname'])){
      header("location:http://localhost/ExaminationSystem/student/StudentMain.php");
      exit;
  }
  $fullname = $password = "";
  $error = "";

  //check if post request is made or not
  if($_SERVER['REQUEST_METHOD']=="POST"){
      if(empty(test_input($_POST['fullname']))|| empty(test_input($_POST['password']))){
          $error = "Invalid username or password";
      }
      else{
          $fullname = test_input($_POST['fullname']);
          $password = test_input($_POST['password']);
      }

      //If no error is present then check if user data is matching with database details
      if(empty($error)){
          $sql = "SELECT id, fullname, password FROM student WHERE fullname = ? ";
          $stmt = mysqli_prepare($conn,$sql);
          // the student fullname will be it's user name
          mysqli_stmt_bind_param($stmt,"s",$param_fullname);
          $param_fullname = $fullname;
          //Try to exectue the prepare statement
          if(mysqli_stmt_execute($stmt)){
              mysqli_stmt_store_result($stmt);
              // username is present inside the database 
              if(mysqli_stmt_num_rows($stmt) == 1)
              {
                  // bind those results with the parameters below from database
                  mysqli_stmt_bind_result($stmt,$id,$fullname,$confirm_password);
                  if(mysqli_stmt_fetch($stmt)){
                      if($password === $confirm_password){
                          // password is correct
                          session_start();
                          $_SESSION['fullname'] = $fullname;
                          $_SESSION['student_id'] = $id;
                          $_SESSION['loggedin'] = true;

                          //redirect user to main page
                          header("location:http://localhost/ExaminationSystem/student/StudentMain.php");
                      }
                  }
              }
              else
              {
                  $error= 'Enter valid username or password';
              }
          }    
      }
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
         <?php include '../css/login.css'; 
               include '../css/style.css'; ?>
        </style>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#login").click(function(){
                    $("#login-menu").fadeToggle("slow")
                });
                $('#password').focusin(function(){
                    $('#togglePassword').css('visibility','visible')
                });
                $('#fullname').focusin(function(){
                    $('#togglePassword').css('visibility','hidden')
                });
            });
        </script>
    </head>
    <body>   
        <!--Navigation bar -->
        <nav class="navbar"  id="menu">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" id="burger" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a id="logo" class="navbar-brand" href="http://localhost/ExaminationSystem/admin/home.php/">Examination System</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <div class="dropdown">
                                <button type="button" id="login" data-toggle="dropdown">Login</button>
                                <ul class="dropdown-menu" id="login-menu"> 
                                    <li><a id="login-link" href="http://localhost/ExaminationSystem/admin/StudentLogin.php/">Student Login</a></li>
                                    <li><a id="login-link" href="http://localhost/ExaminationSystem/admin/AdminLogin.php/">Admin Login</a></li>
                                </ul>   
                            </div>
                        </li>
                        <li>
                            <a id="signup" href="http://localhost/ExaminationSystem/admin/Register.php/"><span class="glyphicon glyphicon-user"></span> Sign up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
  

        <!-- Creating a Login card -->
        <div class="container"  id="Student_card">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                <div class="form-group">
                    <h3 id="logo">Student Login</h3>
                </div>
                <hr>
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="username" autocomplete="off" required/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="password" autocomplete="off" required/>
                    <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
               </div>
               <div><span class="error"><?php echo $error;?></span></div>
               <div class="form-group" id="login-btn">
               <button type="submit" class="btn btn-primary" id="btn" >Login</button>
               </div>
            </form>
        </div>
        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            
            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
      </script>
    </body>
</html>