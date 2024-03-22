<?php
    session_start();
    $fullname = $_SESSION['fullname']; 
    include '../admin/connect.php';
    $sql = "select * from student where fullname = '$fullname'";
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $student_py = $row['pursuing_year'];
        $student_class = $row['class'];
    }
?>
<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <style>
            <?php include '../css/StudentMain.css'; ?>
        </style>
   </head>
   <body>
        <div class="panel panel-default">
            <div class="panel-heading" id="heading">
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="StudentExamTable" class="table" >
                        <thead>
                            <tr>
                            <th>Id</th>
                            <th>Subject</th>
                            <th>Total question</th>
                            <th>Total marks</th>
                            <th>Negative marking</th>
                            <th>Time limit (in minutes)</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> 
    <script>
        $(document).ready(function(){
            $('#StudentExamTable').DataTable({
                'serverSide':true,
                'processing':true,
                'paging':true,
                'order':[],
                'ajax':{
                    'url':'StudentExamDetails.php',
                    'type':'post',
                },
                'fnCreatedRow':function(nRow,aData,iDataIndex){
                    $(nRow).attr('id',aData[0]);
                },
                'columnDefs':[{
                    'target':[0,6],
                    'orderable':false,
                }]
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click','.ExamAction',function(event){
            var student_class = "<?php echo $student_class?>";
            var student_py = "<?php echo $student_py?>";
            var currentRow = $(this).closest('tr');
            var exam_id = currentRow.find('td:eq(0)').text();
            var exam_subject = currentRow.find('td:eq(1)').text();
            console.log();
            $.ajax({
                url:'Student_Exam_Process_Details.php',
                data:{exam_id:exam_id,exam_subject:exam_subject,student_class:student_class,student_py:student_py},
                type:'post',
                success:function(data){
                    $('#NoticeModal').modal('toggle');
                    const myTimeout = setTimeout(exam_location, 4000);
                    function exam_location() {
                        location.assign('http://localhost/ExaminationSystem/student/Student_Exam_Action.php');
                    } 
                }
            });   
          });
    </script>
    <script>
        function disableBack() { window.history.forward(); }
            setTimeout("disableBack()", 0);
            window.onunload = function () { null };
    </script>
    <div class="modal fade" id="NoticeModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-body">
                    <img id="process_image" height="90" weight="90" src="../images//icons8-spinner.gif">
                </div>
            </div>
        </div>
    </div>
 
   </body> 
</html>
