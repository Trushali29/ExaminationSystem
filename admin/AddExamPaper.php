<?php 
error_reporting (E_ALL ^ E_NOTICE);
include 'connect.php';
$subject = $_POST['Subject'];
$tot_questions = $_POST['Total_questions'];
$tot_marks = $_POST['Total_marks'];
$negative = $_POST['Negative'];
$time_limit = $_POST['Time_limit'];
$class = $_POST['Class'];
$pursuing_year = $_POST['Pursuing_year'];
$status = $_POST['Status'];

$sql = "INSERT INTO exam_paper(subject,tot_questions,tot_marks,negative_mark,time_limit,class,pursuing_year,status) VALUES ('$subject','$tot_questions','$tot_marks','$negative','$time_limit','$class','$pursuing_year','$status')";

$query = mysqli_query($con,$sql);
if($query==true){
    $data = array(
        'status' => 'success'
    );
    echo json_encode($data);
}
else{
    $data = array(
        'status'=> 'failed',
    );
    echo json_encode($data);
}
?>