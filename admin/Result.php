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
        <?php include '../css/result.css';
        ?>
    </style>
</head>
<body>
<div class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading"  id="heading">
                <a id="back"  href="http://localhost/ExaminationSystem/admin/AdminMain.php" data-toggle="tooltip" data-placement="top" title="back"><span class="material-icons md-30">arrow_back</span></a>
                <!--<a id="download" href="#" data-toggle="modal" data-target="#downloadModal" ><span data-toggle="tooltip" data-placement="top" title="download" class="material-icons md-29">file_download</span></a> -->
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="ResultTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Student Name</th>
                            <th>Pursuing_year</th>
                            <th>class</th>
                            <th>Subject</th>
                            <th>Total Question</th>
                            <th>Total Marks</th>
                            <th>Negative Marking</th>
                            <th>Marks Obtained</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
            $('#ResultTable').DataTable({
                'serverSide':true,
                'processing':true,
                'paging':true,
                'order':[],
                'ajax':{
                    'url':'ResultDetails.php',
                    'type':'post',
                },
                'fnCreatedRow':function(nRow,aData,iDataIndex){
                    $(nRow).attr('id',aData[0]);
                },
                'columnDefs':[{
                    'target':[0,10],
                    'orderable':false,
                }]
             });
        });

        /* Publish Result */
        $(document).on('click','.PublishResult',function(event){
            var currentRow = $(this).closest('tr');
            var id = currentRow.find('td:eq(0)').text();
            var name = currentRow.find('td:eq(1)').text();
            var pursuing_year = currentRow.find('td:eq(2)').text();
            var Class = currentRow.find('td:eq(3)').text();
            var subject = currentRow.find('td:eq(4)').text();
            var tot_questions = currentRow.find('td:eq(5)').text();
            var tot_marks = currentRow.find('td:eq(6)').text();
            var negative_mark = currentRow.find('td:eq(7)').text();
            var marks_obtained = currentRow.find('td:eq(8)').text();
            var ResultStatus = 'publish';
            if(confirm('Are you sure you want to publish the result?')){
                $.ajax({
                    url:'PublishResult.php',
                    data:{id:id,ResultStatus:ResultStatus},
                    type:'post',
                    success:function(data){
                        var json = JSON.parse(data);
                        var status = json.status;
                        if(status == 'success'){
                            table = $('#ResultTable').DataTable();
                            var button= '<a href="#" data-id="'+id+'" class="DeleteResult" data-toggle="tooltip" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>&nbsp;&nbsp;<a href="#" data-id="'+id+'" class="PublishResult" data-toggle="tooltip" data-placement="top" title="publish"><span id="publish" class="material-icons md-20">publish</span></a>';
                            var row = table.row("[id='"+id+"']");
                            row.row("[id='"+id+"']").data([id,name,pursuing_year,Class,subject,tot_questions,tot_marks,negative_mark,marks_obtained,ResultStatus,button]);
                            alert('Result published');
                        }
                        else{
                            alert('failed');
                        }
                    },
                });
            }
          });

          /* Delete Result */
        $(document).on('click','.DeleteResult',function(event){
            var currentRow = $(this).closest('tr');
            var id = currentRow.find('td:eq(0)').text();
            if(confirm('Are you sure you want to delete this result ?')){
                $.ajax({
                    url:'DeleteResult.php',
                    data:{id:id},
                    type:'post',
                    success:function(data){
                        var json = JSON.parse(data);
                        var status = json.status;
                        if(status == 'success'){
                            $('#' + id).closest('tr').remove();
                        }
                        else{
                            alert('failed');
                        }
                    },
                });
            }
          });

</script>
<!--  create a download modal-->
<div class="modal fade" id="downloadModal" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>RESULT</strong></h4>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
            <div class="modal-body">
            <div class="form-group">
                <label id="label" for="subject">Subject</label>
                    <select class="form-control" name="subject" id="subject" autocomplete="off">
                        <option value=""></option>
                        <option>Internet Of Things</option>
                        <option>Advanced Java</option>
                        <option>Computer Networks</option>
                        <option>Python Programming</option>
                    </select>
            </div>
            <div class="form-group">
                <label id="label" for="pursuing_year">Pursuing year</label>
                <input type="text" class="form-control" name="pursuing_year" id="pursuing_year" autocomplete="off" />
            </div>
            <div class="form-group">
                <label id="label" for="class">Class</label>
                <input type="text" class="form-control" name="class" id="class" autocomplete="off" />
            </div>     
            </div>
            <div class="modal-footer">
                    <div class="form-group" id="center">
                        <button type="submit" class="btn btn-success" id="btn" > Download </button> &nbsp;&nbsp;
                        <a  href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
