<?php 
  session_start();
  $_SESSION = array();
  unset($_SESSION['student_id']);
  unset($_SESSION['fullname']);
  //session_destroy();
  header("location: http://localhost/ExaminationSystem/admin/StudentLogin.php");
?>
