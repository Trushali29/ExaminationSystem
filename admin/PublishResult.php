<?php 
error_reporting (E_ALL ^ E_NOTICE);
include ('connect.php');
$id = $_POST['id'];
$ResultStatus = $_POST['ResultStatus'];
$sql = "UPDATE result SET status ='$ResultStatus' WHERE id ='$id'";
$query = mysqli_query($con,$sql);
if($query == true){
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