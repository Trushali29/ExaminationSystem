<?php
error_reporting (E_ALL ^ E_NOTICE);
include('connect.php');
include('../functions/validate_data.php');
$sql = "SELECT * FROM exam_paper";
$query = mysqli_query($con,$sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['search']['value'])){
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE subject like '%".$search_value."%' ";
    $sql .= " OR tot_questions like '%".$search_value."%' ";
    $sql .= " OR tot_marks like '%".$search_value."%' ";
    $sql .= " OR negative_mark like '%".$search_value."%' ";
    $sql .= " OR time_limit like '%".$search_value."%' ";
    $sql .= " OR class like '%".$search_value."%' ";
    $sql .= " OR pursuing_year like '%".$search_value."%' ";
    $sql .= " OR status like '%".$search_value."%' ";
}

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
    $subarray[] = $row['class'];
    $subarray[] = $row['pursuing_year'];
    $subarray[] = $row['status'];
    $subarray[] = '<a href="#" data-id="'.$row['id'].'" class="EditExamPaper" data-toggle="tooltip" data-placement="top" title="edit"><span id="edit" class="material-icons md-20">edit</span></a>&nbsp;&nbsp;<a href="#" data-id="'.$row['id'].'" class="DeleteExamPaper" data-toggle="tooltip" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>';
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