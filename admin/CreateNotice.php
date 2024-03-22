<?php 
error_reporting (E_ALL ^ E_NOTICE);
include 'connect.php';
$description = $_POST['description'];
$status = $_POST['Status'];
$sql = "INSERT INTO notice (description,status) values ('$description','$status')";
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