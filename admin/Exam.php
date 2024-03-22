<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        <?php include '../css/exam.css';
        ?>
    </style>
</head>
<body>
    <div class="panel-group" id="panelgroup">
        <div class="panel panel-default">
            <div class="panel-heading" id="heading">
                <a id="back"  href="http://localhost/ExaminationSystem/admin/AdminMain.php" data-toggle="tooltip" data-placement="top" title="back"><span class="material-icons md-30">arrow_back</span></a>
                <a id="add" href="#" data-toggle="modal" data-target="#CreateExamPaperModal"><span  data-toggle="tooltip" data-placement="top" title="add" class="material-icons md-35">add</span></a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="ExamTable" class="table">
                        <thead>
                            <th>Id</th>
                            <th>Subject</th>
                            <th>Total question</th>
                            <th>Total marks</th>
                            <th>Negative marking</th>
                            <th>Time limit (in minutes)</th>
                            <th>Class</th>
                            <th>Pursuing year</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                        </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <!--<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        /* CALL THE UPDATE FUNCTION AT ADD OF PAPER*/
        function php_function(){
            <?php 
                include '../admin/UpdateStatusExamPaper.php';
                UpdateStatusExamPaper();
            ?>
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#ExamTable').DataTable({
                'serverSide':true,
                'processing':true,
                'paging':true,
                'order':[],
                'ajax':{
                    'url':'ExamDetails.php',
                    'type':'post',
                },
                'fnCreatedRow':function(nRow,aData,iDataIndex){
                    $(nRow).attr('id',aData[0]);
                },
                'columnDefs':[{
                    'target':[0,9],
                    'orderable':false,
                }],
            });
            
        });
        php_function();
    </script>
    <script type="text/javascript">
        $(document).on('submit','#CreateExamPaperForm',function(event){
            var Subject = $('#subject').val();
            var Total_questions = $('#tot_questions').val();
            var Total_marks = $('#tot_marks').val();
            var Negative = $('#negative_mark').val();
            var Time_limit = $('#time_limit').val();
            var Class = $('#class').val();
            var Pursuing_year = $('#pursuing_year').val();
            var Status = 'Pending';
            
            if(Subject !='' && Total_questions !='' && Total_marks != '' && Negative !='' && Time_limit !='' && Class !='' && Pursuing_year !=''){
                $.ajax({
                    url:'AddExamPaper.php',
                    data:{ Subject:Subject,Total_questions:Total_questions,Total_marks:Total_marks,Negative:Negative,Time_limit:Time_limit,Class:Class,Pursuing_year:Pursuing_year,Status:Status },
                    type:'post',
                    success:function(data){
                        var json = JSON.parse(data);
                        status = json.status;
                        if(status=='success'){
                            table = $('#ExamTable').DataTable();
                            table.draw();
                            $('#CreateExamPaperForm')[0].reset();
                            $('#CreateExamPaperModal').modal('hide');
                            alert('Exam Paper Created');
                        }
                    }
                });
            }
            else{
                alert("Please fill the required filled");
            }
        });

        $(document).on('click','.EditExamPaper',function(){
            var id = $(this).data('id');
            var trid = $(this).closest('tr').attr('id');
            $.ajax({
                url:'EditExamPaper.php',
                data:{id:id},
                type:'post',
                success:function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#trid').val(trid);
                    $('#Edit_subject').val(json.subject);
                    $('#Edit_tot_questions').val(json.tot_questions);
                    $('#Edit_tot_marks').val(json.tot_marks);
                    $('#Edit_negative_mark').val(json.negative_mark);
                    $('#Edit_time_limit').val(json.time_limit);
                    $('#Edit_class').val(json.class);
                    $('#Edit_pursuing_year').val(json.pursuing_year);
                    $('#Edit_status').val(json.status);
                    $('#EditExamPaperModal').modal('show');
                }
            });
        });
        $(document).on('submit','#EditExamPaperForm',function(event){
            var id = $('#id').val();
            var trid = $('#trid').val();
            var Subject = $('#Edit_subject').val();
            var Total_questions = $('#Edit_tot_questions').val();
            var Total_marks = $('#Edit_tot_marks').val();
            var Negative = $('#Edit_negative_mark').val();
            var Time_limit = $('#Edit_time_limit').val();
            var Class = $('#Edit_class').val();
            var Pursuing_year = $('#Edit_pursuing_year').val(); 
            $.ajax({
                url:'UpdateExamPaper.php',
                data:{id:id,Subject:Subject,Total_questions:Total_questions,Total_marks:Total_marks,Negative:Negative,Time_limit:Time_limit,Class:Class,Pursuing_year:Pursuing_year},
                type:'post',
                success:function(data){
                    var json = JSON.parse(data);
                    var status = json.status;
                    var Exam_Status = json.exam_status;
                    if(status=='success'){
                        table = $('#ExamTable').DataTable();
                        var button = '<a href="#" data-id="'+id+'" class="EditExamPaper" data-toggle="tooltip" data-placement="top" title="edit"><span id="edit" class="material-icons md-20">edit</span></a>&nbsp;&nbsp;<a href="#" data-id="'+id+'" class="DeleteExamPaper" data-toggle="tooltip" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>';
                        var row = table.row("[id='"+trid+"']");
                        row.row("[id='"+trid+"']").data([id,Subject,Total_questions,Total_marks,Negative,Time_limit,Class,Pursuing_year,Exam_Status,button]);
                        $('#EditExamPaperModal').modal('hide'); 
                    }
                    else{
                        alert('failed');
                    }
                },
            });
        });
        
         /* Delete Student */
         $(document).on('click','.DeleteExamPaper',function(event){
              var id = $(this).data('id');
              if(confirm('Are you sure want to delete this paper ?')){
                    $.ajax({
                    url:'DeleteExamPaper.php',
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
    <!-- add exam-paper modal -->
    <div class="modal fade" id="CreateExamPaperModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Create exam paper</strong></h4>
                </div>
                <form id="CreateExamPaperForm" method="post" action="javascript:void(0);">
                    <input type="hidden" id="id" name="id" value=""/>
                    <input type="hidden" id="trid" name="trid" value=""/>
                    <div class="modal-body">
                        <div class="form-group">
                            <label id="label" for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Advanced Java" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="tot_questions">Total question</label>
                            <input type="number" class="form-control" name="Tot-question" id="tot_questions"  autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="tot_marks">Total marks</label>
                            <input type="number" class="form-control" name="Tot-marks" id="tot_marks" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="negative_mark">Negative marks</label>
                            <input type="number" class="form-control"  name="negative" id="negative_mark"  placeholder="Eg: 0 or -1" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label id="label" for="time_limit">Time limit(in minutes)</label>
                            <input type="number" class="form-control"  name="timer" id="time_limit" min="1" max="60" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label id="label" for="class">Class</label>
                            <input type="text" class="form-control" name="class" id="class" placeholder="Eg: FY, SY, TY" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="pursuing_year">Pursuing year</label>
                            <input type="text" class="form-control" name="year" id="pursuing_year" placeholder="Eg: 2020-2021"autocomplete="off" />
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="form-group" id="center">
                                <button type="submit" class="btn btn-success" id="btn" >Create</button> &nbsp;&nbsp;
                                <a  href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  
    <!-- Edit modal -->
    <div class="modal fade" id="EditExamPaperModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog"> 
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>EDIT DETAILS</strong></h4>
                </div>
                <form id="EditExamPaperForm" action="javascript:void(0);" method="post"> 
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value=""/>
                        <input type="hidden" id="trid" name="trid" value=""/>
                        <div class="form-group">
                            <label id="label" for="Edit_subject">Subject</label>
                            <input type="text" class="form-control" name="Edit_subject" id="Edit_subject"  autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="Edit_tot_questions">Total question</label>
                            <input type="number" class="form-control" name="Edit_tot_questions" id="Edit_tot_questions"  autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="Edit_tot_marks">Total marks</label>
                            <input type="number" class="form-control" name="Edit_tot_marks" id="Edit_tot_marks" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="Edit_negative_mark">Negative marks</label>
                            <input type="number" class="form-control"  name="Edit_negative_mark" id="Edit_negative_mark"  autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label id="label" for="Edit_time_limit">Time limit</label>
                            <input type="number" class="form-control"  name="Edit_time_limit" id="Edit_time_limit" min="1" max="60" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label id="label" for="Edit_class">Class</label>
                            <input type="text" class="form-control" name="Edit_class" id="Edit_class" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="Edit_pursuing_year">Pursuing year</label>
                            <input type="text" class="form-control" name="Edit_pursuing_year" id="Edit_pursuing_year" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="Edit_status">Status</label>
                            <input type="text" style="background-color:transparent;" class="form-control" name="Edit_status" id="Edit_status" autocomplete="off" disabled />
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="form-group" id="center">
                                <button type="submit" class="btn btn-success" id="btn" >Edit</button> &nbsp;&nbsp;
                                <a  href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    
</body>
</html>

