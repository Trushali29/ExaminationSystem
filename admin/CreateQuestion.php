<?php 
error_reporting (E_ALL ^ E_NOTICE);
include 'connect.php';
$subject = $_POST['subject'];
$class = $_POST['Class'];
$pursuing_year = $_POST['Pursuing_year'];
$question = $_POST['question'];
$option1 = $_POST['option1'];
$option2 = $_POST['option2'];
$option3 = $_POST['option3'];
$option4 = $_POST['option4'];
$correct_option = $_POST['correct_option'];

$sql = "INSERT INTO questions(subject,class,pursuing_year,question,option1,option2,option3,option4,correct_option) VALUES ('$subject','$class','$pursuing_year','$question','$option1','$option2','$option3','$option4','$correct_option')";

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