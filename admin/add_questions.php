<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        <?php

            include '../css/add_questions.css';
        ?>
    </style>
</head>
<body>
    <div class="panel panel-info">
        <div class="panel-heading" id="heading">
            <a id="back"  href="http://localhost/ExaminationSystem/admin/AdminMain.php" data-toggle="tooltip" data-placement="top" title="back"><span class="material-icons md-30">arrow_back</span></a>
            <a id="add" href="#" data-toggle="modal" data-target="#CreateQuestionModal"><span  data-toggle="tooltip" data-placement="top" title="add" class="material-icons md-35">add</span></a>
        </div>
        <div class="panel-body" id="panelbody">
            <div class="table-responsive">
                <table class="table" id="AddQuestions">
                    <thead>
                        <tr>
                            <th>Id</th> 
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Pursuing year</th>
                            <th>Question</th>
                            <th>option 1</th>
                            <th>option 2</th>
                            <th>option 3</th>
                            <th>option 4</th>
                            <th>correct option</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
   <!--<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#AddQuestions').DataTable({
                'serverSide':true,
                'processing':true,
                'paging':true,
                'order':[],
                'ajax':{
                    'url':'AddQuestionDetails.php',
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
    </script>
    <script type="text/javascript">
        $(document).on('submit','#CreateQuestionForm',function(event){
            var subject = $('#subject').val();
           // console.log('the create question subject: '+subject);
            var Class = $('#class').val();
            var Pursuing_year = $('#pursuing_year').val();
            var question = $('#question').val();
            var option1 = $('#option1').val();
            var option2 = $('#option2').val();
            var option3 = $('#option3').val();
            var option4 = $('#option4').val();
            var correct_option = $('#correct_option').val();
            if(subject != '' && Class != '' && Pursuing_year != '' && question != '' &&option1 != '' && option2 != '' && option3 !='' && option4 != '' && correct_option != ''){
                $.ajax({
                    url:'CreateQuestion.php',
                    type:'post',
                    data:{subject:subject,
                        Class:Class,  
                        Pursuing_year:Pursuing_year,
                        question:question,
                        option1:option1,
                        option2:option2,
                        option3:option3,
                        option4:option4,
                        correct_option:correct_option},
                    success:function(data){
                        var json = JSON.parse(data);
                        status = json.status;
                        if(status == 'success'){
                            table = $('#AddQuestions').DataTable();
                            table.draw();
                            var subject = $('#subject').val(' ');
                            var Class = $('#class').val('');
                            var Pursuing_year = $('#pursuing_year').val('');
                            var question = $('#question').val('');
                            var option1 = $('#option1').val('');
                            var option2 = $('#option2').val('');
                            var option3 = $('#option3').val('');
                            var option4 = $('#option4').val('');
                            var correct_option = $('#correct_option').val('');
                            $('#CreateQuestionModal').modal('toggle');
                            //$('#AddQuestions').DataTable().ajax.reload();
                            alert('Question Created');
                        }
                    }
                });
            }
            else{
                alert('failed..');
            }
        });
        
        $(document).on('click','.EditQuestion',function(){
            var id = $(this).data('id');
            var trid = $(this).closest('tr').attr('id');
            $.ajax({
                url:'EditQuestion.php',
                data:{id:id},
                type:'post',
                success:function(data){
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#trid').val(trid);
                    $('#edit_subject').val(json.subject);
                    $('#edit_class').val(json.class);
                    $('#edit_pursuing_year').val(json.pursuing_year);
                    $('#edit_question').val(json.question);
                    $('#edit_option1').val(json.option1);
                    $('#edit_option2').val(json.option2);
                    $('#edit_option3').val(json.option3);
                    $('#edit_option4').val(json.option4);
                    $('#edit_correct_option').val(json.correct_option);
                    $('#EditQuestionModal').modal('toggle');
                }
            });
        });
        
        $(document).on('submit','#EditQuestionForm',function(){
            var id = $('#id').val();
            var trid = $('#trid').val();
            var subject = $('#edit_subject').val();
            var Class = $('#edit_class').val();
            var pursuing_year = $('#edit_pursuing_year').val();
            var question = $('#edit_question').val();
            var option1 = $('#edit_option1').val();
            var option2 = $('#edit_option2').val();
            var option3 = $('#edit_option3').val();
            var option4 = $('#edit_option4').val();
            var correct_option = $('#edit_correct_option').val();
            $.ajax({
                url:'UpdateQuestion.php',
                data:{id:id,subject:subject,Class:Class,pursuing_year:pursuing_year,question:question,option1:option1,option2:option2,option3:option3,option4:option4,correct_option:correct_option},
                type:'post',
                success:function(data){
                    var json = JSON.parse(data);
                    var status = json.status;
                    if(status == 'success'){
                        table = $('#AddQuestions').DataTable();
                        var button = '<a href="#" data-id="'+id+'" class="EditQuestion" data-toggle="tooltip" data-placement="top" title="edit"><span class="material-icons md-20">edit</span></a>&nbsp;&nbsp;<a href="#" data-id="'+id+'" data-toggle="tooltip" class="DeleteQuestion" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>';
                        var row = table.row("[id='"+trid+"']");
                        row.row("[id='"+trid+"']").data([id,subject,Class,pursuing_year,question,option1,option2,option3,option4,correct_option,button]);
                        $('#EditQuestionModal').modal('toggle');
                    }
                    else{
                        alert('failed');
                    }
                }
            });
        });


        /* Delete Student */
        $(document).on('click','.DeleteQuestion',function(event){
              var id = $(this).data('id');
              if(confirm('Are you sure want to delete this question ?')){
                    $.ajax({
                    url:'DeleteQuestion.php',
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
    <div class="modal fade" id="CreateQuestionModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Create Question</strong></h4>
                </div>
                <form id="CreateQuestionForm" method="post" action="javascript:void(0);">
                    <input type="hidden" id="id" name="id" value=""/>
                    <input type="hidden" id="trid" name="trid" value=""/>
                    <div class="modal-body">
                        <?php 
                            include 'connect.php';
                            $subject = array();
                            $class = array();
                            $pursuing_year = array();
                            $sql = 'Select * from exam_paper';
                            $query = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_assoc($query)){
                                $subject[] = $row['subject'];
                                $class[] = $row['class'];
                                $pursuing_year[] = $row['pursuing_year'];
                            }
                        ?>
                        <div class="form-group">
                            <label id="label" for="subject">Subject</label>
                            <!--<input type="text" class="form-control" name="subject" id="subject" placeholder="Advanced Java" autocomplete="off" />-->
                            <select class="form-control" name="subject" id="subject">
                                <option selected="selected">select subject</option>
                                <?php 
                                    $subjects = array_unique($subject);
                                    foreach($subjects as $sub){
                                            echo ("<option value = '$sub' >$sub</option>");
                                            echo '<br>';
                                    }
                                ?>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label id="label" for="class">Class</label>
                            <!--<input type="text" class="form-control" name="class" id="class" placeholder="Eg: FY, SY, TY" autocomplete="off" /> -->
                            <select class="form-control" name="class" id="class">
                                <option selected="selected">select class</option>
                                <?php 
                                    $classes = array_unique($class);
                                    foreach($classes as $obj){
                                            echo ("<option value = '$obj'>$obj</option>");
                                            echo '<br>';
                                    }
                                ?>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label id="label" for="pursuing_year">Pursuing year</label>
                            <!--<input type="text" class="form-control" name="year" id="pursuing_year" placeholder="Eg: 2020-2021"autocomplete="off" />-->
                            <select class="form-control" name="pursuing_year" id="pursuing_year" >
                                <option selected="selected">select pursuing year</option>
                                <?php  
                                    $pursuing_year_set = array_unique($pursuing_year);
                                    foreach($pursuing_year_set as $py){
                                            echo ("<option value = '$py'>$py</option>");
                                            echo '<br>';
                                    }
                                ?>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label id="label" for="question">Question</label>
                            <input type="text" class="form-control" name="question" id="question"  autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="option1">Option1</label>
                            <input type="text" class="form-control" name="option1" id="option1" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="option2">Option2</label>
                            <input type="text" class="form-control" name="option2" id="option2" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="option3">Option3</label>
                            <input type="text" class="form-control" name="option3" id="option3" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="option4">Option4</label>
                            <input type="text" class="form-control" name="option4" id="option4" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="correct_option">Correct Option</label>
                            <input type="text" class="form-control" name="correct_option" id="correct_option" autocomplete="off" />
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="form-group" id="center">
                                <button type="submit" class="btn btn-success" id="Createbtn" >Create</button> &nbsp;&nbsp;
                                <a  href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit modal -->
    <div class="modal fade" id="EditQuestionModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog"> 
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Edit Question</strong></h4>
                </div>
                <form id="EditQuestionForm" method="post" action="javascript:void(0);"> 
                    <div class="modal-body">
                        <?php 
                            include 'connect.php';
                            $subject = array();
                            $class = array();
                            $pursuing_year = array();
                            $sql = 'Select * from exam_paper';
                            $query = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_assoc($query)){
                                $subject[] = $row['subject'];
                                $class[] = $row['class'];
                                $pursuing_year[] = $row['pursuing_year'];
                            }
                        ?>
                        <div class="form-group">
                            <label id="label" for="edit_subject">Subject</label>
                            <!--<input type="text" class="form-control" name="subject" id="subject" placeholder="Advanced Java" autocomplete="off" />-->
                            <select class="form-control" name="edit_subject" id="edit_subject">
                                <option selected="selected">select subject</option>
                                <?php 
                                    $subjects = array_unique($subject);
                                    foreach($subjects as $sub){
                                            echo ("<option value = '$sub'>$sub</option>");
                                            echo '<br>';
                                    }
                                ?>     
                            </select>
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_class">Class</label>
                            <!--<input type="text" class="form-control" name="class" id="class" placeholder="Eg: FY, SY, TY" autocomplete="off" /> -->
                            <select class="form-control" name="edit_class" id="edit_class">
                                <option selected="selected">select class</option>
                                <?php 
                                    $classes = array_unique($class);
                                    foreach($classes as $obj){
                                            echo ("<option value = '$obj'>$obj</option>");
                                            echo '<br>';
                                    }
                                ?>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_pursuing_year">Pursuing year</label>
                            <!--<input type="text" class="form-control" name="year" id="pursuing_year" placeholder="Eg: 2020-2021"autocomplete="off" />-->
                            <select class="form-control" name="edit_pursuing_year" id="edit_pursuing_year" >
                                <option selected="selected">select pursuing year</option>
                                <?php  
                                    $pursuing_year_set = array_unique($pursuing_year);
                                    foreach($pursuing_year_set as $py){
                                            echo ("<option value = '$py'>$py</option>");
                                            echo '<br>';
                                    }
                                ?>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_question">Question</label>
                            <input type="text" class="form-control" name="question" id="edit_question"  autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_option1">Option1</label>
                            <input type="text" class="form-control" name="option1" id="edit_option1" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_option2">Option2</label>
                            <input type="text" class="form-control" name="option2" id="edit_option2" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_option3">Option3</label>
                            <input type="text" class="form-control" name="option3" id="edit_option3" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_option4">Option4</label>
                            <input type="text" class="form-control" name="option4" id="edit_option4" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="edit_correct_option">Correct Option</label>
                            <input type="text" class="form-control" name="correct_option" id="edit_correct_option" autocomplete="off" />
                        </div>
                    </div>
                    <div class="modal-footer">
                                <div class="form-group" id="center">
                                    <button type="submit" class="btn btn-success" id="Editbtn" >Edit</button> &nbsp;&nbsp;
                                    <a  href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                                </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</body>
</html>

