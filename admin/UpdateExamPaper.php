<?php 
error_reporting (E_ALL ^ E_NOTICE);
include ('connect.php');
include '../admin/UpdateStatusExamPaper.php';
$id = $_POST['id'];
$subject = $_POST['Subject'];
$tot_questions = $_POST['Total_questions'];
$tot_marks = $_POST['Total_marks'];
$negative_marking = $_POST['Negative'];
$time_limit = $_POST['Time_limit'];
$pursuing_year = $_POST['Pursuing_year'];
$class = $_POST['Class'];
//$status = $_POST['Status'];
$sql = "UPDATE exam_paper SET subject='$subject', tot_questions='$tot_questions', tot_marks='$tot_marks', negative_mark='$negative_marking', time_limit='$time_limit', class='$class',pursuing_year='$pursuing_year'WHERE id='$id'";
$query = mysqli_query($con,$sql);
UpdateStatusExamPaper();
/* AFTER UPDATING THE DETAILS FETCH THE STATUS OF PAPER */
$status_sql = "SELECT status FROM exam_paper WHERE id='$id'";
$status_query = mysqli_query($con,$status_sql);
while($row = mysqli_fetch_assoc($status_query)){
    $status_val = $row['status'];
}
if(($query==true)){
    $data = array(
        'exam_status' => $status_val,
        'status' => 'success',
    );
    echo json_encode($data,JSON_PRETTY_PRINT);
}
else{
    $data = array(
        'exam_status' => $status_val,
        'status' => 'failed',
    );
    echo json_encode($data,JSON_PRETTY_PRINT);
}
?>