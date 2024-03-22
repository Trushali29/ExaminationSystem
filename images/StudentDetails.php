
<?php 
 require_once '../functions/config.php';
 $sql = "SELECT * FROM student";
 $query = mysqli_query($conn,$sql);
$countRows = mysqli_num_rows($query);
 if(isset($_POST['search']['value'])){
     $sql .= "WHERE fullname LIKE '%".$_POST['search']['value']."%' ";
     $sql .= " OR  email LIKE '%".$_POST['search']['value']."%' ";
     $sql .= " OR password LIKE '%".$_POST['search']['value']."%' ";
     $sql .= " OR  pursuing_year LIKE '%".$_POST['search']['value']."%' ";
     $sql .= " OR  class LIKE '%".$_POST['search']['value']."%' ";
 }

 if(isset($_POST["order"])){
     $column = $_POST['order'][0]['column'];
     $order =  $_POST['order'][0]['dir'];
     $sql .= "ORDER BY '".$column."' ".$order;

 }
 else{
     $sql .='ORDER BY id ASC';
 }
 if(isset($_POST['length']) != -1)
 {
     $start = isset($_POST['start']);
     $length = isset($_POST['length']);
     $sql .= " LIMIT ".$start.", ".$length;
 }

 $data = array();
 $result_query = mysqli_query($conn,$sql);
$filtered_rows = mysqli_num_rows($result_query);
 while($row = mysqli_fetch_assoc($result_query)){
     $sub_array = array();
     $sub_array[] = $row['id'];
     $sub_array[] = $row['fullname'];
     $sub_array[] = $row['email'];
     $sub_array[] = $row['password'];
     $sub_array[] = $row['pursuing_year'];
     $sub_array[] = $row['class'];
     $sub_array[] = '<a href="javascript:void()" class="btn btn-primary">Edit</a> &nbps; &nbsp; <a href="javascript:void()" class="btn btn-danger">Delete</a>';
     $data[] = $sub_array;
 }
$output = array(
    'data' => $data,
     'draw' => intval(isset($_POST['draw'])),
     'recordsTotal' => $countRows,
     'recordsFiltered' =>$filtered_rows,
);
echo json_encode($output);
 ?>