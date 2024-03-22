<?php
include('connect.php');
$sql = "SELECT * FROM notice";
$query = mysqli_query($con,$sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['search']['value'])){
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE description like '%".$search_value."%' ";
    $sql .= " OR status like '%".$search_value."%' ";
}
/* keeps the data in order */
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
    $subarray[] = $row['description'];
    $subarray[] = $row['status'];
    $subarray[] = '<a href="#" data-id="'.$row['id'].'" class="DeleteNotice" data-toggle="tooltip" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>&nbsp;&nbsp;
    <a href="#" data-id="'.$row['id'].'" class="PublishNotice" data-toggle="tooltip" data-placement="top" title="publish"><span id="publish" class="material-icons md-20">publish</span></a>';
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