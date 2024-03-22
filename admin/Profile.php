<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="stylesheet" text="style/css" href="../css/profile.css">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
       <style>
         <?php include '../css/profile.css'; ?>
       </style>
       
   </head>
   <body>
         <!-- Creating a registration card -->
         <div class="container"  id="card">
            <!--<p id="logo">Registration</p> -->
            <!-- To prevent xss attacks see action attr -->
            <form id="EditProfileForm" action="javascript:void(0);" method="post">
            <?php 
                    session_start();
                    include '../admin/connect.php';
                    $username = $_SESSION['username'];
                    $id = $_SESSION['id'];
                    $fullname = $email = "";
                    $sql = "SELECT * from examiner WHERE username = '$username'";
                    $result = mysqli_query($con,$sql);
                    while($row = mysqli_fetch_assoc($result)){
                        $fullname = $row['fullname'];
                        $email = $row['email'];
                    }
                ?> 
                <!--<div class="form-group"  id="center">
                    <img  id="image" src="http://localhost/ExaminationSystem/images/home.jpg" />
                    <a id="edit-link" href="http://localhost/ExaminationSystem/images/home.jpg"><span class="material-icons md-21">edit</span></a> 
                </div> &nbsp; &nbsp;-->
                <input type="hidden" id="Edit_id" name="id" value="<?php echo $id;?>"/>
                <div class="form-group">
                    <label id="label" for="fullname">Full Name</label>
                    <input type="text" class="form-control" name="fullname" id="Edit_Fullname" value="<?php echo $fullname; ?>" placeholder="Full Name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label id="label" for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" id="Edit_Email" placeholder="Email" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label id="label" for="username">Username</label>
                    <input type="text" class="form-control" value="<?php echo $username; ?>"  name="username" id="Edit_Username" placeholder="User name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label id="label" for="password">Change password</label><br>
                    <input type="password" name="password" id="Edit_Password" placeholder="Password of 8 characters" autocomplete="off">  
                    <i class="far fa-eye" id="togglePassword" style="margin-left: -40px; cursor: pointer;"></i>
               </div>
               <div class="form-group" id="center">
                   <button type="submit" class="btn btn-success" id="Savebtn" ><span class="material-icons md-20">save_as</span> Save</button> &nbsp;&nbsp;
                   <a  href="http://localhost/ExaminationSystem/admin/AdminMain.php" class="btn btn-primary" id="btn-cancel">Cancel</a>
               </div>
            </form>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   </body> 
   <!-- Eye password -->
   <script type="text/javascript">
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#Edit_Password');
        
        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });

        $(document).on('submit','#EditProfileForm',function(){
            var id = $('#Edit_id').val();
            var fullname = $('#Edit_Fullname').val();
            var email = $('#Edit_Email').val();
            var username = $('#Edit_Username').val();
            var changed_password = $('#Edit_Password').val();
            $.ajax({
                url : 'UpdateProfile.php',
                data:{id:id,fullname:fullname,email:email,username:username,changed_password:changed_password},
                type:'post',
                success:function(data,status){
                    if(status == 'success'){
                        alert('Records Updated Successfully');
                    }
                    else{
                        alert('Records Update Unsuccessful');
                    }
                }
            });
        });  
   </script>
</html>
