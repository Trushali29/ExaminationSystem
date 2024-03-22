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
         <?php include '../css/StudentResult.css'; ?>
        </style>
   </head>
   <body>  
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading" id="heading">
                <a href="http://localhost/ExaminationSystem/student/StudentMain.php" data-toggle="tooltip" data-placement="top" data-title="back"><span class="material-icons md-30">arrow_back</span></a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="ResultDisplayTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Subject</th>
                                <th>Total Question</th>
                                <th>Total Marks</th>
                                <th>Negative marking</th>
                                <th>Marks Obtained</th>
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
            $('#ResultDisplayTable').DataTable({
                'serverSide':true,
                'processing':true,
                'paging':true,
                'order':[],
                'ajax':{
                    'url':'StudentResultDetails.php',
                    'type':'post',
                },
                'fnCreatedRow':function(nRow,aData,iDataIndex){
                    $(nRow).attr('id',aData[0]);
                },
                'columnDefs':[{
                    'target':[0],
                    'orderable':false,
                }]
             });
        });
    </script>
   </body> 
</html>