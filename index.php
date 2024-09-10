<?
require 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/front/style.css">
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
    <div class="response">
    <?php
        $ses_id = session_id();
        $json_response_file = 'responses/' . $ses_id. '.json';
        $data = '';

        if(file_exists($json_response_file)) {
            $json_response = file_get_contents($json_response_file); 
            $data = json_decode($json_response, true);
        }
        if ($data) {
            echo 'id - ' . $data['data']['id'] . '<br>';
            echo 'time - ' . $data['data']['time'] . '<br>';
            echo 'performance - ' . $data['pagespeed_desktop_2']['first-performance'] . '<br>';
            echo 'first-contentful-paint - ' . $data['pagespeed_desktop_2']['first-contentful-paint'] . '<br>';
            echo 'largest-contentful-paint - ' . $data['pagespeed_desktop_2']['largest-contentful-paint'] . '<br>';
            echo 'total-blocking-time - ' . $data['pagespeed_desktop_2']['total-blocking-time'] . '<br>';
            echo 'cumulative-layout-shift - ' . $data['pagespeed_desktop_2']['cumulative-layout-shift'] . '<br>';
            echo 'server-response-time - ' . $data['pagespeed_desktop_2']['server-response-time'] . '<br>';
            echo 'speed-index - ' . $data['pagespeed_desktop_2']['speed-index'] . '<br>';
            // foreach ($data['w3c_validator']['messages'] as $message) {
            //     echo "Info: {$message['message']}<br><br>";
            //     echo "From line {$message['lastLine']}, column {$message['firstColumn']}; to line {$message['lastLine']}, column {$message['lastColumn']}<br><br>";
            //     echo "Extract: " . htmlspecialchars($message['extract']) . "<br><br>";
            // }
        } else {
            echo 'Отправьте сайт на проверку';
        }
        
        function roundToSec($number){
            return round(($number/1000), 1);
        }
    ?>
    </div>



    <section class="reports-top">
        <div class="container">
            <form id="form" method="POST" action="send.php">
            <input type="text" name="link" id="link" placeholder="введите url" required>
            <button type="submit">Отправить</button>
            </form> 
            <div id="error"></div>

            <div class="reports-top-main">
                <h1>Отчёт о производительности сайта</h1>
                <div class="reports-top-wrap">
                    <div class="reports-top-block">
                        <p>Сайт:</p>
                        <div class="reports-top-block-btn">
                            <a href="<?=$data['data']['id'] ?>" target="_blank"><?=$data['data']['id'] ?></a>
                        </div>
                    </div>
                    <div class="reports-top-block">
                        <p>Дата:</p>
                        <div class="reports-top-block-btn">
                            <p><?= date("d.m.Y", strtotime($data['data']['time']));?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="site-perfomance">
        <div class="container">
            <div class="site-perfomance-wrap">
                <h2>Фактическая производительность сайта</h2>
                <div class="site-perfomance-block-btns">
                    <div class="site-perfomance-block-btn tabs-item--js active" data-thumb="site-perfomance-tab-1">
                        <button>Мобильные устройства</button>
                        <svg width="17" height="26" viewBox="0 0 17 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.1212 1.09999H4.0303C2.803 1.09999 1.80808 2.08496 1.80808 3.29999V22.3C1.80808 23.515 2.803 24.5 4.0303 24.5H13.1212C14.3485 24.5 15.3434 23.515 15.3434 22.3V3.29999C15.3434 2.08496 14.3485 1.09999 13.1212 1.09999ZM4.0303 0.299988C2.35671 0.299988 1 1.64313 1 3.29999V22.3C1 23.9568 2.35671 25.3 4.0303 25.3H13.1212C14.7948 25.3 16.1515 23.9568 16.1515 22.3V3.29999C16.1515 1.64313 14.7948 0.299988 13.1212 0.299988H4.0303Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.1214 1.4H4.0305C2.96603 1.4 2.10828 2.25349 2.10828 3.3V22.3C2.10828 23.3465 2.96603 24.2 4.0305 24.2H13.1214C14.1859 24.2 15.0436 23.3465 15.0436 22.3V3.3C15.0436 2.25349 14.1859 1.4 13.1214 1.4ZM0.700195 3.3C0.700195 1.47462 2.19407 0 4.0305 0H13.1214C14.9578 0 16.4517 1.47462 16.4517 3.3V22.3C16.4517 24.1254 14.9578 25.6 13.1214 25.6H4.0305C2.19407 25.6 0.700195 24.1254 0.700195 22.3V3.3ZM4.0305 1.1H13.1214C14.3487 1.1 15.3436 2.08497 15.3436 3.3V22.3C15.3436 23.515 14.3487 24.5 13.1214 24.5H4.0305C2.8032 24.5 1.80828 23.515 1.80828 22.3V3.3C1.80828 2.08497 2.8032 1.1 4.0305 1.1ZM1.0002 3.3C1.0002 1.64315 2.35691 0.3 4.0305 0.3H13.1214C14.795 0.3 16.1517 1.64315 16.1517 3.3V22.3C16.1517 23.9569 14.795 25.3 13.1214 25.3H4.0305C2.35691 25.3 1.0002 23.9569 1.0002 22.3V3.3Z"
                                fill="black" />
                            <path
                                d="M6.30322 3.57276C6.30322 3.15436 6.69893 2.81519 7.18706 2.81519H10.7224C11.2105 2.81519 11.6063 3.15436 11.6063 3.57276C11.6063 3.99116 11.2105 4.33034 10.7224 4.33034H7.18706C6.69893 4.33034 6.30322 3.99116 6.30322 3.57276Z"
                                fill="black" />
                            <path
                                d="M4.03027 22.0273C4.03027 21.6089 4.34522 21.2697 4.73374 21.2697H13.1753C13.5638 21.2697 13.8788 21.6089 13.8788 22.0273C13.8788 22.4457 13.5638 22.7849 13.1753 22.7849H4.73374C4.34523 22.7849 4.03027 22.4457 4.03027 22.0273Z"
                                fill="black" />
                        </svg>
                    </div>
                    <div class="site-perfomance-block-btn tabs-item--js" data-thumb="site-perfomance-tab-2">
                        <button>Компьютер</button>
                        <svg width="27" height="22" viewBox="0 0 27 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.67059 4.32624L1.65933 14.387C1.65781 15.7452 2.6531 16.8474 3.88238 16.8488L23.1052 16.8703C24.3345 16.8717 25.3322 15.7717 25.3338 14.4135L25.345 4.35275C25.3466 2.99452 24.3513 1.89234 23.122 1.89096L3.89915 1.86944C2.66987 1.86806 1.67212 2.96801 1.67059 4.32624ZM0.849946 14.3861C0.847873 16.2382 2.20509 17.7412 3.88138 17.7431L23.1042 17.7646C24.7805 17.7665 26.1411 16.2666 26.1431 14.4144L26.1544 4.35366C26.1565 2.50152 24.7993 0.998548 23.123 0.996671L3.90015 0.975146C2.22387 0.973269 0.863286 2.4732 0.861212 4.32534L0.849946 14.3861Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.97064 4.3266L1.95937 14.3874C1.958 15.6088 2.84662 16.5477 3.88276 16.5488L23.1056 16.5703C24.1417 16.5715 25.0324 15.6346 25.0338 14.4132L25.0451 4.35243C25.0464 3.13103 24.1578 2.19214 23.1217 2.19098L3.89886 2.16946C2.86272 2.1683 1.972 3.10519 1.97064 4.3266ZM3.88108 18.0431C2.01165 18.041 0.547762 16.3747 0.549989 14.3858L0.561255 4.32502C0.563482 2.33606 2.0311 0.673074 3.90053 0.675167L23.1234 0.696691C24.9928 0.698784 26.4567 2.36505 26.4545 4.35401L26.4432 14.4148C26.441 16.4037 24.9733 18.0667 23.1039 18.0646L3.88108 18.0431ZM1.65937 14.387L1.67064 4.32626C1.67216 2.96803 2.66992 1.86808 3.89919 1.86946L23.122 1.89098C24.3513 1.89236 25.3466 2.99454 25.3451 4.35277L25.3338 14.4135C25.3323 15.7718 24.3345 16.8717 23.1053 16.8703L3.88242 16.8488C2.65314 16.8474 1.65785 15.7453 1.65937 14.387ZM3.88142 17.7431C2.20513 17.7412 0.847915 16.2383 0.849989 14.3861L0.861254 4.32535C0.863328 2.47322 2.22391 0.973289 3.90019 0.975166L23.123 0.99669C24.7993 0.998567 26.1565 2.50154 26.1545 4.35368L26.1432 14.4144C26.1411 16.2666 24.7805 17.7665 23.1043 17.7646L3.88142 17.7431Z"
                                fill="black" />
                            <path
                                d="M0.767616 20.6008C0.768134 20.1378 1.0872 19.7628 1.48027 19.7632L25.1968 19.7898C25.5899 19.7902 25.9081 20.166 25.9076 20.629C25.9071 21.092 25.588 21.467 25.195 21.4666L1.47839 21.44C1.08532 21.4396 0.767097 21.0639 0.767616 20.6008Z"
                                fill="black" />
                        </svg>
                    </div>
                </div>
                <div class="site-perfomance-block tabs-block--js active" data-thumb="site-perfomance-tab-1">
                    <div class="site-perfomance-block-one">
                        <div class="site-perfomance-block-title">
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="30" cy="30" r="30" fill="#FF5A13" fill-opacity="0.25" />
                                <path
                                    d="M5 29.5H10.5834C10.7231 29.5 10.8565 29.4415 10.9512 29.3387L13.6585 26.3993C13.8566 26.1843 14.196 26.1843 14.3941 26.3993L17.1015 29.3387C17.1961 29.4415 17.3295 29.5 17.4692 29.5H22.2073C22.3361 29.5 22.4598 29.4504 22.5529 29.3614L24.1251 27.8584C24.3299 27.6626 24.6563 27.676 24.8444 27.8878L26.1271 29.332C26.222 29.4389 26.3581 29.5 26.501 29.5H33.2174C33.3159 29.5 33.4122 29.5291 33.4942 29.5836L37.6048 32.316C37.7725 32.4275 37.9907 32.4275 38.1584 32.316L42.269 29.5836C42.351 29.5291 42.4473 29.5 42.5458 29.5H54"
                                    stroke="#FF5A13" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <p>Оценка основных интернет-показателей: <span>проверка не пройдена</span></p>
                        </div>
                        <button class="site-perfomance-block-open">Развернуть</button>
                        <div class="site-perfomance-block-info">
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                    </svg>
                                    <a href="javascript:void(0);">Largest Contentful Paint (LCP)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item"><?=roundToSec($data['pagespeed_mobile_1']['LARGEST_CONTENTFUL_PAINT_MS'])?>
                                                    сек.</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 0.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2844;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS">
                                        <img src="./front/pic/red-svg.svg" style="width: 16px; height: 16px;">
                                    </span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 2,5 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (2,5 сек. – 4 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 4 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">35%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">37%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                    </svg>
                                    <a href="javascript:void(0);">Interaction to Next Paint (INP)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item"><?=$data['pagespeed_mobile_1']['INTERACTION_TO_NEXT_PAINT']?>
                                                    мс</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 0.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2844;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/red-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 200 мс)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (200 мс -- 500 мс)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (>500 мс)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">47%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">23%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">30%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="4" cy="4" r="4" fill="#0CCE6A" />
                                    </svg>
                                    <a href="javascript:void(0);">Cumulative Layout Shift (CLS)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item green"><?=$data['pagespeed_mobile_1']['CUMULATIVE_LAYOUT_SHIFT_SCORE']?></span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 5.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2244;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/green-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 0,1)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (0,1 -- 0,25)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 0,25)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">91%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">3%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">7%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="site-perfomance-block-open-big">ДРУГИЕ ПОКАЗАТЕЛИ, ЗАСЛУЖИВАЮЩИЕ ВНИМАНИЯ</p>
                        <div class="site-perfomance-block-info-second">
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                    </svg>
                                    <a href="javascript:void(0);">First Contentful Paint (FCP)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item"><?=roundToSec($data['pagespeed_mobile_1']['FIRST_CONTENTFUL_PAINT_MS'])?>
                                                    сек.</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 0.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2844;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/red-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 1,8 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (1,8 сек. – 3 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 3 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">45%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">27%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="9" height="9" viewBox="0 0 9 9" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect y="4.43933" width="6.27817" height="6.27817"
                                            transform="rotate(-45 0 4.43933)" fill="#D9D9D9" />
                                    </svg>
                                    <a href="javascript:void(0);">First Input Delay (FID)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item grey"><?=$data['pagespeed_mobile_1']['FIRST_INPUT_DELAY_MS']?> мс</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 5.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2244;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/grey-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 2,5 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (2,5 сек. – 4 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 4 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">35%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">37%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="8" height="7" viewBox="0 0 8 7" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.861328" y="0.517456" width="6.27817" height="6.27817"
                                            fill="#FFA400" />
                                    </svg>
                                    <a href="javascript:void(0);">Time to First Byte (TTFB)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item yellow"><?=roundToSec($data['pagespeed_mobile_1']['EXPERIMENTAL_TIME_TO_FIRST_BYTE'])?>
                                                    сек.</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 5.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2244;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/yellow-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 2,5 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (2,5 сек. – 4 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 4 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">35%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">37%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="site-perfomance-block-grey">
                        <div class="site-perfomance-block-grey-item">
                            <svg width="11" height="10" viewBox="0 0 11 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.95238 1.85706H1.04762C0.758327 1.85706 0.52381 2.09158 0.52381 2.38087V8.66659C0.52381 8.95588 0.758327 9.1904 1.04762 9.1904H9.95238C10.2417 9.1904 10.4762 8.95588 10.4762 8.66659V2.38087C10.4762 2.09158 10.2417 1.85706 9.95238 1.85706ZM1.04762 1.33325C0.469035 1.33325 0 1.80229 0 2.38087V8.66659C0 9.24517 0.469035 9.7142 1.04762 9.7142H9.95238C10.531 9.7142 11 9.24517 11 8.66659V2.38087C11 1.80229 10.531 1.33325 9.95238 1.33325H1.04762Z"
                                    fill="black" />
                                <path
                                    d="M0 2.38087C0 1.80229 0.469035 1.33325 1.04762 1.33325H9.95238C10.531 1.33325 11 1.80229 11 2.38087V2.90468C11 3.48326 10.531 3.9523 9.95238 3.9523H1.04762C0.469035 3.9523 0 3.48326 0 2.90468V2.38087Z"
                                    fill="black" />
                                <path
                                    d="M2.09521 1.07136C2.09521 0.637421 2.44699 0.285645 2.88093 0.285645C3.31487 0.285645 3.66664 0.637421 3.66664 1.07136V2.11898C3.66664 2.55292 3.31487 2.90469 2.88093 2.90469C2.44699 2.90469 2.09521 2.55292 2.09521 2.11898V1.07136Z"
                                    fill="black" />
                                <path
                                    d="M7.3335 1.07136C7.3335 0.637421 7.68527 0.285645 8.11921 0.285645C8.55315 0.285645 8.90492 0.637421 8.90492 1.07136V2.11898C8.90492 2.55292 8.55315 2.90469 8.11921 2.90469C7.68527 2.90469 7.3335 2.55292 7.3335 2.11898V1.07136Z"
                                    fill="black" />
                            </svg>
                            <p>Данные за последние 28 дней</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.55191 0.713065H1.59928C1.06566 0.713065 0.633083 1.14132 0.633083 1.6696V9.93059C0.633083 10.4589 1.06566 10.8871 1.59928 10.8871H5.55191C6.08552 10.8871 6.5181 10.4589 6.5181 9.93059V1.6696C6.5181 1.14132 6.08552 0.713065 5.55191 0.713065ZM1.59928 0.365234C0.871622 0.365234 0.281738 0.949219 0.281738 1.6696V9.93059C0.281738 10.651 0.871622 11.235 1.59928 11.235H5.55191C6.27957 11.235 6.86945 10.651 6.86945 9.93059V1.6696C6.86945 0.949219 6.27957 0.365234 5.55191 0.365234H1.59928Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.55197 0.843568H1.59935C1.13653 0.843568 0.763585 1.21466 0.763585 1.66967V9.93065C0.763585 10.3857 1.13653 10.7568 1.59935 10.7568H5.55197C6.01479 10.7568 6.38773 10.3857 6.38773 9.93065V1.66967C6.38773 1.21466 6.01479 0.843568 5.55197 0.843568ZM0.151367 1.66967C0.151367 0.876014 0.800888 0.234863 1.59935 0.234863H5.55197C6.35043 0.234863 6.99995 0.876014 6.99995 1.66967V9.93065C6.99995 10.7243 6.35043 11.3655 5.55197 11.3655H1.59935C0.800888 11.3655 0.151367 10.7243 0.151367 9.93065V1.66967ZM1.59935 0.713131H5.55197C6.08559 0.713131 6.51817 1.14139 6.51817 1.66967V9.93065C6.51817 10.4589 6.08559 10.8872 5.55197 10.8872H1.59935C1.06573 10.8872 0.633148 10.4589 0.633148 9.93065V1.66967C0.633148 1.14139 1.06573 0.713131 1.59935 0.713131ZM0.281804 1.66967C0.281804 0.949285 0.871688 0.3653 1.59935 0.3653H5.55197C6.27963 0.3653 6.86951 0.949285 6.86951 1.66967V9.93065C6.86951 10.651 6.27963 11.235 5.55197 11.235H1.59935C0.871687 11.235 0.281804 10.651 0.281804 9.93065V1.66967Z"
                                    fill="black" />
                                <path
                                    d="M2.5874 1.78837C2.5874 1.60646 2.75945 1.45898 2.97169 1.45898H4.50882C4.72105 1.45898 4.8931 1.60646 4.8931 1.78837C4.8931 1.97028 4.72105 2.11776 4.50882 2.11776H2.97169C2.75945 2.11776 2.5874 1.97028 2.5874 1.78837Z"
                                    fill="black" />
                                <path
                                    d="M1.59912 9.81205C1.59912 9.63014 1.73606 9.48267 1.90498 9.48267H5.57527C5.74419 9.48267 5.88113 9.63014 5.88113 9.81205C5.88113 9.99397 5.74419 10.1414 5.57527 10.1414H1.90498C1.73606 10.1414 1.59912 9.99397 1.59912 9.81205Z"
                                    fill="black" />
                            </svg>
                            <p>Мобильные устройства</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M1.51641 3.43856C1.08424 4.19341 0.837209 5.06786 0.837209 6C0.837209 8.62891 2.80211 10.7989 5.34342 11.1214C5.34601 11.1161 5.34871 11.1107 5.35154 11.1054L6.71205 8.55445C6.48547 8.61748 6.24667 8.65116 6 8.65116C5.02714 8.65116 4.17667 8.12715 3.71544 7.34598C3.71026 7.33807 3.70531 7.32994 3.70061 7.32158L1.51641 3.43856ZM2.04862 2.67702L3.47028 5.20442C3.80818 4.12893 4.81299 3.34884 6 3.34884C6.0067 3.34884 6.01339 3.34886 6.02007 3.34891H10.4311C9.52889 1.84426 7.88205 0.837209 6 0.837209C4.41436 0.837209 2.99567 1.55204 2.04862 2.67702ZM10.8352 4.18612H7.93353C8.37858 4.66034 8.65116 5.29834 8.65116 6C8.65116 6.43315 8.54729 6.84205 8.36308 7.20312C8.35511 7.24068 8.34179 7.27777 8.32281 7.31334L6.27358 11.1557C8.99773 11.0134 11.1628 8.75956 11.1628 6C11.1628 5.36169 11.047 4.75044 10.8352 4.18612ZM5.99279 4.18606C5.99518 4.1861 5.99757 4.18612 5.99997 4.18612H6.0166C7.01078 4.19503 7.81395 5.00372 7.81395 6C7.81395 7.00182 7.00182 7.81395 6 7.81395C4.99818 7.81395 4.18605 7.00182 4.18605 6C4.18605 5.00059 4.99429 4.18995 5.99279 4.18606ZM0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6Z"
                                    fill="black" />
                            </svg>
                            <p>Данные всех версий Chrome</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.99991 9.85266C7.07582 9.85266 8.75867 8.16981 8.75867 6.09391C8.75867 4.01801 7.07582 2.33515 4.99991 2.33515C2.92401 2.33515 1.24116 4.01801 1.24116 6.09391C1.24116 8.16981 2.92401 9.85266 4.99991 9.85266ZM4.99991 10.65C7.51616 10.65 9.55598 8.61015 9.55598 6.09391C9.55598 3.57766 7.51616 1.53784 4.99991 1.53784C2.48367 1.53784 0.443848 3.57766 0.443848 6.09391C0.443848 8.61015 2.48367 10.65 4.99991 10.65Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.99973 3.41699C5.2199 3.41699 5.39839 3.59548 5.39839 3.81565V6.09368C5.39839 6.31385 5.2199 6.49234 4.99973 6.49234C4.77956 6.49234 4.60107 6.31385 4.60107 6.09368V3.81565C4.60107 3.59548 4.77956 3.41699 4.99973 3.41699Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.08656 5.39831C7.15619 5.60718 7.0433 5.83295 6.83443 5.90257L5.1259 6.47208C4.91703 6.54171 4.69126 6.42882 4.62164 6.21995C4.55202 6.01108 4.6649 5.78531 4.87377 5.71568L6.5823 5.14618C6.79117 5.07655 7.01694 5.18944 7.08656 5.39831Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.32324 0.398656C2.32324 0.178484 2.50173 0 2.7219 0H7.27796C7.49814 0 7.67662 0.178484 7.67662 0.398656C7.67662 0.618827 7.49814 0.797312 7.27796 0.797312H2.7219C2.50173 0.797312 2.32324 0.618827 2.32324 0.398656Z"
                                    fill="black" />
                            </svg>
                            <p>Периоды от начала до полной <span class="br-desktop">загрузки страницы</span></p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5 3.19997C4.44763 3.19997 3.90067 3.30861 3.39035 3.51968C2.88002 3.73076 2.41634 4.04014 2.02576 4.43016C1.79111 4.66447 1.41066 4.66448 1.176 4.43018C0.941341 4.19588 0.941331 3.81599 1.17598 3.58168C1.67815 3.08023 2.27432 2.68245 2.93044 2.41107C3.58657 2.13968 4.28981 2 5 2C5.71019 2 6.41343 2.13968 7.06956 2.41107C7.72569 2.68245 8.32185 3.08023 8.82402 3.58168C9.05867 3.81599 9.05866 4.19588 8.824 4.43018C8.58934 4.66448 8.20889 4.66447 7.97424 4.43016C7.58366 4.04014 7.11998 3.73076 6.60966 3.51968C6.09933 3.30861 5.55237 3.19997 5 3.19997ZM5 5.60058C4.52201 5.60058 4.06359 5.79014 3.72555 6.12758C3.49086 6.36186 3.11041 6.3618 2.87579 6.12745C2.64117 5.89311 2.64123 5.51322 2.87592 5.27895C3.43932 4.71655 4.20335 4.40062 5 4.40062C5.79665 4.40062 6.56068 4.71655 7.12408 5.27895C7.35877 5.51322 7.35883 5.89311 7.12421 6.12745C6.88959 6.3618 6.50914 6.36186 6.27445 6.12758C5.93641 5.79014 5.47799 5.60058 5 5.60058ZM4.39913 7.40002C4.39913 7.06866 4.66815 6.80003 5 6.80003H5.00601C5.33786 6.80003 5.60688 7.06866 5.60688 7.40002C5.60688 7.73138 5.33786 8 5.00601 8H5C4.66815 8 4.39913 7.73138 4.39913 7.40002Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.10267 2.84187C6.82518 0.502559 3.15863 0.504319 0.898517 2.84064C0.693 3.05309 0.359755 3.05312 0.154194 2.84072C-0.051367 2.62832 -0.0514026 2.28391 0.154115 2.07147C2.82663 -0.691164 7.15798 -0.689405 9.8447 2.07024C10.0509 2.28201 10.0519 2.62642 9.84699 2.83949C9.64209 3.05257 9.30884 3.05363 9.10267 2.84187Z"
                                    fill="black" />
                            </svg>
                            <p>Сетевое подключение</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2" cy="2" r="2" fill="black" />
                                <circle cx="6" cy="5" r="1" fill="black" />
                                <circle cx="2" cy="10" r="1.5" stroke="black" />
                            </svg>
                            <p>Данные нескольких выполнений (отчет об удобстве пользования браузером Chrome)</p>
                        </div>
                    </div>
                </div>
                <div class="site-perfomance-block tabs-block--js" data-thumb="site-perfomance-tab-2">
                    <div class="site-perfomance-block-one">
                        <div class="site-perfomance-block-title">
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="30" cy="30" r="30" fill="#FF5A13" fill-opacity="0.25" />
                                <path
                                    d="M5 29.5H10.5834C10.7231 29.5 10.8565 29.4415 10.9512 29.3387L13.6585 26.3993C13.8566 26.1843 14.196 26.1843 14.3941 26.3993L17.1015 29.3387C17.1961 29.4415 17.3295 29.5 17.4692 29.5H22.2073C22.3361 29.5 22.4598 29.4504 22.5529 29.3614L24.1251 27.8584C24.3299 27.6626 24.6563 27.676 24.8444 27.8878L26.1271 29.332C26.222 29.4389 26.3581 29.5 26.501 29.5H33.2174C33.3159 29.5 33.4122 29.5291 33.4942 29.5836L37.6048 32.316C37.7725 32.4275 37.9907 32.4275 38.1584 32.316L42.269 29.5836C42.351 29.5291 42.4473 29.5 42.5458 29.5H54"
                                    stroke="#FF5A13" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <p>Оценкаtest основных интернет-показателей: <span>проверка не пройдена</span></p>
                        </div>
                        <button class="site-perfomance-block-open">Развернуть</button>
                        <div class="site-perfomance-block-info">
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                    </svg>
                                    <a href="javascript:void(0);">Largest Contentful Paint (LCP)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item">5,2
                                                    сек.</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 0.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2844;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS">
                                        <img src="./front/pic/red-svg.svg" style="width: 16px; height: 16px;">
                                    </span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 2,5 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (2,5 сек. – 4 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 4 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">35%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">37%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                    </svg>
                                    <a href="javascript:void(0);">Interaction to Next Paint (INP)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item">537
                                                    мс</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 0.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2844;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/red-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 200 мс)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (200 мс -- 500 мс)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (>500 мс)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">47%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">23%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">30%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="4" cy="4" r="4" fill="#0CCE6A" />
                                    </svg>
                                    <a href="javascript:void(0);">Cumulative Layout Shift (CLS)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item green">0</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 5.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2244;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/green-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 0,1)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (0,1 -- 0,25)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 0,25)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">91%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">3%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">7%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="site-perfomance-block-open-big">ДРУГИЕ ПОКАЗАТЕЛИ, ЗАСЛУЖИВАЮЩИЕ ВНИМАНИЯ</p>
                        <div class="site-perfomance-block-info-second">
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                    </svg>
                                    <a href="javascript:void(0);">First Contentful Paint (FCP)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item">3,1
                                                    сек.</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 0.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2844;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/red-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 1,8 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (1,8 сек. – 3 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 3 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">45%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">27%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="9" height="9" viewBox="0 0 9 9" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect y="4.43933" width="6.27817" height="6.27817"
                                            transform="rotate(-45 0 4.43933)" fill="#D9D9D9" />
                                    </svg>
                                    <a href="javascript:void(0);">First Input Delay (FID)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item grey">-</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 5.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-grey"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/grey-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 2,5 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (2,5 сек. – 4 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 4 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">35%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">37%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-perfomance-block-info-item">
                                <div class="site-perfomance-block-info-item-title-block">
                                    <svg width="8" height="7" viewBox="0 0 8 7" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.861328" y="0.517456" width="6.27817" height="6.27817"
                                            fill="#FFA400" />
                                    </svg>
                                    <a href="javascript:void(0);">Cumulative Layout Shift (CLS)</a>
                                </div>
                                <div class="site-perfomance-block-info-line">
                                    <div class="site-perfomance-block-info-line-text">
                                        <span
                                            class="site-perfomance-block-info-line-text-block site-perfomance-block-info-line-text-block-position">
                                            <span class="site-perfomance-block-info-line-text-block-nowrap">
                                                <span
                                                    class="Ykn2A site-perfomance-block-info-line-text-block-nowrap-item yellow">1,3
                                                    сек.</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="site-perfomance-block-info-line-block">
                                        <span style="flex-grow: 5.3170; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-green"></div>
                                        </span>
                                        <span style="flex-grow: 0.3070; padding-right: 2px;">
                                            <div style="height: 5px; width: 100%;" class="line-orange"></div>
                                        </span>
                                        <span style="flex-grow: 0.2244;">
                                            <div style="height: 5px; width: 100%;" class="line-red"></div>
                                        </span>
                                    </div>
                                    <span class="site-perfomance-block-info-line-text-block GQ6RS"><img
                                            src="./front/pic/yellow-svg.svg" style="width: 16px; height: 16px;"></span>
                                    <div class="site-perfomance-block-info-line-block-hidden">
                                        <p class="site-perfomance-block-info-line-block-hidden-text">Загрузка страниц
                                        </p>
                                        <div class="site-perfomance-block-info-line-block-hidden-wrap">
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text green">
                                                    <span>Хорошо</span> (≤ 2,5 сек.)
                                                </p>
                                                <p
                                                    class="site-perfomance-block-info-line-block-hidden-block-text orange">
                                                    <span>Требуется доработка</span> (2,5 сек. – 4 сек.)
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    <span>Плохо</span> (> 4 сек.)
                                                </p>
                                            </div>
                                            <div class="site-perfomance-block-info-line-block-hidden-block">
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">35%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">28%
                                                </p>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text">37%
                                                </p>
                                            </div>
                                        </div>
                                        <div class="site-perfomance-block-info-line-block-hidden-item">
                                            <div class="site-perfomance-block-info-line-block-hidden-item-block">
                                                <svg width="5" height="11" viewBox="0 0 5 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29376 0.641267C1.38111 0.641267 0.641267 1.38111 0.641267 2.29376C0.641267 3.20641 1.38111 3.94626 2.29376 3.94626C3.20641 3.94626 3.94626 3.20641 3.94626 2.29376C3.94626 1.38111 3.20641 0.641267 2.29376 0.641267ZM0 2.29376C0 1.02695 1.02695 0 2.29376 0C3.56057 0 4.58752 1.02695 4.58752 2.29376C4.58752 3.56057 3.56057 4.58752 2.29376 4.58752C1.02695 4.58752 0 3.56057 0 2.29376Z"
                                                        fill="#FF4E43" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.29378 3.94629C2.47086 3.94629 2.61441 4.08984 2.61441 4.26692V10.6796C2.61441 10.8567 2.47086 11.0002 2.29378 11.0002C2.1167 11.0002 1.97314 10.8567 1.97314 10.6796V4.26692C1.97314 4.08984 2.1167 3.94629 2.29378 3.94629Z"
                                                        fill="#FF4E43" />
                                                </svg>
                                                <p class="site-perfomance-block-info-line-block-hidden-block-text red">
                                                    75-й процентиль -- <span>5,2 сек.</span></p>
                                            </div>
                                            <a href="javascript:void(0);">Показатель Core Web Vitals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="site-perfomance-block-grey">
                        <div class="site-perfomance-block-grey-item">
                            <svg width="11" height="10" viewBox="0 0 11 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.95238 1.85706H1.04762C0.758327 1.85706 0.52381 2.09158 0.52381 2.38087V8.66659C0.52381 8.95588 0.758327 9.1904 1.04762 9.1904H9.95238C10.2417 9.1904 10.4762 8.95588 10.4762 8.66659V2.38087C10.4762 2.09158 10.2417 1.85706 9.95238 1.85706ZM1.04762 1.33325C0.469035 1.33325 0 1.80229 0 2.38087V8.66659C0 9.24517 0.469035 9.7142 1.04762 9.7142H9.95238C10.531 9.7142 11 9.24517 11 8.66659V2.38087C11 1.80229 10.531 1.33325 9.95238 1.33325H1.04762Z"
                                    fill="black" />
                                <path
                                    d="M0 2.38087C0 1.80229 0.469035 1.33325 1.04762 1.33325H9.95238C10.531 1.33325 11 1.80229 11 2.38087V2.90468C11 3.48326 10.531 3.9523 9.95238 3.9523H1.04762C0.469035 3.9523 0 3.48326 0 2.90468V2.38087Z"
                                    fill="black" />
                                <path
                                    d="M2.09521 1.07136C2.09521 0.637421 2.44699 0.285645 2.88093 0.285645C3.31487 0.285645 3.66664 0.637421 3.66664 1.07136V2.11898C3.66664 2.55292 3.31487 2.90469 2.88093 2.90469C2.44699 2.90469 2.09521 2.55292 2.09521 2.11898V1.07136Z"
                                    fill="black" />
                                <path
                                    d="M7.3335 1.07136C7.3335 0.637421 7.68527 0.285645 8.11921 0.285645C8.55315 0.285645 8.90492 0.637421 8.90492 1.07136V2.11898C8.90492 2.55292 8.55315 2.90469 8.11921 2.90469C7.68527 2.90469 7.3335 2.55292 7.3335 2.11898V1.07136Z"
                                    fill="black" />
                            </svg>
                            <p>Данные за последние 28 дней</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.55191 0.713065H1.59928C1.06566 0.713065 0.633083 1.14132 0.633083 1.6696V9.93059C0.633083 10.4589 1.06566 10.8871 1.59928 10.8871H5.55191C6.08552 10.8871 6.5181 10.4589 6.5181 9.93059V1.6696C6.5181 1.14132 6.08552 0.713065 5.55191 0.713065ZM1.59928 0.365234C0.871622 0.365234 0.281738 0.949219 0.281738 1.6696V9.93059C0.281738 10.651 0.871622 11.235 1.59928 11.235H5.55191C6.27957 11.235 6.86945 10.651 6.86945 9.93059V1.6696C6.86945 0.949219 6.27957 0.365234 5.55191 0.365234H1.59928Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.55197 0.843568H1.59935C1.13653 0.843568 0.763585 1.21466 0.763585 1.66967V9.93065C0.763585 10.3857 1.13653 10.7568 1.59935 10.7568H5.55197C6.01479 10.7568 6.38773 10.3857 6.38773 9.93065V1.66967C6.38773 1.21466 6.01479 0.843568 5.55197 0.843568ZM0.151367 1.66967C0.151367 0.876014 0.800888 0.234863 1.59935 0.234863H5.55197C6.35043 0.234863 6.99995 0.876014 6.99995 1.66967V9.93065C6.99995 10.7243 6.35043 11.3655 5.55197 11.3655H1.59935C0.800888 11.3655 0.151367 10.7243 0.151367 9.93065V1.66967ZM1.59935 0.713131H5.55197C6.08559 0.713131 6.51817 1.14139 6.51817 1.66967V9.93065C6.51817 10.4589 6.08559 10.8872 5.55197 10.8872H1.59935C1.06573 10.8872 0.633148 10.4589 0.633148 9.93065V1.66967C0.633148 1.14139 1.06573 0.713131 1.59935 0.713131ZM0.281804 1.66967C0.281804 0.949285 0.871688 0.3653 1.59935 0.3653H5.55197C6.27963 0.3653 6.86951 0.949285 6.86951 1.66967V9.93065C6.86951 10.651 6.27963 11.235 5.55197 11.235H1.59935C0.871687 11.235 0.281804 10.651 0.281804 9.93065V1.66967Z"
                                    fill="black" />
                                <path
                                    d="M2.5874 1.78837C2.5874 1.60646 2.75945 1.45898 2.97169 1.45898H4.50882C4.72105 1.45898 4.8931 1.60646 4.8931 1.78837C4.8931 1.97028 4.72105 2.11776 4.50882 2.11776H2.97169C2.75945 2.11776 2.5874 1.97028 2.5874 1.78837Z"
                                    fill="black" />
                                <path
                                    d="M1.59912 9.81205C1.59912 9.63014 1.73606 9.48267 1.90498 9.48267H5.57527C5.74419 9.48267 5.88113 9.63014 5.88113 9.81205C5.88113 9.99397 5.74419 10.1414 5.57527 10.1414H1.90498C1.73606 10.1414 1.59912 9.99397 1.59912 9.81205Z"
                                    fill="black" />
                            </svg>
                            <p>Мобильные устройства</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M1.51641 3.43856C1.08424 4.19341 0.837209 5.06786 0.837209 6C0.837209 8.62891 2.80211 10.7989 5.34342 11.1214C5.34601 11.1161 5.34871 11.1107 5.35154 11.1054L6.71205 8.55445C6.48547 8.61748 6.24667 8.65116 6 8.65116C5.02714 8.65116 4.17667 8.12715 3.71544 7.34598C3.71026 7.33807 3.70531 7.32994 3.70061 7.32158L1.51641 3.43856ZM2.04862 2.67702L3.47028 5.20442C3.80818 4.12893 4.81299 3.34884 6 3.34884C6.0067 3.34884 6.01339 3.34886 6.02007 3.34891H10.4311C9.52889 1.84426 7.88205 0.837209 6 0.837209C4.41436 0.837209 2.99567 1.55204 2.04862 2.67702ZM10.8352 4.18612H7.93353C8.37858 4.66034 8.65116 5.29834 8.65116 6C8.65116 6.43315 8.54729 6.84205 8.36308 7.20312C8.35511 7.24068 8.34179 7.27777 8.32281 7.31334L6.27358 11.1557C8.99773 11.0134 11.1628 8.75956 11.1628 6C11.1628 5.36169 11.047 4.75044 10.8352 4.18612ZM5.99279 4.18606C5.99518 4.1861 5.99757 4.18612 5.99997 4.18612H6.0166C7.01078 4.19503 7.81395 5.00372 7.81395 6C7.81395 7.00182 7.00182 7.81395 6 7.81395C4.99818 7.81395 4.18605 7.00182 4.18605 6C4.18605 5.00059 4.99429 4.18995 5.99279 4.18606ZM0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6Z"
                                    fill="black" />
                            </svg>
                            <p>Данные всех версий Chrome</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.99991 9.85266C7.07582 9.85266 8.75867 8.16981 8.75867 6.09391C8.75867 4.01801 7.07582 2.33515 4.99991 2.33515C2.92401 2.33515 1.24116 4.01801 1.24116 6.09391C1.24116 8.16981 2.92401 9.85266 4.99991 9.85266ZM4.99991 10.65C7.51616 10.65 9.55598 8.61015 9.55598 6.09391C9.55598 3.57766 7.51616 1.53784 4.99991 1.53784C2.48367 1.53784 0.443848 3.57766 0.443848 6.09391C0.443848 8.61015 2.48367 10.65 4.99991 10.65Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.99973 3.41699C5.2199 3.41699 5.39839 3.59548 5.39839 3.81565V6.09368C5.39839 6.31385 5.2199 6.49234 4.99973 6.49234C4.77956 6.49234 4.60107 6.31385 4.60107 6.09368V3.81565C4.60107 3.59548 4.77956 3.41699 4.99973 3.41699Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.08656 5.39831C7.15619 5.60718 7.0433 5.83295 6.83443 5.90257L5.1259 6.47208C4.91703 6.54171 4.69126 6.42882 4.62164 6.21995C4.55202 6.01108 4.6649 5.78531 4.87377 5.71568L6.5823 5.14618C6.79117 5.07655 7.01694 5.18944 7.08656 5.39831Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.32324 0.398656C2.32324 0.178484 2.50173 0 2.7219 0H7.27796C7.49814 0 7.67662 0.178484 7.67662 0.398656C7.67662 0.618827 7.49814 0.797312 7.27796 0.797312H2.7219C2.50173 0.797312 2.32324 0.618827 2.32324 0.398656Z"
                                    fill="black" />
                            </svg>
                            <p>Периоды от начала до полной <span class="br-desktop">загрузки страницы</span></p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5 3.19997C4.44763 3.19997 3.90067 3.30861 3.39035 3.51968C2.88002 3.73076 2.41634 4.04014 2.02576 4.43016C1.79111 4.66447 1.41066 4.66448 1.176 4.43018C0.941341 4.19588 0.941331 3.81599 1.17598 3.58168C1.67815 3.08023 2.27432 2.68245 2.93044 2.41107C3.58657 2.13968 4.28981 2 5 2C5.71019 2 6.41343 2.13968 7.06956 2.41107C7.72569 2.68245 8.32185 3.08023 8.82402 3.58168C9.05867 3.81599 9.05866 4.19588 8.824 4.43018C8.58934 4.66448 8.20889 4.66447 7.97424 4.43016C7.58366 4.04014 7.11998 3.73076 6.60966 3.51968C6.09933 3.30861 5.55237 3.19997 5 3.19997ZM5 5.60058C4.52201 5.60058 4.06359 5.79014 3.72555 6.12758C3.49086 6.36186 3.11041 6.3618 2.87579 6.12745C2.64117 5.89311 2.64123 5.51322 2.87592 5.27895C3.43932 4.71655 4.20335 4.40062 5 4.40062C5.79665 4.40062 6.56068 4.71655 7.12408 5.27895C7.35877 5.51322 7.35883 5.89311 7.12421 6.12745C6.88959 6.3618 6.50914 6.36186 6.27445 6.12758C5.93641 5.79014 5.47799 5.60058 5 5.60058ZM4.39913 7.40002C4.39913 7.06866 4.66815 6.80003 5 6.80003H5.00601C5.33786 6.80003 5.60688 7.06866 5.60688 7.40002C5.60688 7.73138 5.33786 8 5.00601 8H5C4.66815 8 4.39913 7.73138 4.39913 7.40002Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.10267 2.84187C6.82518 0.502559 3.15863 0.504319 0.898517 2.84064C0.693 3.05309 0.359755 3.05312 0.154194 2.84072C-0.051367 2.62832 -0.0514026 2.28391 0.154115 2.07147C2.82663 -0.691164 7.15798 -0.689405 9.8447 2.07024C10.0509 2.28201 10.0519 2.62642 9.84699 2.83949C9.64209 3.05257 9.30884 3.05363 9.10267 2.84187Z"
                                    fill="black" />
                            </svg>
                            <p>Сетевое подключение</p>
                        </div>
                        <div class="site-perfomance-block-grey-item">
                            <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2" cy="2" r="2" fill="black" />
                                <circle cx="6" cy="5" r="1" fill="black" />
                                <circle cx="2" cy="10" r="1.5" stroke="black" />
                            </svg>
                            <p>Данные нескольких выполнений (отчет об удобстве пользования браузером Chrome)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="site-perfomance-circle">
        <div class="container">
            <div class="site-perfomance-circle-wrap">
                <div class="site-perfomance-circle-block">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#FF5A13" fill-opacity="0.25" />
                        <path
                            d="M40 2.0184C40 0.90367 40.9044 -0.00531216 42.0177 0.0508985C50.3445 0.471314 58.3512 3.4855 64.9021 8.69691C71.9808 14.3281 76.9418 22.1922 78.9757 31.0058C81.0096 39.8195 79.9962 49.0623 76.1009 57.2258C72.4959 64.7808 66.6197 70.9987 59.3191 75.0253C58.343 75.5637 57.1317 75.1429 56.6433 74.1409C56.1548 73.1389 56.5745 71.9356 57.5475 71.3917C64.0288 67.7689 69.2458 62.2184 72.4575 55.4874C75.9597 48.1477 76.8709 39.8377 75.0423 31.9135C73.2136 23.9893 68.7533 16.9189 62.389 11.856C56.5525 7.213 49.4309 4.50982 42.0175 4.09342C40.9045 4.0309 40 3.13314 40 2.0184Z"
                            fill="#FF5A13" />
                        <path
                            d="M37.488 50H34.548V45.8H25.504V43.42L32.896 30.4H37.488V43.168H39.868V45.8H37.488V50ZM28.948 43.028V43.168H34.548V34.096H33.988L28.948 43.028ZM46.481 50H43.261L50.037 33.2H40.713V30.4H53.369V32.892L46.481 50Z"
                            fill="#FF5A13" />
                    </svg>
                    <p>Производительность</p>
                </div>
                <div class="site-perfomance-circle-block">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#FFA400" fill-opacity="0.25" />
                        <path
                            d="M40 1.88173C40 0.842479 40.8431 -0.00461834 41.8812 0.0442419C49.8921 0.42129 57.6212 3.19952 64.0523 8.03925C70.9855 13.2569 76.034 20.5876 78.4364 28.9255C80.8388 37.2635 80.4647 46.1566 77.3705 54.2633C74.2764 62.3701 68.63 69.2509 61.2831 73.8678C53.9362 78.4847 45.2872 80.5874 36.6407 79.8587C27.9942 79.13 19.8191 75.6093 13.3486 69.8279C6.87803 64.0464 2.46297 56.3176 0.76933 47.8073C-0.801645 39.9134 0.0479024 31.7442 3.18319 24.3627C3.58948 23.4062 4.71845 23.014 5.65483 23.4648C6.59121 23.9156 6.97994 25.0386 6.57833 25.9971C3.79449 32.6412 3.0488 39.9797 4.4604 47.0728C5.9947 54.7823 9.99436 61.7839 15.8561 67.0215C21.7178 72.259 29.1238 75.4484 36.9567 76.1085C44.7897 76.7687 52.625 74.8639 59.2807 70.6813C65.9363 66.4988 71.0515 60.2654 73.8545 52.9214C76.6575 45.5773 76.9964 37.521 74.82 29.9675C72.6437 22.414 68.0702 15.7731 61.7893 11.0463C56.0106 6.69757 49.0751 4.18613 41.881 3.81229C40.8432 3.75836 40 2.92098 40 1.88173Z"
                            fill="#FFA400" />
                        <path
                            d="M31.524 50H28.304L35.08 33.2H25.756V30.4H38.412V32.892L31.524 50ZM47.2261 30.12C48.4954 30.12 49.6528 30.4187 50.6981 31.016C51.7621 31.6133 52.5928 32.4253 53.1901 33.452C53.8061 34.46 54.1141 35.58 54.1141 36.812C54.1141 37.5587 53.9928 38.2867 53.7501 38.996C53.5074 39.7053 53.2274 40.3027 52.9101 40.788L46.9741 50H43.6701L48.0661 43.084C47.6554 43.1773 47.2168 43.224 46.7501 43.224C45.5928 43.224 44.5194 42.944 43.5301 42.384C42.5408 41.824 41.7568 41.0587 41.1781 40.088C40.5994 39.1173 40.3101 38.0253 40.3101 36.812C40.3101 35.58 40.6088 34.46 41.2061 33.452C41.8221 32.4253 42.6528 31.6133 43.6981 31.016C44.7621 30.4187 45.9381 30.12 47.2261 30.12ZM47.2261 40.732C47.9541 40.732 48.6168 40.564 49.2141 40.228C49.8301 39.8733 50.3061 39.3973 50.6421 38.8C50.9968 38.2027 51.1741 37.54 51.1741 36.812C51.1741 35.692 50.7914 34.7587 50.0261 34.012C49.2794 33.2467 48.3461 32.864 47.2261 32.864C46.0874 32.864 45.1354 33.2467 44.3701 34.012C43.6234 34.7587 43.2501 35.692 43.2501 36.812C43.2501 37.54 43.4181 38.2027 43.7541 38.8C44.1088 39.3973 44.5848 39.8733 45.1821 40.228C45.7981 40.564 46.4794 40.732 47.2261 40.732Z"
                            fill="#FFA400" />
                    </svg>
                    <p>Специальные<span class="br-desktop">возможности</span></p>
                </div>
                <div class="site-perfomance-circle-block">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#0CCE6A" fill-opacity="0.15" />
                        <path
                            d="M40 1.88173C40 0.842479 40.843 -0.00462151 41.8811 0.0442189C51.4172 0.492872 60.503 4.3411 67.472 10.9261C74.8979 17.9429 79.3575 27.5352 79.9359 37.7355C80.5142 47.9358 77.1676 57.9707 70.5825 65.782C63.9974 73.5933 54.6729 78.5887 44.5217 79.7436C34.3706 80.8985 24.1622 78.1254 15.9907 71.993C7.81917 65.8607 2.30387 56.8339 0.576121 46.7644C-1.15163 36.695 1.03914 26.346 6.69906 17.8404C12.0107 9.85818 19.9998 4.0673 29.1914 1.48795C30.192 1.20717 31.2038 1.84325 31.4372 2.85594C31.6707 3.86863 31.0371 4.87402 30.0379 5.15969C21.7828 7.51982 14.6113 12.7435 9.83223 19.9253C4.70483 27.6307 2.72018 37.0059 4.28537 46.128C5.85057 55.2501 10.8469 63.4275 18.2497 68.9829C25.6524 74.5383 34.9002 77.0505 44.0963 76.0043C53.2924 74.958 61.7395 70.4326 67.7051 63.3563C73.6707 56.2799 76.7024 47.1891 76.1784 37.9486C75.6545 28.708 71.6145 20.0182 64.8872 13.6616C58.6171 7.73686 50.4553 4.25769 41.8811 3.81227C40.8432 3.75836 40 2.92098 40 1.88173Z"
                            fill="#0CCE6A" />
                        <path
                            d="M32.98 30.12C34.2493 30.12 35.4067 30.4187 36.452 31.016C37.516 31.6133 38.3467 32.4253 38.944 33.452C39.56 34.46 39.868 35.58 39.868 36.812C39.868 37.5587 39.7467 38.2867 39.504 38.996C39.2613 39.7053 38.9813 40.3027 38.664 40.788L32.728 50H29.424L33.82 43.084C33.4093 43.1773 32.9707 43.224 32.504 43.224C31.3467 43.224 30.2733 42.944 29.284 42.384C28.2947 41.824 27.5107 41.0587 26.932 40.088C26.3533 39.1173 26.064 38.0253 26.064 36.812C26.064 35.58 26.3627 34.46 26.96 33.452C27.576 32.4253 28.4067 31.6133 29.452 31.016C30.516 30.4187 31.692 30.12 32.98 30.12ZM32.98 40.732C33.708 40.732 34.3707 40.564 34.968 40.228C35.584 39.8733 36.06 39.3973 36.396 38.8C36.7507 38.2027 36.928 37.54 36.928 36.812C36.928 35.692 36.5453 34.7587 35.78 34.012C35.0333 33.2467 34.1 32.864 32.98 32.864C31.8413 32.864 30.8893 33.2467 30.124 34.012C29.3773 34.7587 29.004 35.692 29.004 36.812C29.004 37.54 29.172 38.2027 29.508 38.8C29.8627 39.3973 30.3387 39.8733 30.936 40.228C31.552 40.564 32.2333 40.732 32.98 40.732ZM48.8225 37.176C49.9799 37.176 51.0532 37.456 52.0425 38.016C53.0319 38.576 53.8159 39.3413 54.3945 40.312C54.9732 41.2827 55.2625 42.3747 55.2625 43.588C55.2625 44.82 54.9545 45.9493 54.3385 46.976C53.7412 47.984 52.9105 48.7867 51.8465 49.384C50.8012 49.9813 49.6439 50.28 48.3745 50.28C47.0865 50.28 45.9105 49.9813 44.8465 49.384C43.8012 48.7867 42.9705 47.984 42.3545 46.976C41.7572 45.9493 41.4585 44.82 41.4585 43.588C41.4585 42.8227 41.5799 42.0853 41.8225 41.376C42.0652 40.6667 42.3452 40.0787 42.6625 39.612L48.5985 30.4H51.9305L47.5065 37.316C48.0665 37.2227 48.5052 37.176 48.8225 37.176ZM48.3745 47.536C49.4945 47.536 50.4279 47.1627 51.1745 46.416C51.9399 45.6507 52.3225 44.708 52.3225 43.588C52.3225 42.86 52.1452 42.1973 51.7905 41.6C51.4545 41.0027 50.9785 40.536 50.3625 40.2C49.7652 39.8453 49.1025 39.668 48.3745 39.668C47.6279 39.668 46.9465 39.8453 46.3305 40.2C45.7332 40.536 45.2572 41.0027 44.9025 41.6C44.5665 42.1973 44.3985 42.86 44.3985 43.588C44.3985 44.708 44.7719 45.6507 45.5185 46.416C46.2839 47.1627 47.2359 47.536 48.3745 47.536Z"
                            fill="#0CCE6A" />
                    </svg>
                    <p>Рекомендации</p>
                </div>
                <div class="site-perfomance-circle-block">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#0CCE6A" fill-opacity="0.15" />
                        <path
                            d="M40 1.88173C40 0.842479 40.843 -0.00462151 41.8811 0.0442189C51.4172 0.492872 60.503 4.3411 67.472 10.9261C74.8979 17.9429 79.3575 27.5352 79.9359 37.7355C80.5142 47.9358 77.1676 57.9707 70.5825 65.782C63.9974 73.5933 54.6729 78.5887 44.5217 79.7436C34.3706 80.8985 24.1622 78.1254 15.9907 71.993C7.81917 65.8607 2.30387 56.8339 0.576121 46.7644C-1.15163 36.695 1.03914 26.346 6.69906 17.8404C12.0107 9.85818 19.9998 4.0673 29.1914 1.48795C30.192 1.20717 31.2038 1.84325 31.4372 2.85594C31.6707 3.86863 31.0371 4.87402 30.0379 5.15969C21.7828 7.51982 14.6113 12.7435 9.83223 19.9253C4.70483 27.6307 2.72018 37.0059 4.28537 46.128C5.85057 55.2501 10.8469 63.4275 18.2497 68.9829C25.6524 74.5383 34.9002 77.0505 44.0963 76.0043C53.2924 74.958 61.7395 70.4326 67.7051 63.3563C73.6707 56.2799 76.7024 47.1891 76.1784 37.9486C75.6545 28.708 71.6145 20.0182 64.8872 13.6616C58.6171 7.73686 50.4553 4.25769 41.8811 3.81227C40.8432 3.75836 40 2.92098 40 1.88173Z"
                            fill="#0CCE6A" />
                        <path
                            d="M32.98 30.12C34.2493 30.12 35.4067 30.4187 36.452 31.016C37.516 31.6133 38.3467 32.4253 38.944 33.452C39.56 34.46 39.868 35.58 39.868 36.812C39.868 37.5587 39.7467 38.2867 39.504 38.996C39.2613 39.7053 38.9813 40.3027 38.664 40.788L32.728 50H29.424L33.82 43.084C33.4093 43.1773 32.9707 43.224 32.504 43.224C31.3467 43.224 30.2733 42.944 29.284 42.384C28.2947 41.824 27.5107 41.0587 26.932 40.088C26.3533 39.1173 26.064 38.0253 26.064 36.812C26.064 35.58 26.3627 34.46 26.96 33.452C27.576 32.4253 28.4067 31.6133 29.452 31.016C30.516 30.4187 31.692 30.12 32.98 30.12ZM32.98 40.732C33.708 40.732 34.3707 40.564 34.968 40.228C35.584 39.8733 36.06 39.3973 36.396 38.8C36.7507 38.2027 36.928 37.54 36.928 36.812C36.928 35.692 36.5453 34.7587 35.78 34.012C35.0333 33.2467 34.1 32.864 32.98 32.864C31.8413 32.864 30.8893 33.2467 30.124 34.012C29.3773 34.7587 29.004 35.692 29.004 36.812C29.004 37.54 29.172 38.2027 29.508 38.8C29.8627 39.3973 30.3387 39.8733 30.936 40.228C31.552 40.564 32.2333 40.732 32.98 40.732ZM48.8225 37.176C49.9799 37.176 51.0532 37.456 52.0425 38.016C53.0319 38.576 53.8159 39.3413 54.3945 40.312C54.9732 41.2827 55.2625 42.3747 55.2625 43.588C55.2625 44.82 54.9545 45.9493 54.3385 46.976C53.7412 47.984 52.9105 48.7867 51.8465 49.384C50.8012 49.9813 49.6439 50.28 48.3745 50.28C47.0865 50.28 45.9105 49.9813 44.8465 49.384C43.8012 48.7867 42.9705 47.984 42.3545 46.976C41.7572 45.9493 41.4585 44.82 41.4585 43.588C41.4585 42.8227 41.5799 42.0853 41.8225 41.376C42.0652 40.6667 42.3452 40.0787 42.6625 39.612L48.5985 30.4H51.9305L47.5065 37.316C48.0665 37.2227 48.5052 37.176 48.8225 37.176ZM48.3745 47.536C49.4945 47.536 50.4279 47.1627 51.1745 46.416C51.9399 45.6507 52.3225 44.708 52.3225 43.588C52.3225 42.86 52.1452 42.1973 51.7905 41.6C51.4545 41.0027 50.9785 40.536 50.3625 40.2C49.7652 39.8453 49.1025 39.668 48.3745 39.668C47.6279 39.668 46.9465 39.8453 46.3305 40.2C45.7332 40.536 45.2572 41.0027 44.9025 41.6C44.5665 42.1973 44.3985 42.86 44.3985 43.588C44.3985 44.708 44.7719 45.6507 45.5185 46.416C46.2839 47.1627 47.2359 47.536 48.3745 47.536Z"
                            fill="#0CCE6A" />
                    </svg>
                    <p>Поисковая<span class="br-desktop">оптимизация</span></p>
                </div>
            </div>
        </div>
    </section>
    <section class="performance-info">
        <div class="container">
            <div class="performance-info-wrap">
                <div class="performance-info-block-top">
                    <div class="performance-info-block-top-left">
                        <div class="performance-info-block-top-left-svg">
                            <svg class="performance-info-block-top-left-svg-show" width="162" height="162"
                                viewBox="0 0 162 162" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="81" cy="81" r="81" fill="#FF5A13" fill-opacity="0.25" />
                                <path
                                    d="M76.493 101.75H70.403V93.0499H51.669V88.1199L66.981 61.1499H76.493V87.5979H81.423V93.0499H76.493V101.75ZM58.803 87.3079V87.5979H70.403V68.8059H69.243L58.803 87.3079ZM95.1214 101.75H88.4514L102.487 66.9499H83.1734V61.1499H109.389V66.3119L95.1214 101.75Z"
                                    fill="#FF5A13" />
                            </svg>
                            <p class="performance-info-block-top-left-svg-text one">SI</p>
                            <p class="performance-info-block-top-left-svg-text two">FCP</p>
                            <p class="performance-info-block-top-left-svg-text three">LCP</p>
                            <p class="performance-info-block-top-left-svg-text four">TBT</p>
                            <p class="performance-info-block-top-left-svg-text five">CLS</p>
                        </div>
                        <div class="performance-info-block-top-left-block-text">
                            <p class="performance-info-block-top-left-title">Производительность</p>
                            <p class="performance-info-block-top-left-text">Значения приблизительные и могут
                                изменяться. <span>Уровень производительности рассчитывается</span> непосредственно на
                                основании этих показателей. <a href="javascript:void(0);">Показать калькулятор</a></p>
                        </div>
                        <div class="performance-info-block-top-left-bottom">
                            <div class="performance-info-block-top-left-bottom-block">
                                <svg width="10" height="8" viewBox="0 0 10 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                </svg>
                                <p>0 - 49</p>
                            </div>
                            <div class="performance-info-block-top-left-bottom-block">
                                <svg width="7" height="7" viewBox="0 0 7 7" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="6.27817" height="6.27817" fill="#FFA400" />
                                </svg>
                                <p>50 - 89</p>
                            </div>
                            <div class="performance-info-block-top-left-bottom-block">
                                <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="4" cy="4" r="4" fill="#0CCE6A" />
                                </svg>
                                <p>90 - 100</p>
                            </div>
                        </div>
                    </div>
                    <div class="performance-info-block-top-border"></div>
                    <div class="performance-info-block-top-right">
                        <div class="performance-info-block-top-right-img">
                            <img src="./front/pic/image22.png">
                        </div>
                    </div>
                </div>
                <div class="performance-info-block-indicators">
                    <div class="performance-info-block-indicators-title-block">
                        <p class="performance-info-block-indicators-title">Показатели</p>
                        <p class="performance-info-block-indicators-text"
                            id="performance-info-block-indicators-title-block-open">Развернуть</p>
                    </div>
                    <div class="performance-info-block-indicators-item-wrap">
                        <div class="performance-info-block-indicators-item">
                            <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0L13.0622 10.5H0.937822L7 0Z" fill="#FF5A13" />
                            </svg>
                            <div class="performance-info-block-indicators-item-block">
                                <p class="performance-info-block-indicators-item-block-text">First Contentful Paint</p>
                                <p class="performance-info-block-indicators-item-block-text red">3,2 сек.</p>
                                <p class="performance-info-block-indicators-item-block-text-hidden">Первая отрисовка
                                    контента – показатель, который отражает время между началом загрузки страницы и
                                    появлением первого изображения или блока текста. Подробнее <a
                                        href="javascript:void(0);">о первой отрисовке контента…</a></p>
                            </div>
                        </div>
                        <div class="performance-info-block-indicators-item">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0L13.0622 10.5H0.937822L7 0Z" fill="#FF5A13" />
                            </svg>
                            <div class="performance-info-block-indicators-item-block">
                                <p class="performance-info-block-indicators-item-block-text">Largest Contentful Paint
                                </p>
                                <p class="performance-info-block-indicators-item-block-text red">31,8 сек.</p>
                                <p class="performance-info-block-indicators-item-block-text-hidden">Отрисовка самого
                                    крупного контента – показатель, который отражает время, требуемое на полную
                                    отрисовку самого крупного изображения или текстового блока.<a
                                        href="javascript:void(0);">Подробнее об отрисовке самого крупного контента…</a>
                                </p>
                            </div>
                        </div>
                        <div class="performance-info-block-indicators-item">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 0L13.0622 10.5H0.937822L7 0Z" fill="#FF5A13" />
                            </svg>
                            <div class="performance-info-block-indicators-item-block">
                                <p class="performance-info-block-indicators-item-block-text">Total Blocking Time</p>
                                <p class="performance-info-block-indicators-item-block-text red">980 мс</p>
                                <p class="performance-info-block-indicators-item-block-text-hidden">Сумма (в
                                    миллисекундах) всех периодов от первой отрисовки контента до загрузки для
                                    взаимодействия, когда скорость выполнения задач превышала 50 мс.<a
                                        href="javascript:void(0);">Подробнее об общем времени блокировки…</a></p>
                            </div>
                        </div>
                        <div class="performance-info-block-indicators-item">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="5" cy="5" r="5" fill="#0CCE6A" />
                            </svg>
                            <div class="performance-info-block-indicators-item-block">
                                <p class="performance-info-block-indicators-item-block-text">Cumulative Layout Shift</p>
                                <p class="performance-info-block-indicators-item-block-text green">0</p>
                                <p class="performance-info-block-indicators-item-block-text-hidden">Совокупное смещение
                                    макета – это величина, на которую смещаются видимые элементы области просмотра при
                                    загрузке.<a href="javascript:void(0);">Подробнее о совокупном смещении макета…</a>
                                </p>
                            </div>
                        </div>
                        <div class="performance-info-block-indicators-item">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="10" height="10" fill="#FFA400" />
                            </svg>
                            <div class="performance-info-block-indicators-item-block">
                                <p class="performance-info-block-indicators-item-block-text">Speed Index</p>
                                <p class="performance-info-block-indicators-item-block-text yellow">3,5 сек.</p>
                                <p class="performance-info-block-indicators-item-block-text-hidden">Индекс скорости
                                    загрузки показывает, как быстро на странице появляется контент.<a
                                        href="javascript:void(0);">Подробнее об индексе скорости загрузки…</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="performance-info-block-grey">
                    <div class="site-perfomance-block-grey-item">
                        <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.95238 1.85706H1.04762C0.758327 1.85706 0.52381 2.09158 0.52381 2.38087V8.66659C0.52381 8.95588 0.758327 9.1904 1.04762 9.1904H9.95238C10.2417 9.1904 10.4762 8.95588 10.4762 8.66659V2.38087C10.4762 2.09158 10.2417 1.85706 9.95238 1.85706ZM1.04762 1.33325C0.469035 1.33325 0 1.80229 0 2.38087V8.66659C0 9.24517 0.469035 9.7142 1.04762 9.7142H9.95238C10.531 9.7142 11 9.24517 11 8.66659V2.38087C11 1.80229 10.531 1.33325 9.95238 1.33325H1.04762Z"
                                fill="black"></path>
                            <path
                                d="M0 2.38087C0 1.80229 0.469035 1.33325 1.04762 1.33325H9.95238C10.531 1.33325 11 1.80229 11 2.38087V2.90468C11 3.48326 10.531 3.9523 9.95238 3.9523H1.04762C0.469035 3.9523 0 3.48326 0 2.90468V2.38087Z"
                                fill="black"></path>
                            <path
                                d="M2.09521 1.07136C2.09521 0.637421 2.44699 0.285645 2.88093 0.285645C3.31487 0.285645 3.66664 0.637421 3.66664 1.07136V2.11898C3.66664 2.55292 3.31487 2.90469 2.88093 2.90469C2.44699 2.90469 2.09521 2.55292 2.09521 2.11898V1.07136Z"
                                fill="black"></path>
                            <path
                                d="M7.3335 1.07136C7.3335 0.637421 7.68527 0.285645 8.11921 0.285645C8.55315 0.285645 8.90492 0.637421 8.90492 1.07136V2.11898C8.90492 2.55292 8.55315 2.90469 8.11921 2.90469C7.68527 2.90469 7.3335 2.55292 7.3335 2.11898V1.07136Z"
                                fill="black"></path>
                        </svg>
                        <p>Captured at 6 авг. 2024 г., 14:39 GMT+3</p>
                    </div>
                    <div class="site-perfomance-block-grey-item">
                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5 3.19997C4.44763 3.19997 3.90067 3.30861 3.39035 3.51968C2.88002 3.73076 2.41634 4.04014 2.02576 4.43016C1.79111 4.66447 1.41066 4.66448 1.176 4.43018C0.941341 4.19588 0.941331 3.81599 1.17598 3.58168C1.67815 3.08023 2.27432 2.68245 2.93044 2.41107C3.58657 2.13968 4.28981 2 5 2C5.71019 2 6.41343 2.13968 7.06956 2.41107C7.72569 2.68245 8.32185 3.08023 8.82402 3.58168C9.05867 3.81599 9.05866 4.19588 8.824 4.43018C8.58934 4.66448 8.20889 4.66447 7.97424 4.43016C7.58366 4.04014 7.11998 3.73076 6.60966 3.51968C6.09933 3.30861 5.55237 3.19997 5 3.19997ZM5 5.60058C4.52201 5.60058 4.06359 5.79014 3.72555 6.12758C3.49086 6.36186 3.11041 6.3618 2.87579 6.12745C2.64117 5.89311 2.64123 5.51322 2.87592 5.27895C3.43932 4.71655 4.20335 4.40062 5 4.40062C5.79665 4.40062 6.56068 4.71655 7.12408 5.27895C7.35877 5.51322 7.35883 5.89311 7.12421 6.12745C6.88959 6.3618 6.50914 6.36186 6.27445 6.12758C5.93641 5.79014 5.47799 5.60058 5 5.60058ZM4.39913 7.40002C4.39913 7.06866 4.66815 6.80003 5 6.80003H5.00601C5.33786 6.80003 5.60688 7.06866 5.60688 7.40002C5.60688 7.73138 5.33786 8 5.00601 8H5C4.66815 8 4.39913 7.73138 4.39913 7.40002Z"
                                fill="black"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.10267 2.84187C6.82518 0.502559 3.15863 0.504319 0.898517 2.84064C0.693 3.05309 0.359755 3.05312 0.154194 2.84072C-0.051367 2.62832 -0.0514026 2.28391 0.154115 2.07147C2.82663 -0.691164 7.15798 -0.689405 9.8447 2.07024C10.0509 2.28201 10.0519 2.62642 9.84699 2.83949C9.64209 3.05257 9.30884 3.05363 9.10267 2.84187Z"
                                fill="black"></path>
                        </svg>
                        <p>Ограничение для сети 4G с низкой скоростью</p>
                    </div>
                    <div class="site-perfomance-block-grey-item">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.51641 3.43856C1.08424 4.19341 0.837209 5.06786 0.837209 6C0.837209 8.62891 2.80211 10.7989 5.34342 11.1214C5.34601 11.1161 5.34871 11.1107 5.35154 11.1054L6.71205 8.55445C6.48547 8.61748 6.24667 8.65116 6 8.65116C5.02714 8.65116 4.17667 8.12715 3.71544 7.34598C3.71026 7.33807 3.70531 7.32994 3.70061 7.32158L1.51641 3.43856ZM2.04862 2.67702L3.47028 5.20442C3.80818 4.12893 4.81299 3.34884 6 3.34884C6.0067 3.34884 6.01339 3.34886 6.02007 3.34891H10.4311C9.52889 1.84426 7.88205 0.837209 6 0.837209C4.41436 0.837209 2.99567 1.55204 2.04862 2.67702ZM10.8352 4.18612H7.93353C8.37858 4.66034 8.65116 5.29834 8.65116 6C8.65116 6.43315 8.54729 6.84205 8.36308 7.20312C8.35511 7.24068 8.34179 7.27777 8.32281 7.31334L6.27358 11.1557C8.99773 11.0134 11.1628 8.75956 11.1628 6C11.1628 5.36169 11.047 4.75044 10.8352 4.18612ZM5.99279 4.18606C5.99518 4.1861 5.99757 4.18612 5.99997 4.18612H6.0166C7.01078 4.19503 7.81395 5.00372 7.81395 6C7.81395 7.00182 7.00182 7.81395 6 7.81395C4.99818 7.81395 4.18605 7.00182 4.18605 6C4.18605 5.00059 4.99429 4.18995 5.99279 4.18606ZM0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6Z"
                                fill="black"></path>
                        </svg>
                        <p>Using HeadlessChromium 126.0.6478.182 with lr</p>
                    </div>
                    <div class="site-perfomance-block-grey-item">
                        <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.99991 9.85266C7.07582 9.85266 8.75867 8.16981 8.75867 6.09391C8.75867 4.01801 7.07582 2.33515 4.99991 2.33515C2.92401 2.33515 1.24116 4.01801 1.24116 6.09391C1.24116 8.16981 2.92401 9.85266 4.99991 9.85266ZM4.99991 10.65C7.51616 10.65 9.55598 8.61015 9.55598 6.09391C9.55598 3.57766 7.51616 1.53784 4.99991 1.53784C2.48367 1.53784 0.443848 3.57766 0.443848 6.09391C0.443848 8.61015 2.48367 10.65 4.99991 10.65Z"
                                fill="black"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.99973 3.41699C5.2199 3.41699 5.39839 3.59548 5.39839 3.81565V6.09368C5.39839 6.31385 5.2199 6.49234 4.99973 6.49234C4.77956 6.49234 4.60107 6.31385 4.60107 6.09368V3.81565C4.60107 3.59548 4.77956 3.41699 4.99973 3.41699Z"
                                fill="black"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.08656 5.39831C7.15619 5.60718 7.0433 5.83295 6.83443 5.90257L5.1259 6.47208C4.91703 6.54171 4.69126 6.42882 4.62164 6.21995C4.55202 6.01108 4.6649 5.78531 4.87377 5.71568L6.5823 5.14618C6.79117 5.07655 7.01694 5.18944 7.08656 5.39831Z"
                                fill="black"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.32324 0.398656C2.32324 0.178484 2.50173 0 2.7219 0H7.27796C7.49814 0 7.67662 0.178484 7.67662 0.398656C7.67662 0.618827 7.49814 0.797312 7.27796 0.797312H2.7219C2.50173 0.797312 2.32324 0.618827 2.32324 0.398656Z"
                                fill="black"></path>
                        </svg>
                        <p>Начальная загрузка страницы</p>
                    </div>
                    <div class="site-perfomance-block-grey-item">
                        <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.55191 0.713065H1.59928C1.06566 0.713065 0.633083 1.14132 0.633083 1.6696V9.93059C0.633083 10.4589 1.06566 10.8871 1.59928 10.8871H5.55191C6.08552 10.8871 6.5181 10.4589 6.5181 9.93059V1.6696C6.5181 1.14132 6.08552 0.713065 5.55191 0.713065ZM1.59928 0.365234C0.871622 0.365234 0.281738 0.949219 0.281738 1.6696V9.93059C0.281738 10.651 0.871622 11.235 1.59928 11.235H5.55191C6.27957 11.235 6.86945 10.651 6.86945 9.93059V1.6696C6.86945 0.949219 6.27957 0.365234 5.55191 0.365234H1.59928Z"
                                fill="black"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.55197 0.843568H1.59935C1.13653 0.843568 0.763585 1.21466 0.763585 1.66967V9.93065C0.763585 10.3857 1.13653 10.7568 1.59935 10.7568H5.55197C6.01479 10.7568 6.38773 10.3857 6.38773 9.93065V1.66967C6.38773 1.21466 6.01479 0.843568 5.55197 0.843568ZM0.151367 1.66967C0.151367 0.876014 0.800888 0.234863 1.59935 0.234863H5.55197C6.35043 0.234863 6.99995 0.876014 6.99995 1.66967V9.93065C6.99995 10.7243 6.35043 11.3655 5.55197 11.3655H1.59935C0.800888 11.3655 0.151367 10.7243 0.151367 9.93065V1.66967ZM1.59935 0.713131H5.55197C6.08559 0.713131 6.51817 1.14139 6.51817 1.66967V9.93065C6.51817 10.4589 6.08559 10.8872 5.55197 10.8872H1.59935C1.06573 10.8872 0.633148 10.4589 0.633148 9.93065V1.66967C0.633148 1.14139 1.06573 0.713131 1.59935 0.713131ZM0.281804 1.66967C0.281804 0.949285 0.871688 0.3653 1.59935 0.3653H5.55197C6.27963 0.3653 6.86951 0.949285 6.86951 1.66967V9.93065C6.86951 10.651 6.27963 11.235 5.55197 11.235H1.59935C0.871687 11.235 0.281804 10.651 0.281804 9.93065V1.66967Z"
                                fill="black"></path>
                            <path
                                d="M2.5874 1.78837C2.5874 1.60646 2.75945 1.45898 2.97169 1.45898H4.50882C4.72105 1.45898 4.8931 1.60646 4.8931 1.78837C4.8931 1.97028 4.72105 2.11776 4.50882 2.11776H2.97169C2.75945 2.11776 2.5874 1.97028 2.5874 1.78837Z"
                                fill="black"></path>
                            <path
                                d="M1.59912 9.81205C1.59912 9.63014 1.73606 9.48267 1.90498 9.48267H5.57527C5.74419 9.48267 5.88113 9.63014 5.88113 9.81205C5.88113 9.99397 5.74419 10.1414 5.57527 10.1414H1.90498C1.73606 10.1414 1.59912 9.99397 1.59912 9.81205Z"
                                fill="black"></path>
                        </svg>
                        <p>Эмуляция устройства Moto G Power <span class="br-desktop">with Lighthouse 12.0.0</span></p>
                    </div>
                    <div class="site-perfomance-block-grey-item">
                        <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="2" cy="2" r="2" fill="black"></circle>
                            <circle cx="6" cy="5" r="1" fill="black"></circle>
                            <circle cx="2" cy="10" r="1.5" stroke="black"></circle>
                        </svg>
                        <p>Сеанс с просмотром одной страницы</p>
                    </div>
                </div>
                <div class="performance-info-block-map-wrap">
                    <div class="performance-info-block-map">
                        <a href="javascript:void(0);">Открыть карту эффективности</a>
                        <svg width="26" height="19" viewBox="0 0 26 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.1247 4.3263L1.11343 14.3871C1.11191 15.7453 2.1072 16.8475 3.33648 16.8489L22.5593 16.8704C23.7886 16.8718 24.7863 15.7718 24.7879 14.4136L24.7991 4.35281C24.8007 2.99458 23.8054 1.8924 22.5761 1.89102L3.35325 1.8695C2.12397 1.86812 1.12622 2.96807 1.1247 4.3263ZM0.304048 14.3862C0.301974 16.2383 1.65919 17.7413 3.33548 17.7431L22.5583 17.7647C24.2346 17.7665 25.5952 16.2666 25.5973 14.4145L25.6085 4.35372C25.6106 2.50158 24.2534 0.998609 22.5771 0.996732L3.35425 0.975207C1.67797 0.973331 0.317387 2.47326 0.315313 4.3254L0.304048 14.3862Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.42474 4.32654L1.41347 14.3873C1.41211 15.6087 2.30072 16.5476 3.33686 16.5488L22.5597 16.5703C23.5958 16.5714 24.4865 15.6345 24.4879 14.4131L24.4992 4.35237C24.5005 3.13097 23.6119 2.19208 22.5758 2.19092L3.35296 2.16939C2.31682 2.16823 1.42611 3.10513 1.42474 4.32654ZM3.33518 18.043C1.46576 18.0409 0.00186392 16.3747 0.004091 14.3857L0.0153562 4.32496C0.0175833 2.336 1.4852 0.673013 3.35463 0.675106L22.5775 0.69663C24.4469 0.698723 25.9108 2.36499 25.9086 4.35395L25.8973 14.4147C25.8951 16.4037 24.4274 18.0667 22.558 18.0646L3.33518 18.043ZM1.11347 14.387L1.12474 4.3262C1.12626 2.96797 2.12402 1.86802 3.35329 1.8694L22.5761 1.89092C23.8054 1.8923 24.8007 2.99448 24.7992 4.35271L24.7879 14.4135C24.7864 15.7717 23.7886 16.8717 22.5594 16.8703L3.33652 16.8488C2.10725 16.8474 1.11195 15.7452 1.11347 14.387ZM3.33552 17.743C1.65923 17.7412 0.302017 16.2382 0.304091 14.3861L0.315356 4.32529C0.31743 2.47316 1.67801 0.973228 3.3543 0.975105L22.5771 0.996629C24.2534 0.998506 25.6106 2.50148 25.6086 4.35361L25.5973 14.4144C25.5952 16.2665 24.2346 17.7664 22.5584 17.7646L3.33552 17.743Z"
                                fill="black" />
                            <path
                                d="M0.221717 6.8384C0.222236 6.37536 0.541301 6.00036 0.93437 6.0008L24.6509 6.02735C25.044 6.02779 25.3622 6.40351 25.3617 6.86655C25.3612 7.32958 25.0421 7.70459 24.6491 7.70415L0.932492 7.67759C0.539424 7.67715 0.221199 7.30143 0.221717 6.8384Z"
                                fill="black" />
                            <path
                                d="M18.8345 7.36004C19.2975 7.36004 19.6729 6.60693 19.6729 7L19.6729 16.7883C19.6729 17.1814 19.2975 17.5001 18.8345 17.5001C18.3714 17.5001 17.9961 17.1814 17.9961 16.7883L17.9961 7C17.9961 6.60693 18.3714 7.36004 18.8345 7.36004Z"
                                fill="black" />
                        </svg>
                    </div>
                </div>
                <div class="performance-info-block-photo-wrap">
                    <div class="performance-info-block-photo-block">
                        <img src="./front/pic/image1.png" alt="">
                        <img src="./front/pic/image2.png" alt="">
                        <img src="./front/pic/image3.png" alt="">
                        <img src="./front/pic/image4.png" alt="">
                        <img src="./front/pic/image4.png" alt="">
                        <img src="./front/pic/image4.png" alt="">
                        <img src="./front/pic/image4.png" alt="">
                        <img src="./front/pic/image4.png" alt="">
                    </div>
                    <div class="performance-info-block-tabs-block">
                        <p class="performance-info-block-tabs-block-text">Показать аудиты</p>
                        <button class="performance-info-block-tabs-button performance-info-block-tabs--js active"
                            data-thumb="performance-tab-1">All</button>
                        <button class="performance-info-block-tabs-button performance-info-block-tabs--js"
                            data-thumb="performance-tab-2">FCP</button>
                        <button class="performance-info-block-tabs-button performance-info-block-tabs--js"
                            data-thumb="performance-tab-3">LCP</button>
                        <button class="performance-info-block-tabs-button performance-info-block-tabs--js"
                            data-thumb="performance-tab-4">TBT</button>
                        <button class="performance-info-block-tabs-button performance-info-block-tabs--js"
                            data-thumb="performance-tab-5">CLS</button>
                    </div>
                    <div class="performance-info-block-tabs-block-show performance-info-block--js active"
                        data-thumb="performance-tab-1">
                        <h2>диагностика</h2>
                        <div class="performance-info-block-tabs-wrap">
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Элемент "Отрисовка самого крупного
                                            контента" <span
                                                class="performance-info-block-tabs-open-text red">-- 31 840 мс</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Это самый большой элемент контента, отрисованный в области просмотра. <a
                                                href="javascript:void(0);">Подробнее об отрисовке самого крупного
                                                контента…</a><button class="performance-info-block-tabs-hidden-button">LCP</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-elem">
                                        <div class="performance-info-block-tabs-hidden-block-elem-block-title">
                                            <p class="performance-info-block-tabs-hidden-block-elem-title">Элемент</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-elem-block-grey">
                                            <img src="./front/pic/detal-elem.png">
                                            <div class="performance-info-block-tabs-hidden-block-elem-block-grey-text">
                                                <p>Создаем, реализуем и масштабируем стратегии продвижения c учётом
                                                    юнит-экономики…</p>
                                                <pre>&lt;h2&gt; class="h2 wow animate__fadeInUp pb-3 pb-lg-0" style="visibility: visible; animation-name: fadeInUp;">&lt;/h2&gt;</pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Фаза</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">% от LCP</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">600 мс</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">TTFB</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">2%</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Время</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Задержка загрузки</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">0%</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">0 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Время загрузки</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">0%</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">0 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Задержка отрисовки</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">98%</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">31 240 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Сократите время выполнения кода JavaScript <span
                                                class="performance-info-block-tabs-open-text red">-- 3,4 сек.</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Минимизируйте работу в основном потоке <span
                                                class="performance-info-block-tabs-open-text red">-- 6,1 сек.</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Уменьшите влияние стороннего кода <span
                                                class="performance-info-block-tabs-open-text red">-- Сторонний код заблокировал основной поток на 1 340 мс.</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Устраните ресурсы, блокирующие отображение <span
                                                class="performance-info-block-tabs-open-text red">-- Потенциальная экономия – 1 860 мс</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Удалите неиспользуемый код CSS <span
                                                class="performance-info-block-tabs-open-text red">-- Потенциальная экономия – 116 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Сократите размер структуры DOM <span
                                                class="performance-info-block-tabs-open-text red">-- 1 153 элемента</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Удалите неиспользуемый код JavaScript <span
                                                class="performance-info-block-tabs-open-text red">-- Потенциальная экономия – 250 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Уменьшите размер кода JavaScript <span
                                                class="performance-info-block-tabs-open-text red">-- Потенциальная экономия – 12 КиБ.</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13" />
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Отложите загрузку скрытых изображений <span
                                                class="performance-info-block-tabs-open-text red">-- Потенциальная экономия – 606 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Для изображений не заданы явным образом атрибуты <span class="performance-info-block-tabs-open-text blue">width</span> и <span class="performance-info-block-tabs-open-text blue">height.</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Уменьшите размер кода CSS <span class="performance-info-block-tabs-open-text yellow">-- Потенциальная экономия – 28 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Используйте современные форматы изображений <span class="performance-info-block-tabs-open-text yellow">-- Потенциальная экономия – 6 046 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Задайте правила эффективного использования кеша для статических объектов <span class="performance-info-block-tabs-open-text yellow">-- Найдено 79 ресурсов</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Настройте подходящий размер изображений <span class="performance-info-block-tabs-open-text yellow">-- Потенциальная экономия – 8 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Настройте эффективную кодировку изображений <span class="performance-info-block-tabs-open-text yellow">-- Потенциальная экономия – 294 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Не отправляйте устаревший код JavaScript в современные браузеры <span class="performance-info-block-tabs-open-text yellow">-- Потенциальная экономия – 25 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="6.27817" height="6.27817" fill="#FFA400"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Предотвратите чрезмерную нагрузку на сеть<span class="performance-info-block-tabs-open-text yellow">-- Общий размер достиг 8 763 КиБ</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Избегайте длительных задач в основном потоке <span class="performance-info-block-tabs-open-text grey">-- Обнаружено 20 длительных задач</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Метки и промежутки пользовательского времени  <span class="performance-info-block-tabs-open-text grey">-- 8 временных меток</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Устраните большие смещения макета <span class="performance-info-block-tabs-open-text grey">-- 1 смещение макета</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Время до получения первого байта от сервера допустимое  <span class="performance-info-block-tabs-open-text grey">-- Загрузка корневого документа заняла 110 мс</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Старайтесь не допускать создания цепочек критических запросов <span class="performance-info-block-tabs-open-text grey">-- Найдено 30 цепочек</span></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                            stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Рекомендуем сократить время на обработку, компиляцию и выполнение скриптов JS. Для этого вы можете разбить код JS на небольшие фрагменты. Подробнее о том,  <a
                                                href="javascript:void(0);">как минимизировать работу в основном потоке…</a><button class="performance-info-block-tabs-hidden-button">TBT</button></p>
                                        
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Категория</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-title">Потраченное время</p>
                                            </div>
                                            <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">Script Evaluation</p>
                                                <p class="performance-info-block-tabs-hidden-block-elem-text">3 332 мс</p>
                                            </div>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Other</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">1 149 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Style & Layout</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">524 мс</p>
                                            
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Garbage Collection</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">470 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Rendering</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">256 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Script Parsing & Compilation</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">224 мс</p>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-border-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">Parse HTML & CSS</p>
                                            <p class="performance-info-block-tabs-hidden-block-elem-text">116 мс</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="performance-info-block-tabs-open-wrap-bottom-text">Подробная информация о производительности вашего приложения. Эти цифры не влияют на показатель производительности <a href="javascript:void(0);">напрямую.</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="performance-info-block-tabs-block-show performance-info-block--js"
                        data-thumb="performance-tab-2">
                        <p></p>
                    </div>
                </div>
                <div class="successful-audits">
                    <div class="successful-audits-wrap">
                        <div class="successful-audits-block-title">
                            <h2>Успешные аудиты (13)</h2>
                            <p id="successful-audits-open" class="site-perfomance-block-open-second">Показать</p>
                        </div>
                        <div class="successful-audits-hidden-tabs-wrap">
                            <div class="successful-audits-hidden-tabs">
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Включите сжатие текста</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Избегайте большого количества переадресаций</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Используйте видеоформаты для анимированного контента</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Удалите повторяющиеся модули из пакетов JavaScript</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Используйте предварительное подключение к необходимым доменам</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Предзагрузите изображение для элемента "Отрисовка самого крупного контента"</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Показ всего текста во время загрузки веб-шрифтов</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Фасадные объекты сторонних ресурсов для отложенной загрузки</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Изображение, которое отображается при отрисовке самого крупного контента, загружено без задержки</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Пассивные прослушиватели событий используются для улучшения производительности при прокрутке</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Метод <span class="performance-info-block-tabs-open-text blue"> document.write()</span> не используется</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Избегайте некомбинированных анимаций</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Присутствует метатег <span class="performance-info-block-tabs-open-text blue"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport"&gt;</pre></span> со свойством <span class="performance-info-block-tabs-open-text blue">width</span>  или   <span class="performance-info-block-tabs-open-text blue">initial-scale</span></p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1"
                                                stroke="#919191" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a
                                                    href="javascript:void(0);">Подробнее о сжатии текста… </a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="special-features">
                    <div class="special-features-wrap">
                        <div class="special-features-wrap-block">
                            <svg width="182" height="182" viewBox="0 0 182 182" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="91" cy="91" r="91" fill="#FFA400" fill-opacity="0.25"/>
                                <path d="M91 4.28093C91 1.91664 92.918 -0.0105067 95.2797 0.10065C113.505 0.958435 131.088 7.2789 145.719 18.2893C161.492 30.1594 172.977 46.8367 178.443 65.8056C183.908 84.7745 183.057 105.006 176.018 123.449C168.979 141.892 156.133 157.546 139.419 168.049C122.705 178.553 103.028 183.336 83.3576 181.679C63.6867 180.021 45.0884 172.011 30.368 158.858C15.6475 145.706 5.60326 128.123 1.75023 108.762C-1.82374 90.8031 0.108978 72.2181 7.24176 55.4252C8.16607 53.2491 10.7345 52.3569 12.8647 53.3825C14.995 54.4081 15.8794 56.9628 14.9657 59.1435C8.63247 74.2588 6.93602 90.9538 10.1474 107.091C13.6379 124.63 22.7372 140.558 36.0726 152.474C49.4081 164.389 66.2565 171.645 84.0766 173.147C101.897 174.649 119.722 170.315 134.864 160.8C150.005 151.285 161.642 137.104 168.019 120.396C174.396 103.688 175.167 85.3602 170.216 68.176C165.264 50.9919 154.86 35.8837 140.571 25.1304C127.424 15.237 111.646 9.52345 95.2794 8.67297C92.9183 8.55027 91 6.64523 91 4.28093Z" fill="#FFA400"/>
                                <path d="M72.844 116H65.024L81.48 75.2H58.836V68.4H89.572V74.452L72.844 116ZM110.978 67.72C114.06 67.72 116.871 68.4453 119.41 69.896C121.994 71.3467 124.011 73.3187 125.462 75.812C126.958 78.26 127.706 80.98 127.706 83.972C127.706 85.7853 127.411 87.5533 126.822 89.276C126.232 90.9987 125.552 92.4493 124.782 93.628L110.366 116H102.342L113.018 99.204C112.02 99.4307 110.955 99.544 109.822 99.544C107.011 99.544 104.404 98.864 102.002 97.504C99.599 96.144 97.695 94.2853 96.2897 91.928C94.8843 89.5707 94.1817 86.9187 94.1817 83.972C94.1817 80.98 94.907 78.26 96.3577 75.812C97.8537 73.3187 99.871 71.3467 102.41 69.896C104.994 68.4453 107.85 67.72 110.978 67.72ZM110.978 93.492C112.746 93.492 114.355 93.084 115.806 92.268C117.302 91.4067 118.458 90.2507 119.274 88.8C120.135 87.3493 120.566 85.74 120.566 83.972C120.566 81.252 119.636 78.9853 117.778 77.172C115.964 75.3133 113.698 74.384 110.978 74.384C108.212 74.384 105.9 75.3133 104.042 77.172C102.228 78.9853 101.322 81.252 101.322 83.972C101.322 85.74 101.73 87.3493 102.546 88.8C103.407 90.2507 104.563 91.4067 106.014 92.268C107.51 93.084 109.164 93.492 110.978 93.492Z" fill="#FFA400"/>
                            </svg>
                            <p class="special-features-wrap-block-title">Специальные возможности</p>
                            <div class="special-features-wrap-block-text">
                                <p class="special-features-wrap-block-title-text">Узнайте, какие трудности могут возникнуть у людей с ограниченными возможностями при использовании вашего веб-приложения, <a href="javascript:void(0);">и сделайте его доступнее.</a> Автоматические проверки не гарантируют доступность приложения, поэтому мы рекомендуем выполнять <a href="javascript:void(0);">тестирование вручную.</a> Оно поможет выявить оставшиеся проблемы.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="recommendations">
                    <div class="recommendations-wrap">
                        <h2>рекомендации</h2>
                        <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                            <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                <div class="performance-info-block-tabs-open-left">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13"></path>
                                    </svg>
                                    <p class="performance-info-block-tabs-open-text">Атрибут <span class="performance-info-block-tabs-open-text blue">[user-scalable="no"]</span> используется в элементе<pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport"&gt;</pre></span> или значение атрибута<span class="performance-info-block-tabs-open-text blue">[maximum-scale]</span> меньше 5 </p>
                                </div>
                                <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                            </div>
                            <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1" style="display: none;">
                                <div class="performance-info-block-tabs-hidden-block-top">
                                    <p>Не отключайте масштабирование. Эта функция помогает слабовидящим пользователям читать информацию на веб-страницах. <a href="javascript:void(0);">Подробнее о метатеге viewport…</a></p>
                                </div>
                                <div class="performance-info-block-tabs-hidden-block-phase-second">
                                    <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-title">Неподходящие элементы</p>
                                        </div>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"&gt;</pre></p>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0"&gt;</pre></p>
                                    </div>
                                </div>
                            </div>
                            <p class="performance-info-block-tabs-open-wrap-bottom-text-second">Проверьте, соответствует ли ваш сайт рекомендациям по оптимизации для поисковых систем.</p>
                        </div>
                        <h2>интернационализация и локализация</h2>
                        <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                            <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                <div class="performance-info-block-tabs-open-left">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13"></path>
                                    </svg>
                                    <p class="performance-info-block-tabs-open-text">Для элемента <pre class="performance-info-block-tabs-open-text blue">&lt;html&gt;</pre></span>не задан атрибут<span class="performance-info-block-tabs-open-text blue">[lang]</span> </p>
                                </div>
                                <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                            </div>
                            <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1" style="display: none;">
                                <div class="performance-info-block-tabs-hidden-block-top">
                                    <p>Не отключайте масштабирование. Эта функция помогает слабовидящим пользователям читать информацию на веб-страницах. <a href="javascript:void(0);">Подробнее о метатеге viewport…</a></p>
                                </div>
                                <div class="performance-info-block-tabs-hidden-block-phase-second">
                                    <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-title">Неподходящие элементы</p>
                                        </div>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"&gt;</pre></p>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0"&gt;</pre></p>
                                    </div>
                                </div>
                            </div>
                            <p class="performance-info-block-tabs-open-wrap-bottom-text-second">Проверьте, правильно ли заданы атрибуты языков для программ чтения с экрана.</p>
                        </div>
                        <h2>названия и ярлыки</h2>
                        <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                            <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                <div class="performance-info-block-tabs-open-left">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13"></path>
                                    </svg>
                                    <p class="performance-info-block-tabs-open-text">Элементам формы не присвоены соответствующие ярлыки</p>
                                </div>
                                <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                            </div>
                            <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1" style="display: none;">
                                <div class="performance-info-block-tabs-hidden-block-top">
                                    <p>Не отключайте масштабирование. Эта функция помогает слабовидящим пользователям читать информацию на веб-страницах. <a href="javascript:void(0);">Подробнее о метатеге viewport…</a></p>
                                </div>
                                <div class="performance-info-block-tabs-hidden-block-phase-second">
                                    <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-title">Неподходящие элементы</p>
                                        </div>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"&gt;</pre></p>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0"&gt;</pre></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                            <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                <div class="performance-info-block-tabs-open-left">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13"></path>
                                    </svg>
                                    <p class="performance-info-block-tabs-open-text">Текст ссылок неразличим для программ чтения с экрана</p>
                                </div>
                                <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                            </div>
                            <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1" style="display: none;">
                                <div class="performance-info-block-tabs-hidden-block-top">
                                    <p>Не отключайте масштабирование. Эта функция помогает слабовидящим пользователям читать информацию на веб-страницах. <a href="javascript:void(0);">Подробнее о метатеге viewport…</a></p>
                                </div>
                                <div class="performance-info-block-tabs-hidden-block-phase-second">
                                    <div class="performance-info-block-tabs-hidden-block-phase-top-second">
                                        <div class="performance-info-block-tabs-hidden-block-phase-block-second">
                                            <p class="performance-info-block-tabs-hidden-block-elem-title">Неподходящие элементы</p>
                                        </div>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"&gt;</pre></p>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden-block-phase-block-border-third">
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third">head > meta</p>
                                        <p class="performance-info-block-tabs-hidden-block-elem-text-third"><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0"&gt;</pre></p>
                                    </div>
                                </div>
                            </div>
                            <p class="performance-info-block-tabs-open-wrap-bottom-text-second">Проверьте, насколько элементы управления в вашем приложении различимы для программ чтения с экрана.</p>
                        </div>
                        <div class="recommendations-wrap-block-title">
                            <h2>Дополнительный объекты для проверки вручную</h2>
                            <p class="site-perfomance-block-open-second" id="successful-audits-open-second">Показать</p>
                        </div>
                        <div class="object-hand-wrap">
                            <div class="successful-audits-hidden-tabs-second">
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Interactive controls are keyboard focusable</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Custom interactive controls are keyboard focusable and display a focus indicator  <a href="javascript:void(0);">Learn how to make custom controls focusable.</a></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Interactive elements indicate their purpose and state</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Custom interactive controls are keyboard focusable and display a focus indicator  <a href="javascript:void(0);">Learn how to make custom controls focusable.</a></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">The page has a logical tab order</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Custom interactive controls are keyboard focusable and display a focus indicator  <a href="javascript:void(0);">Learn how to make custom controls focusable.</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="performance-info-block-tabs-open-wrap-bottom-text-second">Ручная проверка позволяет охватить области, которые невозможно протестировать автоматически. Подробнее<a href="javascript:void(0);"> о проверке специальных возможностей…</a></p>
                            <div class="recommendations-wrap-block-title-border">
                                <h2>успешные аудиты (20)</h2>
                                <p class="site-perfomance-block-open-second" id="successful-audits-open-third">Показать</p>
                            </div>
                            <div class="successful-audits-hidden-tabs-third">
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Включите сжатие текста</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Избегайте большого количества переадресаций</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Используйте видеоформаты для анимированного контента</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Удалите повторяющиеся модули из пакетов JavaScript</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Используйте предварительное подключение к необходимым доменам</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Предзагрузите изображение для элемента "Отрисовка самого крупного контента"</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Показ всего текста во время загрузки веб-шрифтов</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Фасадные объекты сторонних ресурсов для отложенной загрузки</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Изображение, которое отображается при отрисовке самого крупного контента, загружено без задержки</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Пассивные прослушиватели событий используются для улучшения производительности при прокрутке</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Метод <span class="performance-info-block-tabs-open-text blue">&nbsp;document.write()</span>&nbsp;не используется</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Избегайте некомбинированных анимаций</p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                    <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-open-left">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                            </svg>
                                            <p class="performance-info-block-tabs-open-text">Присутствует метатег&nbsp;<span class="performance-info-block-tabs-open-text blue"></span></p><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport"&gt;</pre>&nbsp;со свойством&nbsp;<span class="performance-info-block-tabs-open-text blue">width</span> &nbsp;или&nbsp;  <span class="performance-info-block-tabs-open-text blue">initial-scale</span><p></p>
                                        </div>
                                        <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                    <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                        <div class="performance-info-block-tabs-hidden-block-top">
                                            <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="recommendations-wrap-block-title-border-third">
                            <h2>Неприменимо (32)</h2>
                            <p class="site-perfomance-block-open-second" id="successful-audits-open-four">Показать</p>
                        </div>
                        <div class="successful-audits-hidden-tabs-four">
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Включите сжатие текста</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Избегайте большого количества переадресаций</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Используйте видеоформаты для анимированного контента</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Удалите повторяющиеся модули из пакетов JavaScript</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Используйте предварительное подключение к необходимым доменам</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Предзагрузите изображение для элемента "Отрисовка самого крупного контента"</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Показ всего текста во время загрузки веб-шрифтов</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Фасадные объекты сторонних ресурсов для отложенной загрузки</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Изображение, которое отображается при отрисовке самого крупного контента, загружено без задержки</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Пассивные прослушиватели событий используются для улучшения производительности при прокрутке</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Метод <span class="performance-info-block-tabs-open-text blue">&nbsp;document.write()</span>&nbsp;не используется</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"></rect>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Избегайте некомбинированных анимаций</p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-open-left">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="#0CCE6A"></circle>
                                        </svg>
                                        <p class="performance-info-block-tabs-open-text">Присутствует метатег&nbsp;<span class="performance-info-block-tabs-open-text blue"></span></p><pre class="performance-info-block-tabs-open-text blue">&lt;meta name="viewport"&gt;</pre>&nbsp;со свойством&nbsp;<span class="performance-info-block-tabs-open-text blue">width</span> &nbsp;или&nbsp;  <span class="performance-info-block-tabs-open-text blue">initial-scale</span><p></p>
                                    </div>
                                    <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                    <div class="performance-info-block-tabs-hidden-block-top">
                                        <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="recommendations-green-wrap">
                            <div class="recommendations-green-wrap-block">
                                <svg width="182" height="182" viewBox="0 0 182 182" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="91" cy="91" r="91" fill="#0CCE6A" fill-opacity="0.15"/>
                                    <path d="M91 4.28093C91 1.91664 92.9178 -0.0105148 95.2795 0.1006C116.703 1.10855 137.136 9.65889 152.92 24.3146C169.752 39.9435 180.051 61.3592 181.75 84.2651C183.45 107.171 176.425 129.872 162.085 147.815C147.745 165.757 127.15 177.613 104.433 181.003C81.7157 184.394 58.5566 179.068 39.6023 166.095C20.6479 153.122 7.30045 133.461 2.23791 111.057C-2.82463 88.6532 0.772257 65.1635 12.3069 45.301C23.1234 26.6752 40.1695 12.5311 60.3649 5.31158C62.5912 4.51571 64.9881 5.7989 65.6785 8.06015C66.3689 10.3214 65.0904 12.7036 62.868 13.5103C44.7386 20.0914 29.4419 32.844 19.7109 49.6007C9.26147 67.5944 6.003 88.874 10.5892 109.17C15.1754 129.466 27.2671 147.277 44.4381 159.03C61.6091 170.782 82.5892 175.607 103.169 172.535C123.749 169.463 142.406 158.723 155.397 142.469C168.388 126.215 174.752 105.649 173.212 84.8987C171.672 64.148 162.342 44.7472 147.094 30.5888C132.894 17.4038 114.54 9.67353 95.2794 8.67293C92.9183 8.55027 91 6.64523 91 4.28093Z" fill="#0CCE6A"/>
                                    <path d="M73.38 67.72C76.4627 67.72 79.2733 68.4453 81.812 69.896C84.396 71.3467 86.4133 73.3187 87.864 75.812C89.36 78.26 90.108 80.98 90.108 83.972C90.108 85.7853 89.8133 87.5533 89.224 89.276C88.6347 90.9987 87.9547 92.4493 87.184 93.628L72.768 116H64.744L75.42 99.204C74.4227 99.4307 73.3573 99.544 72.224 99.544C69.4133 99.544 66.8067 98.864 64.404 97.504C62.0013 96.144 60.0973 94.2853 58.692 91.928C57.2867 89.5707 56.584 86.9187 56.584 83.972C56.584 80.98 57.3093 78.26 58.76 75.812C60.256 73.3187 62.2733 71.3467 64.812 69.896C67.396 68.4453 70.252 67.72 73.38 67.72ZM73.38 93.492C75.148 93.492 76.7573 93.084 78.208 92.268C79.704 91.4067 80.86 90.2507 81.676 88.8C82.5373 87.3493 82.968 85.74 82.968 83.972C82.968 81.252 82.0387 78.9853 80.18 77.172C78.3667 75.3133 76.1 74.384 73.38 74.384C70.6147 74.384 68.3027 75.3133 66.444 77.172C64.6307 78.9853 63.724 81.252 63.724 83.972C63.724 85.74 64.132 87.3493 64.948 88.8C65.8093 90.2507 66.9653 91.4067 68.416 92.268C69.912 93.084 71.5667 93.492 73.38 93.492ZM111.855 84.856C114.665 84.856 117.272 85.536 119.675 86.896C122.077 88.256 123.981 90.1147 125.387 92.472C126.792 94.8293 127.495 97.4813 127.495 100.428C127.495 103.42 126.747 106.163 125.251 108.656C123.8 111.104 121.783 113.053 119.199 114.504C116.66 115.955 113.849 116.68 110.767 116.68C107.639 116.68 104.783 115.955 102.199 114.504C99.6601 113.053 97.6427 111.104 96.1467 108.656C94.6961 106.163 93.9707 103.42 93.9707 100.428C93.9707 98.5693 94.2654 96.7787 94.8547 95.056C95.4441 93.3333 96.1241 91.9053 96.8947 90.772L111.311 68.4H119.403L108.659 85.196C110.019 84.9693 111.084 84.856 111.855 84.856ZM110.767 110.016C113.487 110.016 115.753 109.109 117.567 107.296C119.425 105.437 120.355 103.148 120.355 100.428C120.355 98.66 119.924 97.0507 119.063 95.6C118.247 94.1493 117.091 93.016 115.595 92.2C114.144 91.3387 112.535 90.908 110.767 90.908C108.953 90.908 107.299 91.3387 105.803 92.2C104.352 93.016 103.196 94.1493 102.335 95.6C101.519 97.0507 101.111 98.66 101.111 100.428C101.111 103.148 102.017 105.437 103.831 107.296C105.689 109.109 108.001 110.016 110.767 110.016Z" fill="#0CCE6A"/>
                                </svg>
                                <p>Рекомендации</p>
                            </div>
                            <div class="recommendations-green-wrap-block-wrapper">
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-second">
                                        <h2>общие рекомендации</h2>
                                    </div>
                                    <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                        <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-open-left">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13"/>
                                                </svg>
                                                <p class="performance-info-block-tabs-open-text">Ошибки браузера занесены в журнал консоли</p>
                                            </div>
                                            <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                            </svg>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-hidden-block-top">
                                                <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                        <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-open-left">
                                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                                </svg>
                                                <p class="performance-info-block-tabs-open-text">Обнаруженные библиотеки JavaScript</p>
                                            </div>
                                            <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                            </svg>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-hidden-block-top">
                                                <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-second">
                                        <h2>надежность и безопасность</h2>
                                    </div>
                                    <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                        <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-open-left">
                                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect y="4.43945" width="6.27817" height="6.27817" transform="rotate(-45 0 4.43945)" fill="#D9D9D9"/>
                                                </svg>
                                                <p class="performance-info-block-tabs-open-text">Убедитесь, что политика CSP эффективна против атак XSS</p>
                                            </div>
                                            <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                            </svg>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-hidden-block-top">
                                                <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-second">
                                        <h2>Успешные аудиты (14)</h2>
                                        <p class="site-perfomance-block-open-second">Показать</p>
                                    </div>
                                </div>
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-third">
                                        <h2>Неприменимо (1)</h2>
                                        <p class="site-perfomance-block-open-second">Показать</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="optimization-green-wrap">
                            <div class="optimization-green-wrap-block">
                                <svg width="182" height="182" viewBox="0 0 182 182" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="91" cy="91" r="91" fill="#0CCE6A" fill-opacity="0.15"/>
                                    <path d="M91 4.28093C91 1.91664 92.918 -0.0105093 95.2797 0.100632C114.981 1.02776 133.892 8.33611 149.126 20.9834C165.461 34.544 176.54 53.389 180.446 74.2565C184.353 95.124 180.84 116.7 170.516 135.251C160.193 153.802 143.708 168.16 123.915 175.839C104.123 183.518 82.2683 184.035 62.1348 177.301C42.0012 170.566 24.8557 157.005 13.6661 138.963C2.47648 120.922 -2.05299 99.5353 0.861714 78.5064C3.58009 58.8939 12.614 40.7435 26.5347 26.772C28.2035 25.0971 30.9193 25.2265 32.5139 26.9721C34.1084 28.7178 33.9769 31.4181 32.3163 33.1011C19.8663 45.7193 11.7866 62.0483 9.34251 79.6819C6.70204 98.7323 10.8053 118.106 20.9422 134.451C31.079 150.795 46.6113 163.08 64.8506 169.181C83.0899 175.281 102.888 174.813 120.818 167.856C138.749 160.9 153.682 147.893 163.035 131.088C172.387 114.282 175.569 94.736 172.031 75.8318C168.492 56.9277 158.455 39.8557 143.657 27.571C129.96 16.1998 112.982 9.59276 95.2794 8.67296C92.9183 8.55027 91 6.64523 91 4.28093Z" fill="#0CCE6A"/>
                                    <path d="M73.38 67.72C76.4627 67.72 79.2733 68.4453 81.812 69.896C84.396 71.3467 86.4133 73.3187 87.864 75.812C89.36 78.26 90.108 80.98 90.108 83.972C90.108 85.7853 89.8133 87.5533 89.224 89.276C88.6347 90.9987 87.9547 92.4493 87.184 93.628L72.768 116H64.744L75.42 99.204C74.4227 99.4307 73.3573 99.544 72.224 99.544C69.4133 99.544 66.8067 98.864 64.404 97.504C62.0013 96.144 60.0973 94.2853 58.692 91.928C57.2867 89.5707 56.584 86.9187 56.584 83.972C56.584 80.98 57.3093 78.26 58.76 75.812C60.256 73.3187 62.2733 71.3467 64.812 69.896C67.396 68.4453 70.252 67.72 73.38 67.72ZM73.38 93.492C75.148 93.492 76.7573 93.084 78.208 92.268C79.704 91.4067 80.86 90.2507 81.676 88.8C82.5373 87.3493 82.968 85.74 82.968 83.972C82.968 81.252 82.0387 78.9853 80.18 77.172C78.3667 75.3133 76.1 74.384 73.38 74.384C70.6147 74.384 68.3027 75.3133 66.444 77.172C64.6307 78.9853 63.724 81.252 63.724 83.972C63.724 85.74 64.132 87.3493 64.948 88.8C65.8093 90.2507 66.9653 91.4067 68.416 92.268C69.912 93.084 71.5667 93.492 73.38 93.492ZM94.9907 116V109.948L114.439 90.228C115.708 88.9133 116.615 87.712 117.159 86.624C117.748 85.4907 118.043 84.108 118.043 82.476C118.043 80.164 117.272 78.26 115.731 76.764C114.235 75.268 112.308 74.52 109.951 74.52C107.639 74.52 105.689 75.3813 104.103 77.104C102.516 78.7813 101.723 80.9347 101.723 83.564H94.5827C94.5827 80.5267 95.2174 77.8067 96.4867 75.404C97.8014 73.0013 99.6147 71.12 101.927 69.76C104.284 68.4 106.959 67.72 109.951 67.72C112.943 67.72 115.595 68.3547 117.907 69.624C120.219 70.848 122.009 72.5933 123.279 74.86C124.593 77.0813 125.251 79.62 125.251 82.476C125.251 85.1053 124.707 87.372 123.619 89.276C122.576 91.1347 120.967 93.1293 118.791 95.26L105.395 108.928V109.268H125.999V116H94.9907Z" fill="#0CCE6A"/>
                                </svg>
                                <p class="optimization-green-wrap-block-title">Поисковая оптимизация</p>
                                <div class="optimization-green-block">
                                    <p class="optimization-green-wrap-block-text">Эти проверки позволяют узнать, соответствует ли страница основным рекомендациям к поисковой оптимизации. Lighthouse оценивает не все факторы, которые могут повлиять на позицию сайта в результатах поиска (например, производительность по <a href="javascript:void(0);">основным интернет-показателям).</a> Подробнее <a href="javascript:void(0);">о факторах, важных для Google Поиска…</a></p>
                                </div>
                            </div>
                            <div class="recommendations-green-wrap-block-wrapper">
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-second">
                                        <h2>сканирование и индексирование</h2>
                                    </div>
                                    <div class="performance-info-block-tabs-open-wrap parameter-wrap--js">
                                        <div class="performance-info-block-tabs-open tabs-open--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-open-left">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 0L9.33013 7.5H0.669873L5 0Z" fill="#FF5A13"></path>
                                                </svg>
                                                <p class="performance-info-block-tabs-open-text">Ссылки невозможно просканировать</p>
                                            </div>
                                            <svg class="performance-info-block-tabs-open-svg-rotate" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L4.64645 4.64645C4.84171 4.84171 5.15829 4.84171 5.35355 4.64645L9 1" stroke="#919191" stroke-width="1.5" stroke-linecap="round"></path>
                                            </svg>
                                        </div>
                                        <div class="performance-info-block-tabs-hidden parameter-block--js" data-thumb="open-tab1">
                                            <div class="performance-info-block-tabs-hidden-block-top">
                                                <p>Чтобы уменьшить расход сетевого трафика, рекомендуем сжимать текстовые ресурсы (используйте gzip, deflate или brotli).  <a href="javascript:void(0);">Подробнее&nbsp;о сжатии текста…&nbsp;</a><button class="performance-info-block-tabs-hidden-button">LCP</button> <button class="performance-info-block-tabs-hidden-button">FCP</button></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <p class="performance-info-block-tabs-open-text-second">Чтобы ваше приложение появлялось в результатах поиска, предоставьте доступ к нему поисковым роботам.</p>
                                </div>
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-second">
                                        <h2>Дополнительный объекты для проверки вручную (1)</h2>
                                        <p class="site-perfomance-block-open-second">Показать</p>
                                    </div>
                                    <p class="performance-info-block-tabs-open-text-second">Чтобы ваше приложение появлялось в результатах поиска, предоставьте доступ к нему поисковым роботам.</p>
                                </div>
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-second">
                                        <h2>Успешные аудиты (8)</h2>
                                        <p class="site-perfomance-block-open-second">Показать</p>
                                    </div>
                                </div>
                                <div class="recommendations-green-wrap-block-wrapper-block">
                                    <div class="recommendations-wrap-block-title-border-third">
                                        <h2>Неприменимо (1)</h2>
                                        <p class="site-perfomance-block-open-second">Показать</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="/front/js.js"></script>
    </footer>
</body>
<script>
    $(document).ready(function() {
    $("#form").submit(function (e) {
    e.preventDefault();
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
                $('.response').load('responses/<?php echo $ses_id; ?>.json', function() {
                    console.log('Данные успешно загружены');
                });
            },
        });
    }
    return false;
    }); 
});
</script>
</html>