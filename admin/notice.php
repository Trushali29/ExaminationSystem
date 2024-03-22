<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        <?php include '../css/notice.css';
        ?>
    </style>
</head>
<body>
<!--<div class="alert alert-success" role="alert">Notice created Successfully</div> -->
    <div class="panel-group">
        <div class="panel">
            <div class="panel-heading" id="heading">
            <a id="back"  href="http://localhost/ExaminationSystem/admin/AdminMain.php" data-bs-toggle="tooltip" data-bs-placement="top" title="back"><span class="material-icons md-30">arrow_back</span></a>

            <a type="button" data-toggle="modal" data-target="#NoticeModal"><span data-toggle="tooltip" data-placement="top" title="create" class="material-icons md-25">create</span></a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="NoticeTable">
                        <thead>
                                <th>Id</th>
                                <th>Description</th>
                                <th>status</th>
                                <th>Actions</th>
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
     <!-- Read Notices -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#NoticeTable').DataTable({
                'serverSide':true,
                'processing':true,
                'paging':true,
                'order':[],
                'ajax':{
                    'url':'NoticeDetails.php',
                    'type':'post',
                },
                'fnCreatedRow':function(nRow,aData,iDataIndex){
                    $(nRow).attr('id',aData[0]);
                },
                'columnDefs':[{
                    'target':[0,3],
                    'orderable':false,
                }]
            });
        });
    </script>

    <script  type="text/javascript">
          /* Create Notices */
        $(document).on('submit','#CreateNoticeForm',function(event){
              var description = $('#description').val();
              var Status = 'unpublish';
              if(description != '', Status=='unpublish'){
                  $.ajax({
                        url:'CreateNotice.php',
                        data:{description:description,Status:Status},
                        type:'post',
                        success:function(data){
                            var json = JSON.parse(data);
                            status = json.status;
                            if(status=='success'){
                                table = $('#NoticeTable').DataTable();
                                table.draw();
                                var description = $('#description').val('');
                                $('#NoticeModal').modal('hide');
                               // alert('Notice created Successfully');
                            }

                        }
                  });
              }
              else{
                  alert("Please fill the required fields");
              }
          });

        /* Delete Notice */
        $(document).on('click','.DeleteNotice',function(event){
            var currentRow = $(this).closest('tr');
            var id = currentRow.find('td:eq(0)').text();
            if(confirm('Are you sure you want to delete this notice ?')){
                $.ajax({
                    url:'DeleteNotice.php',
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

        /* Publish Notice */
        $(document).on('click','.PublishNotice',function(event){
            var currentRow = $(this).closest('tr');
            var id = currentRow.find('td:eq(0)').text();
            var description = currentRow.find('td:eq(1)').text();
            var NoticeStatus = 'publish';
            if(confirm('Are you sure you want to publish the notice?')){
                $.ajax({
                    url:'PublishNotice.php',
                    data:{id:id,NoticeStatus:NoticeStatus},
                    type:'post',
                    success:function(data){
                        var json = JSON.parse(data);
                        var status = json.status;
                        if(status == 'success'){
                            table = $('#NoticeTable').DataTable();
                            var button= '<a href="#" data-id="'+id+'" class="DeleteNotice" data-toggle="tooltip" data-placement="top" title="delete"><span id="delete" class="material-icons md-20">delete</span></a>&nbsp;&nbsp;<a href="#" data-id="'+id+'" class="PublishNotice" data-toggle="tooltip" data-placement="top" title="publish"><span id="publish" class="material-icons md-20">publish</span></a>';
                            var row = table.row("[id='"+id+"']");
                            row.row("[id='"+id+"']").data([id,description,NoticeStatus,button]);
                            alert('Message published');
                        }
                        else{
                            alert('failed');
                        }
                    },
                });
            }
          });
    </script>

    <!-- create notice modal -->
    <div class="modal fade" id="NoticeModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Create Notice</strong></h4>
                </div>
                <form id="CreateNoticeForm" method="post" action="javascript:void(0);"> 
                <div class="modal-body">
                    <div class="form-group">
                        <label id="label" for="description">Description</label>
                        <textarea rows="5" class="form-control" name="description" id="description"  autocomplete="off"></textarea>
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
</body>
</html>