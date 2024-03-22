<?php 
error_reporting (E_ALL ^ E_NOTICE);
include ('connect.php');
$id = $_POST['id'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$pursuing_year = $_POST['pursuing_year'];
$class = $_POST['Class'];
$sql = "UPDATE student SET fullname = '$fullname', email = '$email' , password = '$password', pursuing_year = '$pursuing_year', class = '$class' WHERE id='$id'";
$query = mysqli_query($con,$sql);
if($query==true){
    $data = array(
        'status' => 'success',
    );
    echo json_encode($data);
}
else{
    $data = array(
        'status' => 'failed',
    );
    echo json_encode($data);
}
?>