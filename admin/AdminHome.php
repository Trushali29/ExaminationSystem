<!DOCTYPE html>
<html>
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
       <style>
         .mytable{
          font-family: 'Cormorant', serif;
           font-size: 18px;
           display: flex;
           justify-content: center;
           margin-top:80px;
         } 
         .container{
           background-color: #F3F1F5;
           margin:50px;
           border-radius: 3px;
           width: 240px;
           height: 140px;
           box-shadow: none;
         }   
         .container:hover{
          transform: scale(1.05);
          box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
         }
         .content{
          margin: 40px 10px 10px 10px;
         }
         #icon{
           color: white;
           padding:0 8px 0 8px;
           margin-top:10px;
           font-size: 50px;
           height: 54px;
         }
         #text{
           margin-top: -1.8cm;
         }
         #text,#text1{
           text-align: center;
           color:white;
           margin-left: 2cm;
         }
         #text1{
           margin-top:-0.1cm;
         }
        </style>
   </head>
   <body>
     <table class="mytable">
       <tr>
         <td>
            <div class="container" style="background-color:#cd5700">
                <div class="content"><i class="fa fa-user" id="icon"></i></div>
                  <?php
                    include ('connect.php');
                    $sql = "SELECT * from student";
                    $result = mysqli_query($con,$sql);
                    echo '<h3 id="text"> '.mysqli_num_rows($result).' </h3>'; 
                  ?>
                  <h3 id="text1">Students</h3> 
            </div>
         </td>
         <td>
            <div class="container" style="background-color:#AE431E">
                <div class="content"><span id="icon" class="material-icons">article </span></i></div>
                  <?php
                    include ('connect.php');
                    $sql = "SELECT * from exam_paper";
                    $result = mysqli_query($con,$sql);
                    echo '<h3 id="text"> '.mysqli_num_rows($result).' </h3>'; 
                  ?>
                  <h3 id="text1">Exam paper</h3> 
            </div>
         </td>
        </tr>
        <tr>
         <td>
            <div class="container" style="background-color:#22577E" >
                <div class="content"><span id="icon" class="material-icons">note_alt</span></i></div>
                  <?php 
                    include('connect.php');
                    $sql = "SELECT * FROM result";
                    $result = mysqli_query($con,$sql);
                    echo '<h3 id="text">'.mysqli_num_rows($result).'</h3>';
                  ?> 
                  <h3 id="text1">Result</h3>
            </div>
         </td>
         <td>
            <div class="container" style="background-color:#66806A">
                <div class="content"><span id="icon" class="material-icons">task</span></div>
                  <?php
                    include ('connect.php');
                    $sql = "SELECT * FROM notice ";
                    $result = mysqli_query($con,$sql);
                    echo '<h3 id="text"> '.mysqli_num_rows($result).' </h3>'; 
                  ?>
                  <h3 id="text1">Notice</h3> 
            </div>
         </td>
        </tr>
     </table>
   </body> 
</html>
