<?
require 'session.php';
// $ses_id = session_id();
// $json_response_file = 'responses/' . $ses_id. '.json';
// echo $json_response_file;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validator_VBI</title>
    <style>
        .response{
            width: 100%;
            height: 100%;
            background-color: #E0FFFF;
            color: black;
        }
    </style>
</head>
<body>
    <form  method="POST" action="/send.php">
        <input type="text" name="link" id="link">
        <button type="submit">Отправить</button>
    </form> 
    <div id="error"></div>
    <div class="response">
    <?php
        $ses_id = session_id();
        $json_response_file = 'responses/' . $ses_id. '.json';
        $data = [];

        function showResult($data){
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
        }
        if(file_exists($json_response_file)) {
            $json_response = file_get_contents($json_response_file); 
            $data = json_decode($json_response, true);
        }
        if ($data) {
            showResult($data);
            // echo 'id - ' . $data['id'] . '<br>';
            // echo 'time - ' . $data['time'] . '<br>';
            // echo 'strategy - ' . $data['strategy'] . '<br>';
            // echo 'total-blocking-time - ' . $data['total-blocking-time'] . '<br>';
            // echo 'largest-contentful-paint - ' . $data['largest-contentful-paint'] . '<br>';
            // echo 'cumulative-layout-shift - ' . $data['cumulative-layout-shift'] . '<br>';
            // echo 'first-contentful-paint - ' . $data['first-contentful-paint'] . '<br>';
            // echo 'first-input-delay - ' . $data['first-input-delay'] . '<br>';
            // echo 'server-response-time - ' . $data['server-response-time'] . '<br>';
            // echo 'speed-index - ' . $data['speed-index'] . '<br>';
            // echo 'time-to-interactive - ' . $data['time-to-interactive'] . '<br>';
            // echo 'first-meaningful-paint - ' . $data['first-meaningful-paint'] . '<br>';
            // echo 'first-cpu-idle - ' . $data['first-cpu-idle'] . '<br>';
            // echo 'estimated-input-latency - ' . $data['estimated-input-latency'] . '<br><br><br>';
            // foreach ($data['messages'] as $message) {
            //     echo "Info: {$message['message']}<br><br>";
            //     echo "From line {$message['lastLine']}, column {$message['firstColumn']}; to line {$message['lastLine']}, column {$message['lastColumn']}<br><br>";
            //     // echo "Extract: {$message['extract']}<br><br>";
            //     echo "Extract: " . htmlspecialchars($message['extract']) . "<br><br>";
            // }
        } else {
            echo 'Отправьте сайт на проверку';
        }
        
    ?>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $("form").submit(function () {
    var form = $(this);
    var error = false;
    if (!error) {
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "/send.php",
            dataType: "html",
            data: data,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            beforeSend: function(data) {
                $('.response').html('подождите...запрос обрабатывается')
            },
            success: function(data) {
            },
            complete: function (data) {
                //showResult(data);
                $('.response').load('responses/<?php echo $ses_id; ?>.json', function() {
                    console.log('Данные успешно загружены');
                });
            },
        });
    }
    return false;
    }); 
</script>
</html>