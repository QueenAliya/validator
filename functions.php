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
function opportunityType($arr) : array {
    $generalArray = [];
    $manyItems = [];
    $oneItem = [];
    foreach ($arr as $arr_value) {
        $arrConvertedLinks = shortLink($arr_value['url']);
        $opportunityDomains[] = $arrConvertedLinks['domain'];
        $opportunityLinks[] = $arrConvertedLinks['link'];
        $counts = array_count_values($opportunityDomains);
        foreach ($opportunityDomains as $key => $value) {
            if (isset($counts[$value]) && $counts[$value] > 1) {
                $manyItems[$value][$key]['url'] = $arr[$key]['url'];
                $manyItems[$value][$key]['short-url'] = $opportunityLinks[$key];
                $manyItems[$value][$key]['totalBytes'] = $arr[$key]['totalBytes'];
                $manyItems[$value][$key]['wastedBytes'] = $arr[$key]['wastedBytes'];
            } else {
                $oneItem[$value]['values']['url'] = $arr[$key]['url'];
                $oneItem[$value]['values']['short-url'] = $opportunityLinks[$key];
                $oneItem[$value]['values']['totalBytes'] = $arr[$key]['totalBytes'];
                $oneItem[$value]['values']['wastedBytes'] = $arr[$key]['wastedBytes'];
            }
        }
    }
    $generalArray = $manyItems + $oneItem;
    return $generalArray;
}

