<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        <?php include '../css/exam_process.css';
        ?>
    </style>
</head>
<body>
    <div class="container-fluid" id="container">
        <div class="panel">
            <div class="panel-heading">
                <h4>Subject: IOT</h4>
                <div id="exam_timer">
                    <p id="hours"></p>
                    <p id="mins"></p>
                    <p id="secs"></p>
                    <h2 id="end"></h2>
                </div>
            </div>
            <div class="panel-body" id="Question_Options">
                <div class="radio">
                    <p>Q1.What is the fullform of php?</p>
                    <label for="option1">
                        <input type="radio" id="option1"/>Hypertext Preprocessor
                    </label><br>
                    <label for="option1">
                        <input type="radio" id="option2"/>Pretext Hypertext Preprocessor
                    </label><br>
                    <label for="option1">
                        <input type="radio" id="option3"/>Personal Home Processor
                    </label><br>
                    <label for="option1">
                        <input type="radio" id="option4"/>None of the above
                    </label>
                </div>
            </div>
            <ul id="pagination">
                <li><button class="btn " href="#">Previous</button></li>
                <li><button class="btn " href="#">Next</button></li>
            </ul>
        </div>
    </div>
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        // The data/time we want to countdown to
        //var countDownDate = new Date('JAN 27, 2022 16:37:52').getTime();
        //console.log(countDownDate);

        // Run myfunc every second
        var CurrentTime = new Date().getTime();
        var timer = AddMinutesToDate(CurrentTime,3);
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
                document.getElementById("end").innerHTML = "TIME UP!!";
            }
        }, 1000);        
    </script>
    
</body>
</html>