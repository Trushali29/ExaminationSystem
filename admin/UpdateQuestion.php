<?php 
error_reporting (E_ALL ^ E_NOTICE);
include ('connect.php');
$id = $_POST['id'];
$subject = $_POST['subject'];
$class = $_POST['Class'];
$pursuing_year = $_POST['pursuing_year'];
$question = $_POST['question'];
$option1 = $_POST['option1'];
$option2 = $_POST['option2'];
$option3 = $_POST['option3'];
$option4 = $_POST['option4'];
$correct_option = $_POST['correct_option'];
$sql = "UPDATE questions SET subject='$subject', 
                            class='$class', 
                            pursuing_year='$pursuing_year', 
                            question='$question', 
                            option1='$option1', 
                            option2='$option2', 
                            option3='$option3', 
                            option4='$option4',	
                            correct_option ='$correct_option' WHERE id='$id'";
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