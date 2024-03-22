<?php 
error_reporting (E_ALL ^ E_NOTICE);
include 'connect.php';
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$pursuing_year = $_POST['pursuing_year'];
$class = $_POST['Class'];

$sql = "INSERT INTO student (fullname,email,password,pursuing_year,class) VALUES ('$fullname','$email','$password','$pursuing_year','$class')";

$query = mysqli_query($con,$sql);
if($query==true){
    $data = array(
        'status' => 'success'
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