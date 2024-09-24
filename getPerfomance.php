<?php
require_once 'session.php';
require_once 'key.php';

$inputUrl = empty($_POST['link']) ? null : $_POST['link'];

class ApiFetcher {
    private $key;
    private $url;

    public function __construct($key, $url) {
        $this->key = $key;
        $this->url = $url;
    }

    public function getData() {
        $data = [];
        $multiHandle = curl_multi_init();
        $curlHandles = [];
        $rawArray = [];
        $categories = ['ACCESSIBILITY', 'BEST-PRACTICES', 'SEO', 'BASE'];
        
        $requests = [
            'desktop' => [
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key . '&category=ACCESSIBILITY&locale=ru',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key . '&category=BEST-PRACTICES&locale=ru',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key . '&category=SEO&locale=ru',
                // 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key,
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key . '&locale=ru',
            ],
            'mobile' => [
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key  . '&category=ACCESSIBILITY&locale=ru',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key . '&category=BEST-PRACTICES&locale=ru',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key . '&category=SEO&locale=ru',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key . '&locale=ru'
            ],
            'w3c_validator' => [
                'https://validator.w3.org/nu/?out=json&doc=' . urlencode($this->url),
            ]
        ];

        foreach ($requests as $type => $urls) {
            foreach ($urls as $url) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36'));
                $curlHandles[$type][] = $ch; 
                curl_multi_add_handle($multiHandle, $ch);
            }
        }

        do {
            curl_multi_exec($multiHandle, $active);
            curl_multi_select($multiHandle);
        } while ($active);

        foreach ($curlHandles as $type => $handles) {
            $i = 0;
            foreach ($handles as $ch) {
                $response = curl_multi_getcontent($ch);
                $rawArray[$type . '_' . $categories[$i]] = json_decode($response, true);
                if($type=='desktop' || $type=='mobile' ){
                    $data['info'] = $this->getInfo($rawArray, $type);
                    $data[$type]['getActualPerfomance'] = $this->getActualPerfomance($rawArray, $type);
                    $data[$type]['getAccessibility'] = $this->getAccessibility($rawArray, $type);
                    $data[$type]['best-practices'] = $this->getBestPractices($rawArray, $type);
                    $data[$type]['seo'] = $this->getSeo($rawArray, $type);
                    $data[$type]['base'] = $this->getPerfomance($rawArray, $type); 
                } else{
                    $data['test'] ='test1 https://supermarine.ru';    
                }
                curl_multi_remove_handle($multiHandle, $ch);
                curl_close($ch);  
                $i++;
            }
        }
        curl_multi_close($multiHandle);
        return $data;
    }
    private function getInfo($data, $type) {
        $id = $data[$type . '_ACCESSIBILITY']['id']; 
        $analysisUTCTimestamp = $data[$type . '_ACCESSIBILITY']['analysisUTCTimestamp']; 
        $info = [
            "id" => $id,
            "time" => $analysisUTCTimestamp
        ];
        return $info;
    }
    private function getActualPerfomance($data, $type) {
        $generalArray = [];
        if(isset($data[$type . '_ACCESSIBILITY']['loadingExperience'])){

            $loadingExperience = $data[$type . '_ACCESSIBILITY']['loadingExperience']; 
            $metrics = $loadingExperience['metrics'];
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
                    $generalArray[$key] = null;
                }
            }
        } else{
            return null;
        }
        return $generalArray;
    }
    private function getAccessibility($data, $type): mixed {
        $accessibility = empty($data[$type . '_ACCESSIBILITY']['lighthouseResult']['categories']['accessibility']['score']) ? null : $data[$type . '_ACCESSIBILITY']['lighthouseResult']['categories']['accessibility']['score'];
        if (!empty($accessibility)) {
            return $accessibility;
        }
        return null;
    }
    
    private function getBestPractices($data, $type) {
        $best_practices = empty($data[$type . '_BEST-PRACTICES']['lighthouseResult']['categories']['best-practices']['score']) ? null : $data[$type . '_BEST-PRACTICES']['lighthouseResult']['categories']['best-practices']['score'];
        if (!empty($best_practices)) {
            return $best_practices;
        }
        return null; 
    }
    
    private function getSeo($data, $type) {
        $seo = empty($data[$type . '_SEO']['lighthouseResult']['categories']['seo']['score']) ? null : $data[$type . '_SEO']['lighthouseResult']['categories']['seo']['score'];
        if (!empty($seo)) {
            return $seo;
        }
        return null;
    }
    
    private function getPerfomance($data, $type) {
        $generalArray = [];
        if (isset($data[$type . '_BASE']['lighthouseResult'])) {
            $lighthouseResult = $data[$type . '_BASE']['lighthouseResult']; 
            $audits = $lighthouseResult['audits'];
            //показатели с блока "Выявляйте проблемы с производительностью"
            $arrayKeys = [
                'first-contentful-paint', 
                'largest-contentful-paint',
                'total-blocking-time', 
                'cumulative-layout-shift', 
                'speed-index',
                'server-response-time',
            ];
            foreach ($arrayKeys as $key) {
                if (isset($audits[$key])) {
                    $generalArray[$key] = $audits[$key]['numericValue'];
                } else {
                    $generalArray[$key] = null;
                }
            }

            if(isset($audits)) {
                $generalArray['audits-diagnostics'] =  $audits;
            } else {
                $generalArray['audits-diagnostics'] = null;
            }

            //общая производительность
            if(isset($lighthouseResult['categories']['performance']['score'])) {
                $performance = $lighthouseResult['categories']['performance']['score'];
                $generalArray['performance'] =  $performance;
            } else {
                $generalArray['performance'] = null;
            }
            
            //общий скрин
            if(isset($lighthouseResult['fullPageScreenshot'])) {
                $screenshot = $lighthouseResult['fullPageScreenshot']['screenshot']['data'];
                $generalArray['screenshot'] =  $screenshot;
            } else {
                $generalArray['screenshot'] = null;
            }
            
            //скрины загрузки 8 шт дб
            if (isset($audits['final-screenshot']['details']['data'])) {
                $generalArray['final-screenshot'] =  $audits['final-screenshot']['details']['data'];
            } else {
                $generalArray['final-screenshot'] = 'no final screenshot';
            }
            if(isset($audits['screenshot-thumbnails']['details']['items'])){
                for ($i = 0; $i <= count($audits['screenshot-thumbnails']['details']['items']); $i++) {
                    $generalArray['screenshot-thumbnails'][$i] = $audits['screenshot-thumbnails']['details']['items'][$i]['data'];
                }
            } else{
                $generalArray['screenshot-thumbnails'] = null;
            }

        } else {
            return null;
        }
        return $generalArray;
    }
    public function saveDataToFile($data, $filename) {
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    }
}

function validUrl($rawUrl){
    $cleanedUrl = filter_var($rawUrl, FILTER_SANITIZE_URL);
    if (filter_var($cleanedUrl, FILTER_VALIDATE_URL) === false) {
        if (preg_match('/^[a-z0-9.-]+\.[a-z]{2,}$/i', $cleanedUrl)) {
            $cleanedUrl = 'http://' . $cleanedUrl;
        } else {
            throw new Exception("Некорректный URL");
        }
    }
    $cleanedUrl = filter_var($cleanedUrl, FILTER_SANITIZE_URL);

    if (filter_var($cleanedUrl, FILTER_VALIDATE_URL) === false) {
        throw new Exception("URL невалиден: " . $cleanedUrl);
    }
    return $cleanedUrl;
}
if ($inputUrl) {
    $startTime = microtime(true);
    $url = validUrl($inputUrl);

    $apiFetcher = new ApiFetcher($key, $url);
    $data = $apiFetcher->getData();
    
    $ses_id = session_id();
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    $apiFetcher->saveDataToFile($data, 'responses/' . $ses_id . '.json');
    file_put_contents('responses/execTime.txt', $executionTime . PHP_EOL, FILE_APPEND);
}
