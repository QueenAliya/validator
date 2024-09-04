<?php
require 'session.php';

$link = empty($_POST['link'])? null : $_POST['link'];
$key = 'key';

if (!empty($link)) {
    $user_url = $link;
    $Ps_ApiDesktop = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . $user_url . '&key=' .$key;
    $Ps_ApiMobile = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . $user_url . '&strategy=mobile&key=' . $key;
    $Ps_CurlDesktop = curl_init();
    $Ps_CurlMobile = curl_init();

    curl_setopt($Ps_CurlDesktop, CURLOPT_URL, $Ps_ApiDesktop);
    curl_setopt($Ps_CurlDesktop, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($Ps_CurlMobile, CURLOPT_URL, $Ps_ApiMobile);
    curl_setopt($Ps_CurlMobile, CURLOPT_RETURNTRANSFER, true);

    $Ps_ResponseDesktop = curl_exec($Ps_CurlDesktop);
    $Ps_ResponseMobile = curl_exec($Ps_CurlMobile);

    if($Ps_ResponseDesktop === false){
        $errorDesktop = 'Ошибка cURL: ' . curl_error($Ps_CurlDesktop);
    }
    if($Ps_ResponseMobile === false){
        $errorMobile = 'Ошибка cURL: ' . curl_error($Ps_CurlMobile);
    }
    $errors = $errorDesktop . $errorMobile;
    curl_close($Ps_CurlDesktop);
    curl_close($Ps_CurlMobile);
    
    $json_ps_desktop = json_decode($Ps_ResponseDesktop, true);
    $json_ps_mobile = json_decode($Ps_ResponseMobile, true);
    
    // $id_desktop = $json_ps_desktop['id']; 
    $lighthouseResult_desktop = $json_ps_desktop['lighthouseResult']; 
    $audits_desktop = $lighthouseResult_desktop['audits'];
    // $test1 = array_merge($kind_desktop, $audits_desktop);
    
    
    // $id_mobile = $json_ps_mobile['id']; 
    $lighthouseResult_mobile = $json_ps_mobile['lighthouseResult']; 
    $audits_mobile = $lighthouseResult_mobile['audits'];
    // $test2 = array_merge($kind_mobile, $audits_mobile);
    
    // $id =  $json_ps_desktop['id'];
    // $time =  $json_ps_desktop['analysisUTCTimestamp'];
    // $time =  substr($time, 0, 16);
    
    // $data = [ 'id' => $id, 'time' => $time ];

   

    

    $links = ['total-blocking-time', 'largest-contentful-paint', 'cumulative-layout-shift', 'first-contentful-paint', 'first-input-delay', 'server-response-time', 'speed-index', 'time-to-interactive', 'first-meaningful-paint', 'first-cpu-idle', 'estimated-input-latency'];
    $combinedData_desktop = [];
    foreach ($links as $link) {
        if(isset($audits_desktop[$link])) {
            $combinedData_desktop[$link] = $audits_desktop[$link]['displayValue'];
        }
        else{
            $combinedData_desktop[$link] = 'no data desktop1';
        }
    }
    $combinedData_mobile = [];
    foreach ($links as $link) {
        // if($combinedData_mobile[$link] == 'strategy'){
        //     $combinedData_mobile[$link] = 'MOBILE';
        // }
        if(isset($audits_mobile[$link])) {
            $combinedData_mobile[$link] = $audits_mobile[$link]['displayValue'];
        }
        else {
            $combinedData_mobile[$link] = 'no data - mobile';
        }
    }
    $array_merged = ['desktop' => $combinedData_desktop, 'mobile' => $combinedData_mobile];
    
    $url_v3 = 'https://validator.w3.org/nu/?out=json&doc=' . urlencode($user_url);
    $curl_v3 = curl_init();
    curl_setopt($curl_v3, CURLOPT_URL, $url_v3);
    curl_setopt($curl_v3, CURLOPT_RETURNTRANSFER, true);

    // // Позволяет следовать за перенаправлениями
    curl_setopt($curl_v3, CURLOPT_FOLLOWLOCATION, true);
    // Добавляем заголовок User-Agent
    curl_setopt($curl_v3, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36'));

    $response_v3 = curl_exec($curl_v3);
    if($response_v3 === false){
        echo 'Ошибка cURL: ' . curl_error($curl_v3);
    }
    curl_close($curl_v3);
    $response_v3 = mb_convert_encoding($response_v3, 'UTF-8', 'UTF-8');
    $json_response_v3 = json_decode($response_v3, true); // Используйте true для ассоциативного массива
    if (json_last_error() !== JSON_ERROR_NONE) {
        $json_response_v3 = json_last_error_msg();
    }

    $mergedData = array_merge($array_merged, $json_response_v3);
    
    
    $ses_id = session_id();
    file_put_contents('responses/' . $ses_id . '.json', json_encode($mergedData, JSON_PRETTY_PRINT));
    file_put_contents('responses/errors.txt', $errors);

    exit();
}
