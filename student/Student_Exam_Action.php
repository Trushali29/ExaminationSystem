<?php 
session_start();
$data = $_SESSION['output'];
$json_data = json_decode($data,JSON_PRETTY_PRINT);
//print_r($json_data);
$exam_subject = ($json_data['subject']);
$time_limit = $json_data['time_limit'];
$questions = $json_data['questions'];
$correct_answers = $json_data['correct_answers'];
$options = $json_data['options'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        <?php include '../css/exam_action.css';
        ?>
    </style>
</head>
<body>
    <div class="container-fluid" id="container">
        <div class="panel" id="exam_panel">
            <form id="ResultForm" method="post" action="javascript:void(0);">
                <div class="panel-heading">
                    <p id="timer" hidden><?php echo $time_limit;?></p>
                    <h4>&nbsp;&nbsp;Name: <?php echo $_SESSION['fullname']; ?></h4><br>
                    <h4 id="subject">&nbsp;&nbsp;Subject: <?php echo $exam_subject.'<br>';?></h4>
                    <div id="exam_timer">
                        <p id="hours"></p>
                        <p id="mins"></p>
                        <p id="secs"></p>
                    </div>
                </div>
                <div class="panel-body" id="Question_Options">
                    <div class="group">
                        <!--  QUESTION  -->
                        <label id="question"></label>
                        <div class="radio">
                            <label for="option1">
                                <input  type="radio" name="radio_input_option" id="radio_input1" value="none" /><span id="option1"></span>
                            </label>
                        </div>
                        <div class="radio">
                            <label for="option2">
                                <input  type="radio" name="radio_input_option" id="radio_input2" value="none"/><span id="option2"></span>
                            </label>
                        </div>
                        
                        <div class="radio">
                            <label for="option3">
                                <input type="radio" name="radio_input_option" id="radio_input3" value="none"/><span id="option3"></span>
                            </label>
                        </div>
                        <div class="radio">
                            <label for="option4">
                                <input type="radio" name="radio_input_option" id="radio_input4" value="none"/><span id="option4"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <ul id="pagination">
                    <li><button class="btn btn-primary" id="pagination_button_previous" onclick="previous()" href="#">Previous</button></li>
                    <li><button class="btn btn-primary" id="pagination_button_next" onclick="next()" href="#">Next</button></li>
                    <li><button class="btn btn-danger" id="pagination_button_submit" onclick="next()" href="#">Submit</button></li>
                </ul>
            </form>
        </div>
      
    </div>
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

     <!-- THIS SCRIPT IS TO DISPLAY TIMER PROVIDE BY THE DATA AND REDIRECT TO MAIN PAGE WHEN TIMEOUT-->
    <script>
        function redirect_main_page(){
            var exam_subject = "<?php echo $exam_subject ?>";
            var student_name = "<?php echo $_SESSION['fullname'];?>";
            var correct_answers = new Array();
            <?php foreach ($correct_answers as $c){ ?>
                correct_answers.push("<?php echo $c ;?>");
            <?php } ?>
            $.ajax({
                url: 'StudentCreateResult.php',
                data:{radio_value:radio_value,exam_subject:exam_subject,student_name:student_name,correct_answers:correct_answers},
                type:'post',
                success:function(data){
                    /* REDIRECT TO THE MAIN PAGE WHICH IN TURN IT WILL REDIRECT TO THE USER WHO HAS LOGGED IN  */
                    $('#RedirectMainPage').modal('toggle');
                    const myTimeout = setTimeout(main_page, 5000);
                    function main_page() {
                        window.location.replace('http://localhost/ExaminationSystem/student/StudentMain.php');
                    } 
                }
            });  
        }

        // Run myfunc every second
        var CurrentTime = new Date().getTime();
        var minutes = document.getElementById("timer").innerHTML;
        var timer = AddMinutesToDate(CurrentTime,minutes);
        function AddMinutesToDate(date, minutes) {
            return new Date(date + minutes * 60000);
        }
        //console.log(timer);
        var myfunc = setInterval(function() {
            var now = new Date().getTime();
            var timeleft = timer - now;
            // Calculating the days, hours, minutes and seconds left
            var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
            // Result is output to the specific element
            document.getElementById("hours").innerHTML = hours + "h " 
            document.getElementById("mins").innerHTML = minutes + "m " 
            document.getElementById("secs").innerHTML = seconds + "s " 
            // Display the message when countdown is over
            if (timeleft < 0) {
                clearInterval(myfunc);
                document.getElementById("hours").innerHTML = "" 
                document.getElementById("mins").innerHTML = ""
                document.getElementById("secs").innerHTML = ""
                if(document.getElementById('#pagination_button_submit').clicked == false){
                    redirect_main_page();
                }
              
            }
        }, 1000);        
    </script>

    <!-- THIS SCRIPT IS TO DISPLAY QUESTIONS WITH RESPECTED OPTIONS -->
    <script type="text/javascript">
        /* HIDE THE SUBMIT BUTTON*/
        $("#pagination_button_submit").css('visibility','hidden');
        var index = 0; /* CONSIDER AS ROW */
        var question_number = 0;
        /* STORE QUESTIONS IN ARRAY */
        var questions = new Array();
        <?php foreach ($questions as $q){ ?>
            questions.push("<?php echo $q ;?>");
        <?php } ?>
        //console.log(questions);
        /* OPTIONS */
        var sub_options = new Array();
        <?php foreach ($options as $op){ foreach($op as $o){ ?>
            sub_options.push("<?php echo $o ;?>");
        <?php } ?><?php  } ?>
        //console.log(sub_options);
        var option = new Array();
        var start = 0;
        var end = 4;
        option.push(sub_options.slice(start,end));
        for(i = 0;i < questions.length-1 ;i ++){
            start = start + 4;
            end = end + 4;
            var temp = sub_options.slice(start,end);
            option.push(temp);
        }
        //console.log(option);
        document.getElementById('question').innerHTML = 'Q1. '+ questions[0];
        document.getElementById('radio_input1').value = option[0][0];
        document.getElementById('radio_input2').value = option[0][1];
        document.getElementById('radio_input3').value = option[0][2];
        document.getElementById('radio_input4').value = option[0][3];

        document.getElementById('option1').innerHTML = option[0][0];
        document.getElementById('option2').innerHTML = option[0][1];
        document.getElementById('option3').innerHTML = option[0][2];
        document.getElementById('option4').innerHTML = option[0][3];

        /*  TO KEEP THE STATE OF THE RADIO BUTTON AND FETCH THE VALUE AND RADIO ID SELECTED */
        var radio_value = new Array(questions.length);
        var radio_id = new Array(questions.length);
        /* SET THE INITIAL VALUE TO NONE */
        for (let i = 0; i < questions.length; i++) {
            radio_value[i] = 'none';
        }
        function selected_state_radiobutton(index){
            var radio_state = document.getElementsByName('radio_input_option');
            //console.log(radio_state);
            for (var i=0; i<radio_state.length; i++)
            {
                if(radio_state[i].checked == true){
                    /* check duplicate values */
                    if(radio_value[i] != radio_state[i].value){
                        /* UPDATE THAT POSITION OF THE CHANGED VALUE 
                        //var radio_btn = radio_state[i].id;
                        //radio_btn.checked = true;
                        */
                        radio_value[index] = radio_state[i].value;
                        var radio_btn = radio_state[i].id;
                        radio_id[index] = radio_btn;
                    }
                    else{
                        /* IF SAME VALUE THEN GO TO NEXT ITERATION */
                        continue;
                    }
                } 
            }
            console.log(radio_value);
            //console.log(radio_id);
        } 
        /* THIS IS USED TO RESET ALL THE RADIO BUTTON ONCE CLICK ON NEXT AND PREVIOUS */
        function reset_radio(){
            var radio = document.getElementsByName('radio_input_option');
           // console.log(radio);
            for (var i=0; i<radio.length; i++)
            {
            var radioButton = radio[i];
            radioButton.checked = false;
            }
        }
        /* CHANGE THE VALUE OF RADIO BUTTON ON EACH CLICK  */
        function autoset_and_change_radio_values(index){
            var radio = document.getElementsByName('radio_input_option');
            for (var i=0; i<radio.length; i++)
            {
                radio[i].value =  option[index][i];
                /* TO CHECK IF THe RADIO ID IS ALREADY CHECKED BY USER THEN AUTOSET IT AS CHECKED */
                if(radio_id[index] == radio[i].id){
                    document.getElementById(radio_id[index]).checked = true;
                }
            }
        }
        /*  NEXT BUTTON */
        function next(){
            selected_state_radiobutton(index);
            reset_radio();
            index ++;   
            question_number = index + 1;
            if(index >= questions.length-1){
                index = questions.length - 1;
                question_number = questions.length ;
                document.getElementById('question').innerHTML = 'Q'+question_number+'. '+ questions[index];
                autoset_and_change_radio_values(index);
                document.getElementById('option1').innerHTML = option[index][0];
                document.getElementById('option2').innerHTML = option[index][1];
                document.getElementById('option3').innerHTML = option[index][2];
                document.getElementById('option4').innerHTML = option[index][3]; 
                /* SHOW SUBMIT BUTTON WHEN LAST QUESTION */
                $("#pagination_button_submit").css('visibility','visible');  
            }
            else{  

                document.getElementById('question').innerHTML = 'Q'+question_number+'. '+ questions[index];
                autoset_and_change_radio_values(index);
                document.getElementById('option1').innerHTML = option[index][0];
                document.getElementById('option2').innerHTML = option[index][1];
                document.getElementById('option3').innerHTML = option[index][2];
                document.getElementById('option4').innerHTML = option[index][3];        
            }
        }
        /* PREVIOUS BUTTON */
        function previous(){
            selected_state_radiobutton(index);
            reset_radio();
            index -- ;
            question_number = index + 1; 
            if( index < 0){
                index = 0;
                question_number = 1;
                document.getElementById('question').innerHTML =  'Q'+question_number+'. '+ questions[index];
                autoset_and_change_radio_values(index); 
                document.getElementById('option1').innerHTML = option[index][0];
                document.getElementById('option2').innerHTML = option[index][1];
                document.getElementById('option3').innerHTML = option[index][2];
                document.getElementById('option4').innerHTML = option[index][3];
                /* HIDE THE SUBMIT BUTTON*/
                $("#pagination_button_submit").css('visibility','hidden');
            }
            else{
                document.getElementById('question').innerHTML = 'Q'+question_number+'. '+ questions[index];
                autoset_and_change_radio_values(index);
                document.getElementById('option1').innerHTML = option[index][0];
                document.getElementById('option2').innerHTML = option[index][1];
                document.getElementById('option3').innerHTML = option[index][2];
                document.getElementById('option4').innerHTML = option[index][3];
                /* HIDE THE SUBMIT BUTTON*/
                $("#pagination_button_submit").css('visibility','hidden');
            }
        } 
    </script>
    <!-- ON CLICK OF SUBMIT THE STUDENT IS REDIRECTED TO MAIN PAGE  -->
    <script type="text/javascript">
        $(document).on('click','#pagination_button_submit',function(){
            redirect_main_page();
        });
    </script>
    <div class="modal fade" id="RedirectMainPage" role="dialog" data-backdrop="false">
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