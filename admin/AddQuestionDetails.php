<?php
include('connect.php');
$sql = "SELECT * FROM  questions";
$query = mysqli_query($con,$sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['search']['value'])){
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE subject like '%".$search_value."%' ";
    $sql .= " OR class like '%".$search_value."%' ";
    $sql .= " OR pursuing_year like '%".$search_value."%' ";
    $sql .= " OR question like '%".$search_value."%' ";
    $sql .= " OR option1 like '%".$search_value."%' ";
    $sql .= " OR option2 like '%".$search_value."%' ";
    $sql .= " OR option3 like '%".$search_value."%' ";
    $sql .= " OR option4 like '%".$search_value."%' ";
    $sql .= " OR correct_option like '%".$search_value."%' ";

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
    $subarray[] = $row['class'];
    $subarray[] = $row['pursuing_year'];
    $subarray[] = $row['question'];
    $subarray[] = $row['option1'];
    $subarray[] = $row['option2'];
    $subarray[] = $row['option3'];
    $subarray[] = $row['option4'];
    $subarray[] = $row['correct_option'];
    $subarray[] = '<a href="#" data-id="'.$row['id'].'" class="EditQuestion" data-toggle="tooltip" data-placement="top" title="edit"><span class="material-icons md-20">edit</span></a>&nbsp;&nbsp;<a href="#" data-id="'.$row['id'].'" data-toggle="tooltip" class="DeleteQuestion" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>';
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