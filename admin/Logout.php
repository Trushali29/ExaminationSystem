<?php 
  session_start();
  $_SESSION = array();
  unset($_SESSION['id']);
  unset($_SESSION['username']);
  //session_destroy(); destroy all sessions
  header("location: http://localhost/ExaminationSystem/admin/AdminLogin.php/");
?>
