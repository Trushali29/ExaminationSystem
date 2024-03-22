<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
         <?php include '../css/style.css';  ?>
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
        <div class="container">
            <div class="panel-group">
                <div class="panel panel-primary" id="notice-panel">
                    <div class="panel-heading"> <strong>NOTICE</strong></div>
                    <div class="panel-body">
                    <?php 
                        include 'connect.php';
                        $sql = "SELECT description FROM notice WHERE status='publish'";
                        $query = mysqli_query($con,$sql);
                        while($text = mysqli_fetch_assoc($query)){
                           echo '<marquee behavior="scroll" direction="left" scrollamount="3">'.$text['description'].' </marquee>';
                        }
                    ?>
                    <!--<marquee behavior='scroll'direction='left'scrollamount='6'><p>abcfaf</p></marquee> -->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
