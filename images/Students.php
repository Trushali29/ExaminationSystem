<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
    <style>
        <?php include '../css/students.css';
        ?>
    </style>
</head>

<body>
    <div class="panel panel-info" style="margin-top: 40px;">
        <div class="panel-heading" id="heading">
            <a id="back" href="http://localhost/ExaminationSystem/admin/AdminMain.php" data-toggle="tooltip" data-placement="top" title="back"><span class="material-icons md-30">arrow_back</span></a>
            <a id="add" href="#" data-toggle="modal" data-target="#addModal"><span data-toggle="tooltip" data-placement="top" title="add" class="material-icons md-35">add</span></a>
        </div>
        <div class="panel-body  table-responsive">
            <table class="table" id="StudentTable">
                <thead>
                    <tr>
                        <!-- <th>Image</th> -->
                        <th>Id</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>password</th>
                        <th>Pursuing Year</th>
                        <th>class</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Amit Aggarwal</td>
                        <td>Amit@gmail.com</td>
                        <td>Amit</td>
                        <td>20202-2021</td>
                        <td>FY</td>
                        <td><a class="btn btn-primary">Edit</a> &nbsp;
                            <a class="btn btn-warning">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- add student modal -->
    <div class="modal fade" id="AddStudentModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>ADD STUDENT</strong></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="AddStudent">
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
                            <button  type="button" onclick="addStudent()" name="AddStudents" class="btn btn-success" id="btn">Add</button>&nbsp;&nbsp;
                            <a href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready( function () {
            $("#StudentTable").DataTable({
                "serverSide": true,
                "processing": true,
                "paging":true,
                "order":[],
                "ajax":{
                    url:"StudentDetails.php",
                    type:"post",
                },
                'fncreateRow':function(nRow,aData,iDataIndex){
                    $(nRow).attr('id',aData[0]);
                },
                "columnDefs":[{
                     "target":[0,6],
                     "orderable":false,
                    }]
                });
        });
   
        
   </script>
</body>

</html>
 <!-- Edit modal
    <div class="modal fade" id="EditModal" role="dialog" data-backdrop="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><strong>EDIT DETAILS</strong></h4>
                        </div>
                        <form action="" method="post"> 
                        <div class="modal-body">
                            <div class="form-group"  id="center">
                                <img  id="image" src="http://localhost/ExaminationSystem/images/home.jpg" />
                                <a id="edit-link" href="http://localhost/ExaminationSystem/images/home.jpg"><span class="material-icons md-21">edit</span></a>
                            </div> &nbsp; &nbsp;
                            <div class="form-group">
                                <label id="label" for="Fullname">Fullname</label>
                                <input type="text" class="form-control" name="Fullname" id="Fullname"  autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label id="label" for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="Email" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label id="label" for="password">Password</label>
                                <input type="password" class="form-control"  name="password" id="Password" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label id="label" for="datepicker">Pursing year</label>
                                <input type="text" class="form-control" name="datepicker" id="datepicker" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label id="label" for="class">Class</label>
                                <input type="text" class="form-control" name="class" id="class" autocomplete="off" />
                            </div>
                        </div>
                        <div class="modal-footer">
                                <div class="form-group" id="center">
                                    <button type="submit" class="btn btn-success" id="btn" >Save</button> &nbsp;&nbsp;
                                    <a  href="#" data-dismiss="modal" class="btn btn-primary" id="btn-close">Close</a>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
    </div> -->