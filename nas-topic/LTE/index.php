<?php
$channelToken = 'RYx398mxwhtxFlsC6DT7bQBFn3iSDYlr+Qtrdcz4IYnq0Wj1/4vdyuuAcOOiSMEUroDLhPw9kVk4wYXAt8yP6hcHPUqy3r/eRXFB1/4IRPZ4gR2OenZ84CdKMgdo7i7YYXv//5EEG4lWg+lNkeCP1AdB04t89/1O/w1cDnyilFU=';
$userId = 'U2059804cf115fe02c13b4b87d1e12a68';

$start_time = round(microtime(true) * 1000); // 運行時間

date_default_timezone_set('Asia/Taipei'); // 設定時區
$content = file_get_contents("php://input"); // 接收 LINE API Webhook 請求
$data = json_decode($content, true); // 解析 JSON 數據

// 獲取 JSON 變數字段數據
$audio_id = $data['events'][0]['message']['id']; // 輸出：$audio_id = "id"
$type = $data['events'][0]['message']['type']; // 輸出：$type = "message"、"audio"
$durations = ($data['events'][0]['message']['duration']) / 1000; // 輸出：$durations = 語音信息長度
$text = $data['events'][0]['message']['text']; // 如果輸入文字 = Unicode，但是中文沒辦法輸出需要轉換
file_put_contents(__DIR__.'/line_logs/'.$audio_id.date('_Ymd_His')."_logs.txt", json_encode($data, JSON_PRETTY_PRINT), FILE_APPEND);

$logs_time = round(microtime(true) * 1000); // 運行時間

//***獲取語音信息的二進制數據***//
if ($type === "audio") { 
    $headers = array(   
        'Authorization: Bearer RYx398mxwhtxFlsC6DT7bQBFn3iSDYlr+Qtrdcz4IYnq0Wj1/4vdyuuAcOOiSMEUroDLhPw9kVk4wYXAt8yP6hcHPUqy3r/eRXFB1/4IRPZ4gR2OenZ84CdKMgdo7i7YYXv//5EEG4lWg+lNkeCP1AdB04t89/1O/w1cDnyilFU=',
        'Content-Type: audio/m4a', 
    );
    // 使用 cURL 執行 HTTP GET 請求，獲取語音二進制資料
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, 'https://api-data.line.me/v2/bot/message/'.$audio_id.'/content');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $audio_binary_data = curl_exec($ch);
    curl_close($ch);
    file_put_contents("m4a/".$audio_id . '.m4a', $audio_binary_data); // put m4a
    $wav_time = round(microtime(true) * 1000); // 運行時間
    exec("ffmpeg -i m4a/{$audio_id}.m4a -codec:a libmp3lame -qscale:a 2 mp3/{$audio_id}.mp3"); // ffmpeg m4a to mp3
    $mp3_time = round(microtime(true) * 1000); // 運行時間
    file_put_contents("audio.php","http://topic.paki91.com/LTE/mp3/".$audio_id.".mp3"); // 寫入audio.php文字
} 

if ($type === "text") {
    $text_fix = json_decode('"' . $text . '"'); // 輸出更正文字
    
    switch ($text_fix) {
            
        case "#選擇快捷信息":
            $message = [
    'to' => $userId,
    'messages' => [
        [
            'type' => 'text',
            'text' => '請選擇快捷句子：',
            'quickReply' => [
                'items' => [
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'message',
                            'label' => '好的',
                            'text' => '好的',
                        ],
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'message',
                            'label' => '不是',
                            'text' => '不是',
                        ],
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'message',
                            'label' => '怎麼了嗎',
                            'text' => '怎麼了嗎',
                        ],
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'message',
                            'label' => '在忙 稍等回復',
                            'text' => '在忙 稍等回復',
                        ],
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'message',
                            'label' => '記得吃飯哦',
                            'text' => '記得吃飯哦',
                        ],
                    ],
                ],
                
            ],
        ],
    ],
];
             $ch = curl_init('https://api.line.me/v2/bot/message/push');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $channelToken,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            break;
            
        case "#選擇電台頻道":
            $message = [
                'to' => $userId,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => '電台頻道如下：',
                        'quickReply' => [
                            'items' => [
                                [
                                    'type' => 'action',
                                    'action' => [
                                        'type' => 'message',
                                        'label' => '#FM90.1 城市廣播網 台北健康',
                                        'text' => '#FM90.1 城市廣播網 台北健康',
                                    ],
                                ],
                                [
                                    'type' => 'action',
                                    'action' => [
                                        'type' => 'message',
                                        'label' => '#FM98.3 高雄港都電台',
                                        'text' => '#FM98.3 高雄港都電台',
                                    ],
                                ],
                                [
                                    'type' => 'action',
                                    'action' => [
                                        'type' => 'message',
                                        'label' => '#FM99.7 台南都會聲音',
                                        'text' => '#FM99.7 台南都會聲音',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
            $ch = curl_init('https://api.line.me/v2/bot/message/push');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $channelToken,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            break;
        case "#FM99.7 台南都會聲音":
            file_put_contents('audio.php', "http://43.254.16.40:8000/TN.FM99.7");
            break;
        case "#FM98.3 高雄港都電台":
            file_put_contents('audio.php', "http://43.254.16.40:8000/KS.FM98.3");
            break;
        case "#FM90.1 城市廣播網 台北健康":
            file_put_contents('audio.php', "http://fm901.cityfm.tw:8080/901.mp3");
            break;
        default:
            if (substr($text_fix, 0, 1) === '#') {
                $message = [
                    'to' => $userId,
                    'messages' => [
                        [
                            'type' => 'text',
                            'text' => $text_fix.'為無效命令',
                        ],
                    ],
                ];

                $ch = curl_init('https://api.line.me/v2/bot/message/push');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $channelToken,
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
            } else {
                $googleurl = "https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&tl=zh-CN&q=" . urlencode($text_fix);
                $audioData = file_get_contents($googleurl);
                $fileName = "tls_" . date("Ymd_His") . ".mp3";
                file_put_contents("mp3/" . $fileName, $audioData);
                file_put_contents('audio.php', "http://topic.paki91.com/LTE/mp3/" . $fileName);
            }
            break;
    }
}

$logs_time1 = ($start_time - $logs_time) / 1000;
$wav_time1 = ($start_time - $wav_time) / 1000;
$mp3_time1 = ($start_time - $mp3_time) / 1000;
$end_time = round(microtime(true) * 1000);
$use_time1 = ($start_time - $end_time) / 1000;

$aulog_content =
    "Time : " . date('Y/m/d h:i:sA', time()) .
    " | ID : " . $audio_id .
    " | Processing Time: " . $use_time1 . "s" .
    " | Logs : " . $logs_time1 . "s" .
    " | Voice : " . $durations . "s" .
    " | WAV : " . $wav_time1 . "s" .
    " | MP3 : " . $mp3_time1 . "s" .
    "\n";

if ($type === "audio") {
    file_put_contents(__DIR__."/ffmpeg_logs.txt", $aulog_content, FILE_APPEND);
}

$textlog_content =
    "Time : " . date('Y/m/d h:i:sA', time()) .
    " | ID : " . $audio_id .
    " | Processing Time: " . $use_time1 . "s" .
    " | Logs : " . $logs_time1 . "s" .
    "\n";

if ($type === "text") {
    file_put_contents(__DIR__."/ffmpeg_logs.txt", $textlog_content, FILE_APPEND);
}
?>
