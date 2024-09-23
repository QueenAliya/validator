<? 
$ses_id = session_id();
$json_response_file = 'responses/' . $ses_id. '.json';
$data = '';
if(file_exists($json_response_file)) {
    $json_response = file_get_contents($json_response_file); 
    $data = json_decode($json_response, true);
}
function roundToSec($number){
    if(!$number==null){
        return round(($number/1000), 1);
    } else{
        return null;
    }

}
function convertToCapured($time){
    $date = new DateTime($time);
    $date->setTimezone(new DateTimeZone('Europe/Moscow'));
    $formattedDate = $date->format('j M Y \г., H:i') . ' GMT+3';
    $formatter = new IntlDateFormatter(
        'ru_RU',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE
    );
    $ruMonth = $formatter->format($date);
    $formattedDate = str_replace($ruMonth, mb_substr($ruMonth, 0, 3, "UTF-8"), $formattedDate);
    return $formattedDate;
}
function kibToMiB($kib) {
    return round($kib / 1024, 0);
}
function shortLink($link) {
    $parts = explode('/', $link);
    $domain = $parts[2];
    if (count($parts) >= 3) {
        $part = '../' . implode('/', array_slice($parts, 3, 3));
    } elseif (count($parts) === 2) {
         $part = '../' . end($parts);
    } elseif (count($parts) === 1) {
         $part = '../' . $parts[0];
    } 
    $convertedLink = (strlen($part) > 45) ? substr($part, 0, 20) . '...' : $part;
    $result = [
        'link' => $convertedLink,
        'domain' => $domain
    ];
    return $result;
}

function pre($arr){
    echo '<pre>';
    var_dump(($arr));
    echo '</pre>';
}

// audit giagnostics -> type = opportunity
// function opportunityType($arr) : array {
//     $opportunityDomains = [];
//     foreach ($arr as $item){
//         $arrConvdertedLinks = shortLink($item['url']);
//         $opportunityDomains[] = $arrConvdertedLinks['domain'];
//     }
//     $uniqueOpportunityDomains = array_unique($opportunityDomains);
//     return $uniqueOpportunityDomains;
    
// }
function opportunityType($arr) : array {
    $generalArray = [];
    foreach ($arr as  $arr_key => $arr_value) {
        $arrConvertedLinks = shortLink($arr_value['url']);
        $opportunityDomains[] = $arrConvertedLinks['domain'];
        // $opportunityDomains[$key]['totalBytes'] = $value['totalBytes'];
        // $opportunityDomains[$key]['wastedBytes'] = $value['wastedBytes'];
    }
    $counts = array_count_values($opportunityDomains);
    foreach ($opportunityDomains as $key => $value) {
        if (isset($counts[$value]) && $counts[$value] > 1) {
            array_push($generalArray, $arr_value['totalBytes']);
            // $generalArray[$value] = $arr_value['totalBytes'] . "встречается больше 1 раза.";
        } else {
            array_push($generalArray, $arr_value['totalBytes']);
            // $generalArray[$value] = $arr_value['totalBytes'] . "встречается 1 раз или не встречается вовсе.";
        }
    }


    

    // $uniqueDomains = array_unique($opportunityDomains);
    return $generalArray;
}

