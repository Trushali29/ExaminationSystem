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
        <?php include '../css/students.css';
        ?>
    </style>
</head>

<body>
    <div class="panel">
        <div class="panel-heading" id="heading">
            <a id="back" href="http://localhost/ExaminationSystem/admin/AdminMain.php" data-toggle="tooltip" data-placement="top" title="back"><span class="material-icons md-30">arrow_back</span></a>
            <a id="add" href="#" data-toggle="modal" data-target="#AddStudentModal"><span data-toggle="tooltip" data-placement="top" title="add" class="material-icons md-35">add</span></a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="StudentTable" class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Pursuing Year</th>
                            <th>Class</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#StudentTable').DataTable({
                'serverSide':true,
                'processing':true,
                'paging':true,
                'order':[],
                'ajax':{
                    'url':'StudentDetails.php',
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
          $(document).on('submit','#AddStudentForm',function(event){
              var fullname = $('#fullname').val();
              var email = $('#email').val();
              var password = $('#password').val();
              var pursuing_year = $('#pursuing_year').val();
              var Class = $('#class').val();

              if(fullname != '' && email != ''&& password != '' && pursuing_year != '' && Class != ''){
                  $.ajax({
                      url:'AddStudent.php',
                      data:{fullname:fullname,
                            email:email,
                            password:password,
                            pursuing_year:pursuing_year,
                            Class:Class,
                        },
                        type:'post',
                        success:function(data){
                            var json = JSON.parse(data);
                            status = json.status;
                            if(status=='success'){
                                table = $('#StudentTable').DataTable();
                                table.draw();
                                $('#AddStudentForm')[0].reset();
                                $('#AddStudentModal').modal('hide');
                                alert('Student Added Successfully');
                            }

                        }
                  });
              }
              else{
                  alert("Please fill the required fields");
              }
          });

          /* Delete Student */
          $(document).on('click','.DeleteStudent',function(event){
              var id = $(this).data('id');
              if(confirm('Are you sure want to delete this user ?')){
                    $.ajax({
                    url:'DeleteStudent.php',
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

          $(document).on('click','.EditStudent',function(){
              var id = $(this).data('id');
              var trid = $(this).closest('tr').attr('id');
              $.ajax({
                  url:'EditStudent.php',
                  data:{id:id},
                  type:'post',
                  success:function(data){
                      var json = JSON.parse(data);
                      $('#id').val(json.id);
                      $('#trid').val(trid);
                      $('#EditFullname').val(json.fullname);
                      $('#EditEmail').val(json.email);
                      $('#EditPassword').val(json.password);
                      $('#Editpursuing_year').val(json.pursuing_year);
                      $('#Editclass').val(json.class);
                      $('#EditStudentModal').modal('show');
                  }
              });
          });

          $(document).on('submit','#EditStudentForm',function(event){
              var id = $('#id').val();
              var trid = $('#trid').val();
              var fullname = $('#EditFullname').val();
              var email = $('#EditEmail').val();
              var password = $('#EditPassword').val();
              var pursuing_year = $('#Editpursuing_year').val();
              var Class = $('#Editclass').val();
              $.ajax({
                  url:'UpdateStudent.php',
                  data:{id:id,fullname:fullname,email:email,password:password,pursuing_year:pursuing_year,Class:Class},
                  type:'post',
                  success:function(data){
                      var json = JSON.parse(data);
                      var status = json.status;
                      if(status=='success'){
                          table = $('#StudentTable').DataTable();
                          var button = '<a href="#" data-id="'+id+'" class="EditStudent" data-toggle="tooltip" data-placement="top" title="edit"><span id="edit" class="material-icons md-20">edit</span></a>&nbsp;&nbsp;<a href="#" data-id="'+id+'" class="DeleteStudent" data-toggle="tooltip" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>';
                          var row = table.row("[id='"+trid+"']");
                          row.row("[id='"+trid+"']").data([id,fullname,email,password,pursuing_year,Class,button]);
                          $('#EditStudentModal').modal('hide');
                      }
                      else{
                          alert('failed');
                      }
                  }
              });
          });
      </script>
   <!-- add student modal -->
   <div class="modal fade" id="AddStudentModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>ADD STUDENT</strong></h4>
                    <!-- <button type="button" class="close" data-bs-dismiss="modal">&times;</button> -->
                </div>
                <form id="AddStudentForm" method="post" action="javascript:void(0);">
                    <div class="modal-body">
                        <div class="form-group">
                            <label id="label" for="fullname">Fullname</label>
                            <input type="text" class="form-control" id="fullname" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="email">Email</label>
                            <input type="email" class="form-control" id="email" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password of 8 characters" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="pursuing_year">Pursing year</label>
                            <input type="text" class="form-control" id="pursuing_year" autocomplete="off" placeholder="Eg: 2020-2021" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="class">Class</label>
                            <input type="text" class="form-control" id="class" placeholder="Eg: FY, SY, TY" autocomplete="off" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group" id="center">
                            <button  type="submit" name="AddStudents" class="btn btn-success" id="btnAdd">Add</button>&nbsp;&nbsp;
                            <a href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
      <!-- Edit modal -->
    <div class="modal fade" id="EditStudentModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>EDIT DETAILS</strong></h4>
                </div>
                <form id="EditStudentForm" action="javascript:void(0);" method="post"> 
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value=""/>
                        <input type="hidden" id="trid" name="trid" value=""/>
                        <div class="form-group">
                            <label id="label" for="EditFullname">Fullname</label>
                            <input type="text" class="form-control" name="EditFullname" id="EditFullname"  autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="EditEmail">Email</label>
                            <input type="email" class="form-control" name="EditEmail" id="EditEmail" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label id="label" for="EditPassword">Password</label>
                            <input type="text" class="form-control"  name="EditPassword" id="EditPassword" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                        <label id="label" for="Editpursuing_year">Pursing year</label>
                        <input type="text" class="form-control" name="Editpursuing_year" id="Editpursuing_year" autocomplete="off" placeholder="Eg: 2020-2021" />
                    </div>
                    <div class="form-group">
                        <label id="label" for="Editclass">Class</label>
                        <input type="text" class="form-control" name="Editclass" id="Editclass" placeholder="Eg: FY, SY, TY" autocomplete="off" />
                    </div>
                    </div>
                    <div class="modal-footer">
                            <div class="form-group" id="center">
                            <button type="submit" class="btn btn-success" id="btnEdit" >Save</button> &nbsp;&nbsp;
                                <a  href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</body>

</html>
