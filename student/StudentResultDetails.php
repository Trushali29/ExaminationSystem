<?php
session_start();
include('../admin/connect.php');
error_reporting (E_ALL ^ E_NOTICE);
/* GETTING STUDENT DETAILS */
$student_name = $_SESSION['fullname'];
$student_sql = "SELECT * FROM student WHERE fullname='$student_name'";
$student_result = mysqli_query($con,$student_sql);
while($row = mysqli_fetch_assoc($student_result)){
    $student_py = $row['pursuing_year'];
    $student_class = $row['class'];
}
/* NOW SHOW RESULT BASED ON STUDENT INFORMAION */
$exam_sql = "SELECT * FROM result WHERE status = 'publish' AND student_name = '$student_name' AND pursuing_year = '$student_py' AND class = '$student_class'";
$query = mysqli_query($con,$exam_sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['order'])){
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $exam_sql .= " ORDER BY '".$column."' ".$order;
}
else{
    $exam_sql .= " ORDER BY id DESC";
}

if($_POST['length'] != -1){
    $start = $_POST['start'];
    $length = $_POST['length'];
    $exam_sql .= " LIMIT ".$start.", ".$length;
} 
$data = array();
$run_query = mysqli_query($con,$exam_sql);
$filtered_rows = mysqli_num_rows($run_query);
while($row = mysqli_fetch_assoc($run_query)){
    $subarray = array();
    $subarray[] = $row['id'];
    $subarray[] = $row['subject'];
    $subarray[] = $row['tot_questions'];
    $subarray[] = $row['tot_marks'];
    $subarray[] = $row['negative_mark'];
    $subarray[] = $row['marks_obtained'];
    $data[] = $subarray;
}
$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output,JSON_PRETTY_PRINT);

?>