<?php
require 'session.php';
require 'key.php';

$inputUrl = empty($_POST['link'])? null : $_POST['link'];
// $cleanedUrl = getCleanedUrl($inputUrl);
// function getCleanedUrl($url) {
//     $parsedUrl = parse_url($url);
//     $cleanedUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
//     return $cleanedUrl;
// }
Class ApiFetcher{
    private $key;
    private $url;

    public function __construct($key, $url) {
        $this->key = $key;
        $this->url = $url;
    }
    
    public function getData() {
        $data = [];
        // API для десктопа
        $desktopUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key;
        $rawArray = $this->fetchDataPagespeed($desktopUrl);
        $data['data']['id'] = $rawArray['id'];
        $time = $rawArray['analysisUTCTimestamp'];
        $data['data']['time'] = substr($time, 0, 16);
        $data['pagespeed_desktop_1'] = $this->getActualPerfomance($rawArray);
        $data['pagespeed_desktop_2'] = $this->getPerfomance($rawArray);

        // API для мобилки
        $mobileUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key;
        $rawArray = $this->fetchDataPagespeed($mobileUrl);
        $data['pagespeed_mobile_1'] = $this->getActualPerfomance($rawArray);
        $data['pagespeed_mobile_2'] = $this->getPerfomance($rawArray);

        // валидатор W3C
        $validatorUrl = 'https://validator.w3.org/nu/?out=json&doc=' . urlencode($this->url);
        $data['w3c_validator'] = $this->fetchDataW3($validatorUrl);

        return $data;
    }

    private function getActualPerfomance($array) {
        $loadingExperience = $array['loadingExperience']; 
        $metrics = $loadingExperience['metrics'];
        $generalArray = [];
        $arrayKeys = [
            'LARGEST_CONTENTFUL_PAINT_MS', 
            'INTERACTION_TO_NEXT_PAINT',
            'CUMULATIVE_LAYOUT_SHIFT_SCORE', 
            'FIRST_CONTENTFUL_PAINT_MS', 
            'FIRST_INPUT_DELAY_MS',
            'EXPERIMENTAL_TIME_TO_FIRST_BYTE'
        ];
        
        foreach ($arrayKeys as $key) {
            if(isset($metrics[$key])) {
                $generalArray[$key] = $metrics[$key]['percentile'];
            }
            else{
                $generalArray[$key] = 'no percentile';
            }
        }
        return $generalArray;
    }
    private function getPerfomance($array) {
        $lighthouseResult = $array['lighthouseResult']; 
        $performance = $lighthouseResult['categories']['performance']['score']; 
        $audits = $lighthouseResult['audits'];
        $generalArray = [];
        $arrayKeys = [
            'first-contentful-paint', 
            'largest-contentful-paint',
            'total-blocking-time', 
            'cumulative-layout-shift', 
            'speed-index',
            'server-response-time'
        ];
        foreach ($arrayKeys as $key) {
            if(isset($audits[$key])) {
                $generalArray[$key] = $audits[$key]['numericValue'];
            }
            else{
                $generalArray[$key] = 'no numericValue';
            }
        }
        $generalArray['performance'] =  $performance;
        
        return $generalArray;
    }


    private function fetchDataPagespeed($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if($response === false){
            $error = 'Ошибка cURL: ' . curl_error($ch);
            return ['error' => $error];
        }
        curl_close($ch);
        
        return json_decode($response, true);
    }
    private function fetchDataW3($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36'));
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    public function saveDataToFile($data, $filename) {
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    }
}
if ($inputUrl) {
    $cleanedUrl = filter_var($inputUrl, FILTER_SANITIZE_URL);

    $apiFetcher = new ApiFetcher($key, $cleanedUrl);
    $data = $apiFetcher->getData();
    
    $ses_id = session_id();
    $apiFetcher->saveDataToFile($data, 'responses/' . $ses_id . '.json');
}

