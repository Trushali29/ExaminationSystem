<?php
function UpdateStatusExamPaper(){
include('connect.php');
include('../functions/validate_data.php');
$exam_sql = "SELECT * FROM exam_paper";
$exam_query = mysqli_query($con,$exam_sql);
$total_exam_paper = mysqli_num_rows($exam_query);
$exam_subject = array();
$exam_class = array();
$exam_py = array();
while($erow = mysqli_fetch_assoc($exam_query)){
    $exam_subject[] = $erow['subject'];
    $exam_class[] = $erow['class'];
    $exam_py[] = $erow['pursuing_year'];

  }
   
$Qsubject = array();
$Qclass = array();
$Qpursuing_year = array();
$Question = array();
$question_sql = 'SELECT * FROM questions';
$question_query = mysqli_query($con,$question_sql);
$total_questions = mysqli_num_rows($question_query);
while($question = mysqli_fetch_assoc($question_query)){
    $Qsubject[] = $question['subject'];
    $Qclass[] = $question['class'];
    $Qpursuing_year[] = $question['pursuing_year'];
    $Question[] = $question['question'];     
}
   
$Result_subject = array();
$Result_class = array();
$Result_pursuing_year = array();
$result_sql = "SELECT * FROM result";
$result_query = mysqli_query($con,$result_sql);
$total_result = mysqli_num_rows($result_query);
while($result = mysqli_fetch_assoc($result_query)){
    $Result_subject[] = $result['subject'];
    $Result_class[] = $result['class'];
    $Result_pursuing_year[] = $result['pursuing_year'];  
}


for($i=0;$i<$total_exam_paper;$i++)
{
   if(isset($exam_subject[$i]) && isset($exam_class[$i]) && isset($exam_py[$i]))
   {
        $subject = test_input($exam_subject[$i]);
        $class = test_input($exam_class[$i]);
        $pursuing_year = test_input($exam_py[$i]);
        $Q_count = 0;
        for($q=0;$q<$total_questions;$q++)
        {
            if(isset($Qsubject[$q]) && isset($Qclass[$q]) && isset($Qpursuing_year[$q]))
            {  
                $Q_sub = test_input($Qsubject[$q]);
                $Q_class = test_input($Qclass[$q]);
                $Q_py = test_input($Qpursuing_year[$q]);
                if(($subject == $Q_sub) && ($class == $Q_class) && ($pursuing_year == $Q_py))
                {
                    $Q_count = $Q_count + 1;
                }
               
            }  
        }
        $question = '';
        $status ='';
        $Question_sql = "SELECT  tot_questions,status FROM exam_paper WHERE subject like '%".$subject."%' AND class like '%".$class."%' AND pursuing_year like '%".$pursuing_year."%'";
        $Question_query = mysqli_query($con,$Question_sql);
        while ($tot_Q = mysqli_fetch_assoc($Question_query)){
            $question = $tot_Q['tot_questions'];
            $status = $tot_Q['status'];
        }
        /* CHANGE THE STATUS OF THE EXAM_PAPER AS CREATED */
        if(($Q_count == $question) && ($status =='Pending')){
            $UpdateExamStatus = "UPDATE exam_paper SET status = 'Created' WHERE subject like '%".$subject."%' AND class like '%".$class."%' AND pursuing_year like '%".$pursuing_year."%'";
            $UpdateExamStatus_query = mysqli_query($con,$UpdateExamStatus);
            /*if($UpdateExamStatus_query == true){
                $data = array(
                    'exam_status' => 'Created',
                    'status' => 'success',
                );
                echo json_encode($data);
            }
            else{
              $data = array(
                'exam_status' => $status,
                'status' => 'failed',
              );
              echo json_encode($data);
            }   */ 
        }
        /* CHANGE THE STATUS OF THE EXAM_PAPER AS PENDING */
        elseif ((($Q_count < $question) || ($Q_count > $question)) && (($status =='Created') || ($status =='Completed') || ($status =='Published'))){
            $UpdateExamStatus2 = "UPDATE exam_paper SET status = 'Pending' WHERE subject like '%".$subject."%' AND class like '%".$class."%' AND pursuing_year like '%".$pursuing_year."%'";
            $UpdateExamStatus_query2 = mysqli_query($con,$UpdateExamStatus2);
            /*if($UpdateExamStatus_query2 == true){
                $data = array(
                    'exam_status' => 'Pending',
                    'status' => 'success',
                );
                echo json_encode($data);
            }
            else{
              $data = array(
                'exam_status' => $status,
                'status' => 'failed',
              );
              echo json_encode($data);
            } */
        }
        /* CHANGE THE STATUS OF THE EXAM_PAPER AS COMPLETED */
        for($r=0;$r<$total_result;$r++)
        {
            if(isset($Result_subject[$r]) && isset($Result_class[$r]) && isset($Result_pursuing_year[$r]))
            {  
                $Rsub = test_input($Result_subject[$r]);
                $Rclass = test_input($Result_class[$r]);
                $Rpy = test_input($Result_pursuing_year[$r]);
                if(($subject == $Rsub) && ($class == $Rclass) && ($pursuing_year == $Rpy) && ($status == 'Created' ))
                {
                    $UpdateExamStatus3 = "UPDATE exam_paper SET status = 'Completed' WHERE subject like '%".$subject."%' AND class like '%".$class."%' AND pursuing_year like '%".$pursuing_year."%'";
                    $UpdateExamStatus_query3 = mysqli_query($con,$UpdateExamStatus3);
                    /*if($UpdateExamStatus_query3 == true){
                        $data = array(
                            'exam_status' => 'completed',
                            'status' => 'success',
                        );
                        echo json_encode($data);
                    }
                    else{
                      $data = array(
                        'exam_status' => $status,
                          'status' => 'failed',
                      );
                      echo json_encode($data);
                    } */
                }
               
            }  
        }
    }
}
}
?>