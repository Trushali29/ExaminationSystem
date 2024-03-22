<?php
// creatiing a connection file
// username = root and password = ''

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'examinationsystem');
define('DB_PORT','3308');

// Try connecting to database
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE,DB_PORT);
// check the connection
/*if( $conn == false){
    die('Connection Failed');
}
else{
    echo 'Connection Successful';
} */

 ?>


