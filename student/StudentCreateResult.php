<?php
session_start();
error_reporting (E_ALL ^ E_NOTICE);
include '../admin/connect.php';
$student_name = $_POST['student_name'];
$exam_subject = $_POST['exam_subject'];
$correct_answers = $_POST['correct_answers'];
$student_Exam_answer = $_POST['radio_value'];
$student_sql = "SELECT * FROM student WHERE fullname = '$student_name'";
$student_result = mysqli_query($con,$student_sql);
while($row = mysqli_fetch_assoc($student_result)){
    $student_py = $row['pursuing_year'];
    $student_class = $row['class'];
}

$exam_sql = "SELECT * FROM exam_paper WHERE class = '$student_class' AND pursuing_year='$student_py' AND subject = '$exam_subject'";
$exam_sql_result = mysqli_query($con,$exam_sql);
while($row = mysqli_fetch_assoc($exam_sql_result)){
    $tot_questions = $row['tot_questions'];
    echo $row['tot_questions'];
    $tot_marks = $row['tot_marks'];
    echo $row['tot_marks'];
    $negative_mark = $row['negative_mark'];
    echo $row['negative_mark'];
}
/* CALCULATE MARKS OBTAINED*/
$student_marks_obtained = 0;
for($i = 0; $i < $tot_questions;$i ++){
    if($student_Exam_answer[$i] != 'none'){
        if($student_Exam_answer[$i] == $correct_answers[$i]){
            $student_marks_obtained = $student_marks_obtained + 1;
        }
        else{
            $student_marks_obtained = $student_marks_obtained - $negative_mark;
        }
    }
}
/* IF THE MARKS OBTAINED IS NEGATIVE VALUE THEN CONVERT IT TO ZERO */
if($student_marks_obtained < 0){
    $student_marks_obtained = 0;
}

/* STORE ALL THE DATA IN THE RESULT TABLE */
$status = 'unpublish';
$sql = "INSERT INTO result(student_name,pursuing_year,class,subject,tot_questions, tot_marks, negative_mark,status,marks_obtained) VALUES ('$student_name','$student_py','$student_class','$exam_subject','$tot_questions','$tot_marks','$negative_mark','$status','$student_marks_obtained')";

$query = mysqli_query($con,$sql);
if($query==true){
    $data = array(
        'status' => 'success'
    );
    echo json_encode($data,JSON_PRETTY_PRINT);
}
else{
    $data = array(
        'status' => 'failed',
    );
    echo json_encode($data,JSON_PRETTY_PRINT);
}
/* CALL THE FUNCTION TO CHANGE THE STATUS OF THE EXAM PAPER*/
include '../admin/UpdateStatusExamPaper.php';
UpdateStatusExamPaper();
?>