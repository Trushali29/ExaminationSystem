<?php
error_reporting (E_ALL ^ E_NOTICE);
include 'connect.php';
include '../functions/validate_data.php';
$id = $_POST['id'];
$fullname = test_input($_POST['fullname']);
$username = test_input($_POST['username']);
$email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
$password = test_input($_POST['changed_password']);
$hashed_password = password_hash($password,PASSWORD_DEFAULT);
if(empty($password)){
    $sql = "UPDATE examiner SET fullname = '$fullname', email = '$email', username = '$username' WHERE id='$id'";
    $query = mysqli_query($con,$sql);
    if($query == true){
        echo 'Updated successfully';
    }
}
else{
    $sql = "UPDATE examiner SET fullname = '$fullname', email = '$email', username = '$username', password='$hashed_password' WHERE id='$id'";
    $query = mysqli_query($con,$sql);
    if($query == true){
        echo 'Updated successfully';
    }
}

?>