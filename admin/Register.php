<?php 
   require_once '../functions/config.php';
   require_once '../functions/validate_data.php';

   $username = $password = $fullname = $email = "";
   $username_err = $password_err = $fullname_err = $email_err = "";

   if($_SERVER['REQUEST_METHOD'] == "POST"){

    // check if full name is empty
    if(empty($_POST["fullname"])){
        $fullname_err = "Full name is required";
    }
    //check fullname pattern
    elseif(!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["fullname"])))
    {
          $fullname_err = "Only letters and white space allowed";
    }
    else{
        
        // creating a mysql query prepared statement
        $sql = "SELECT id FROM Examiner WHERE fullname = ?";
        // prepare an sql statement for execution
        $stmt = mysqli_prepare($conn,$sql);
        //
        if($stmt){
            // bind the variable with statement only one string "s" 
            mysqli_stmt_bind_param($stmt,"s",$param_fullname);

            // set the value of param
            $param_fullname = test_input($_POST['fullname']);

            // try to execute the statement
            //execute  a prepare statment 
            if(mysqli_stmt_execute($stmt)){
                // Stores a result set in an internal buffer
                mysqli_stmt_store_result($stmt);
                // get the number of rows from result set and check if the given value 
                // is present or not if duplicate then provide error
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $fullname_err = "This full name is already present";
                }
                else{
                    $fullname = test_input($_POST["fullname"]);
                }
            }
            else{
                echo "something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }
    

    //  check email is empty or not
    if(empty($_POST["email"])){
        $email_err = "Email is required";
    }
    //check fullname pattern
    elseif(!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL))
    {
          $email_err = "Invalid email format";
    }
    else{
        
        // creating a mysql query prepared statement
        $sql = "SELECT id FROM Examiner WHERE email = ?";
        // prepare an sql statement for execution
        $stmt = mysqli_prepare($conn,$sql);
        //
        if($stmt){
            // bind the variable with statement only one string "s" 
            mysqli_stmt_bind_param($stmt,"s",$param_email);

            // set the value of param
            $param_email = test_input($_POST['email']);

            // try to execute the statement
            //execute  a prepare statment 
            if(mysqli_stmt_execute($stmt)){
                // Stores a result set in an internal buffer
                mysqli_stmt_store_result($stmt);
                // get the number of rows from result set and check if the given value 
                // is present or not if duplicate then provide error
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This Email is already present";
                }
                else{
                    $email = test_input($_POST["email"]);
                }
            }
            else{
                echo "something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }
   
    

    // check if username  is empty
    if(empty($_POST["username"])){
        $username_err = "Full name is required";
    }
    //check username pattern
    elseif(!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["username"])))
    {
          $username_err = "Only letters and white space allowed";
    }
    else{
        
        // creating a mysql query prepared statement
        $sql = "SELECT id FROM Examiner WHERE username = ?";
        // prepare an sql statement for execution
        $stmt = mysqli_prepare($conn,$sql);
        //
        if($stmt){
            // bind the variable with statement only one string "s" 
            mysqli_stmt_bind_param($stmt,"s",$param_username);

            // set the value of param
            $param_username = test_input($_POST['username']);

            // try to execute the statement
            //execute  a prepare statment 
            if(mysqli_stmt_execute($stmt)){
                // Stores a result set in an internal buffer
                mysqli_stmt_store_result($stmt);
                // get the number of rows from result set and check if the given value 
                // is present or not if duplicate then provide error
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This user name is already present";
                }
                else{
                    $username = test_input($_POST["username"]);
                }
            }
            else{
                echo "something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }
   

    
    // check if password  is empty
    if(empty($_POST['password'])){
        $password_err = "Password is required";
    }
    elseif(strlen(test_input($_POST['password'])) < 8 ){
        $password_err = "Password should be of 8 characters" ;
    }
    else{
        $password = test_input($_POST['password']);
    }
     
    // if no errors are there in any input field then go and insert values inside database
    if(empty($fullname_err) && empty($email_err) && empty($username_err) && empty($password_err)){

        $sql = "INSERT INTO Examiner (fullname, email, username, password) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt){
            
            mysqli_stmt_bind_param($stmt, "ssss", $param_fullname,$param_email,$param_username,$param_password);
            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_fullname = $fullname;
            $param_email = $email;
            
            // Try to execute the query
            if (mysqli_stmt_execute($stmt))
            {
                header("location: http://localhost/ExaminationSystem/admin/AdminLogin.php/");
            }
            else{
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);   

} 


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
         <?php include '../css/register.css';
               include '../css/style.css';?>
        </style>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#login").click(function(){
                    $("#login-menu").fadeToggle("slow")
                });
            });
        </script>
    </head>
    <body>
        <div class="bg">
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


        <!-- Creating a registration card -->
        <div class="container"  id="card">
            <!--<p id="logo">Registration</p> -->
            <!-- To prevent xss attacks see action attr -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                <div class="form-group">
                    <h3 id="logo">Admin Registration</h3>
                </div>
                <hr>
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" id="FullName" placeholder="Full Name" autocomplete="off" required/>
                    <span class="error"> <?php echo $fullname_err;?></span>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="Email" placeholder="Email" autocomplete="off" required/>
                    <span class="error"> <?php echo $email_err;?></span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="username" id="UserName" placeholder="User name" autocomplete="off" required/>
                    <span class="error"> <?php echo $username_err;?></span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control"  name="password" id="Password" placeholder="Password of 8 characters" autocomplete="off" required/>
                    <span class="error"><?php echo $password_err;?></span>
               </div>
               <div class="form-group" id="center">
               <button type="submit" class="btn btn-primary" id="btn"  >Sign up</button>
               </div>
               <div class="form-group" id="loginLink">
                   <p>Already have an account ? <span><a style="text-decoration:none" href="http://localhost/ExaminationSystem/admin/AdminLogin.php/"> Log in</a></span></p>
               </div>
            </form>
        </div>
        </div>
    </body>
</html>