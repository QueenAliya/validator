<?php
require 'session.php';
require 'key.php';

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
        
        // Формируем URL для различных запросов
        $requests = [
            'desktop' => [
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key . '&category=ACCESSIBILITY',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key . '&category=BEST-PRACTICES',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key . '&category=SEO',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&key=' . $this->key,
            ],
            'mobile' => [
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key  . '&category=ACCESSIBILITY',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key . '&category=BEST-PRACTICES',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key . '&category=SEO',
                'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . urlencode($this->url) . '&strategy=mobile&key=' . $this->key
            ],
            'w3c_validator' => [
                'https://validator.w3.org/nu/?out=json&doc=' . urlencode($this->url),
            ]
        ];

        // Инициализируем и добавляем запросы к многопоточному хэндлу
        foreach ($requests as $type => $urls) {
            foreach ($urls as $url) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36'));
                $curlHandles[$type][] = $ch; // Храним дескрипторы
                curl_multi_add_handle($multiHandle, $ch);
            }
        }

        // Выполняем все запросы одновременно
        do {
            curl_multi_exec($multiHandle, $active);
            curl_multi_select($multiHandle);
        } while ($active);


        // Собираем результаты
        foreach ($curlHandles as $type => $handles) {
            $i = 0;
            foreach ($handles as $ch) {
                $response = curl_multi_getcontent($ch);
                $rawArray[$type . '_' . $categories[$i]][] = json_decode($response, true);
                
                // if($type=='desktop' && $type=='mobile'){
                //     foreach($categories as $category){
                //         switch ($category) {
                //             case 'ACCESSIBILITY':
                //                 $data[$type]['getActualPerfomance'] = $this->getActualPerfomance($rawArray);
                //                 $data[$type]['getAccessibility'] = $this->getAccessibility($rawArray);
                //                 break;
                //             case 'BEST-PRACTICES':
                //                 $data[$type]['best-p'] = $this->getBestPractices($rawArray);
                //                 break;
                //             case 'SEO':
                //                 $data[$type]['seo'] = $this->getSeo($rawArray);
                //                 break;
                //             case 'BASE':
                //                 $data[$type]['base'] = $this->getPerfomance($rawArray);
                //                 break;
                //         }
                //     } 
                // } else{
                //     // return $data[$type];
                // }
                
                curl_multi_remove_handle($multiHandle, $ch);
                curl_close($ch);  
                $i++;
            }
        }

        curl_multi_close($multiHandle);

        // foreach ($rawArray as $key =>$value){
        //     // Обработка данных из ответов
        //     foreach($categories as $category){

        //         switch ($category) {
        //             case 'ACCESSIBILITY':
        //                 $data[$key]['getActualPerfomance'] = $this->getActualPerfomance($rawArray);
        //                 $data[$key]['getAccessibility'] = $this->getAccessibility($rawArray);
        //                 break;
        //             case 'BEST-PRACTICES':
        //                 $data[$key]['best-p'] = $this->getBestPractices($rawArray);
        //                 break;
        //             case 'SEO':
        //                 $data[$key]['seo'] = $this->getSeo($rawArray);
        //                 break;
        //             case 'BASE':
        //                 $data[$key]['base'] = $this->getPerfomance($rawArray);
        //                 break;
        //         }

                
        //     } 
        // }
       
        // $data['1'] = $this->getActualPerfomance($rawArray);
        // $data['2'] = $this->getAccessibility($rawArray);
        // $data['3'] = $this->getBestPractices($rawArray);
        // $data['4'] = $this->getSeo($rawArray);
        // $data['5'] = $this->getPerfomance($rawArray);  
        $rawArray = $this->getAccessibility($rawArray);
        return $rawArray;
    }
    // private function processResponses($data) {
    //     // $data = $this->getActualPerfomance($data);
    //     $data = $this->getAccessibility($data);
    //     return $data;
    // }
    private function getActualPerfomance($data) {
        $generalArray = [];
        $loadingExperience = $data['desktop'][0]['loadingExperience']; 
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
                $generalArray[$key] = 'no percentile';
            }
        }
        return $generalArray;
    }
    private function getAccessibility($data) {
        $lighthouseResult = $data[0]['lighthouseResult']; 
        $accessibility = $lighthouseResult['categories']['accessibility']['score']; 
        return $accessibility;
    }

    private function getBestPractices($data) {
        $lighthouseResult = $data['desktopBEST-PRACTICES']['lighthouseResult']; 
        $best_practices = $lighthouseResult['categories']['best-practices']['score']; 
        return $best_practices;
    }
    private function getSeo($data) {
        $lighthouseResult = $data['desktop'][2]['lighthouseResult']; 
        $seo = $lighthouseResult['categories']['seo']['score']; 
        return $seo;
    }
    private function getPerfomance($data) {
        $generalArray = [];
        $lighthouseResult =  $data['desktop'][3]['lighthouseResult']; 
        $audits = $lighthouseResult['audits'];
        $arrayKeys = [
            'first-contentful-paint', 
            'largest-contentful-paint',
            'total-blocking-time', 
            'cumulative-layout-shift', 
            'speed-index',
            'server-response-time',
        ];
        foreach ($arrayKeys as $key) {
            if(isset($audits[$key])) {
                $generalArray[$key] = $audits[$key]['numericValue'];
            }
            else{
                $generalArray[$key] = 'no numericValue';
            }
        }
        $performance = $lighthouseResult['categories']['performance']['score'];
        $finalScreenshot = $audits['final-screenshot']['details']['data'];
        $generalArray['performance'] =  $performance;
        $generalArray['final-screenshot'] =  $finalScreenshot;
        return $generalArray;
    }
    public function saveDataToFile($data, $filename) {
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    }
}

if ($inputUrl) {
    $startTime = microtime(true);
    $cleanedUrl = filter_var($inputUrl, FILTER_SANITIZE_URL);

    $apiFetcher = new ApiFetcher($key, $cleanedUrl);
    $data = $apiFetcher->getData();
    
    $ses_id = session_id();
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    file_put_contents('responses/execTime.txt', $executionTime);
    $apiFetcher->saveDataToFile($data, 'responses/' . $ses_id . '.json');
}
