<?php 
error_reporting (E_ALL ^ E_NOTICE);
include '../admin/connect.php';
$exam_id = $_POST['exam_id'];
$student_class = $_POST['student_class'];
$student_py = $_POST['student_py'];
$exam_subject = $_POST['exam_subject'];

/* GETTING QUESTIONS  */
$questions = array();
$correct_answers = array();
$options = array();
$option_sub_array = array();
$exam_time_limit ='';

/* GET EXAM TIME LIMIT*/ 
$exam_sql = "SELECT time_limit from exam_paper WHERE subject = '$exam_subject' AND class='$student_class' AND pursuing_year='$student_py'";
$exam_query = mysqli_query($con,$exam_sql);
while($exam_time = mysqli_fetch_assoc($exam_query)){
    $exam_time_limit = $exam_time['time_limit'];
}

/* GET QUESTIONS AND CORRECT ANSWERS */
$question_sql = "SELECT * FROM questions WHERE subject = '$exam_subject' AND class='$student_class' AND pursuing_year='$student_py'";
$question_query = mysqli_query($con,$question_sql);
while($q = mysqli_fetch_assoc($question_query)){
    $questions[] = $q['question'];
    $correct_answers[] = $q['correct_option']; 
}

/*GETTING OPTIONS FOR EACH QUESTION */
foreach($questions as $Que){
    $option_sql = "SELECT * from questions WHERE question='$Que' AND subject = '$exam_subject' AND class='$student_class' AND pursuing_year='$student_py' ";
    $option_query = mysqli_query($con,$option_sql);
    while($option = mysqli_fetch_assoc($option_query)){
        $option_sub_array[] = $option['option1'];
        $option_sub_array[] = $option['option2'];
        $option_sub_array[] = $option['option3'];
        $option_sub_array[] = $option['option4'];
    }
}

/*  SPLTTING THE SUBDATA INTO 4 CHUNKS OPTIONS SOTRED IN THE MAIN ARRAY OPTION */
$option = array_chunk($option_sub_array,4);

/*$output = array(
    'subject' => $exam_subject,
);
echo json_encode($output);
*/

 
session_start();
if(($exam_query==true) && ($question_query == true) && ($option_query == true)){
    $output = array(
        'subject' => $exam_subject,
        'questions' => $questions,
        'correct_answers' => $correct_answers,
        'options' => $option,
        'time_limit' => $exam_time_limit,
        'status' => 'success',
    );
    $_SESSION['output'] = json_encode($output,JSON_PRETTY_PRINT);
    echo json_encode($output,JSON_PRETTY_PRINT);
}
else{
    $output = array(
        'subject' => $exam_subject,
        'questions' => $questions,
        'correct_answers' => $correct_answers,
        'options' => $option,
        'time_limit' => $exam_time_limit,
        'status' => 'failed',
    );
    $_SESSION['output'] = json_encode($output,JSON_PRETTY_PRINT);
    echo json_encode($output,JSON_PRETTY_PRINT);
}
?>
