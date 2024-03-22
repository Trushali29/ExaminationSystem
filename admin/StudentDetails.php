<?php
include('connect.php');
error_reporting (E_ALL ^ E_NOTICE);
$sql = "SELECT * FROM student";
$query = mysqli_query($con,$sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['search']['value'])){
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE fullname like '%".$search_value."%' ";
    $sql .= " OR email like '%".$search_value."%' ";
    $sql .= " OR password like '%".$search_value."%' ";
    $sql .= " OR Pursuing_year like '%".$search_value."%' ";
    $sql .= " OR class like '%".$search_value."%' ";
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
    $subarray[] = $row['fullname'];
    $subarray[] = $row['email'];
    $subarray[] = $row['password'];
    $subarray[] = $row['pursuing_year'];
    $subarray[] = $row['class'];
    $subarray[] = '<a href="#" data-id="'.$row['id'].'" class="EditStudent" data-toggle="tooltip" data-placement="top" title="edit"><span id="edit" class="material-icons md-20">edit</span></a>&nbsp;&nbsp;<a href="#" data-id="'.$row['id'].'" class="DeleteStudent" data-toggle="tooltip" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>';
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