<?php
session_start();
error_reporting (E_ALL ^ E_NOTICE);
$fullname = $_SESSION['fullname']; 
include '../admin/connect.php';
$sql = "select * from student where fullname = '$fullname'";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_assoc($result)){
    $student_py = $row['pursuing_year'];
    $student_class = $row['class'];
}
$sql = "SELECT * FROM exam_paper WHERE status='Created' AND pursuing_year = '$student_py' AND class = '$student_class' ";
$query = mysqli_query($con,$sql);
$count_all_rows = mysqli_num_rows($query);
if(isset($_POST['order'])){
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY '".$column."' ".$order;
}
else{
    $sql .= " ORDER BY id DESC";
}

if($_POST['length'] != -1){
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT ".$start.", ".$length;
} 

$data = array();
$run_query = mysqli_query($con,$sql);
$filtered_rows = mysqli_num_rows($run_query);
while($row = mysqli_fetch_assoc($run_query)){
    $subarray = array();
    $subarray[] = $row['id'];
    $subarray[] = $row['subject'];
    $subarray[] = $row['tot_questions'];
    $subarray[] = $row['tot_marks'];
    $subarray[] = $row['negative_mark'];
    $subarray[] = $row['time_limit'];
    $subarray[] = '<a href="#" data-id="'.$row['id'].'" class="btn ExamAction" id="start-btn">Start Exam</a>&nbsp;&nbsp;';
    $data[] = $subarray;
}
$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
?>