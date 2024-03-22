<?php 
error_reporting (E_ALL ^ E_NOTICE);
include('connect.php');
$id = $_POST['id'];
$sql = "SELECT * FROM questions WHERE id='$id'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
?>