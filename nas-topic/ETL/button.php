<?php
$postData = $_POST['data'];

if ($postData == '1') {
    $logFile = fopen("button_logs.txt", "a");

    if ($logFile) {
        fwrite($logFile, "Button pressed - " . date("Y-m-d H:i:s") . "\n");
        fclose($logFile);
        echo "Button pressed data received and logged.";

        $channelAccessToken = 'RYx398mxwhtxFlsC6DT7bQBFn3iSDYlr+Qtrdcz4IYnq0Wj1/4vdyuuAcOOiSMEUroDLhPw9kVk4wYXAt8yP6hcHPUqy3r/eRXFB1/4IRPZ4gR2OenZ84CdKMgdo7i7YYXv//5EEG4lWg+lNkeCP1AdB04t89/1O/w1cDnyilFU=';
        $userId = 'U2059804cf115fe02c13b4b87d1e12a68';
        $url = 'https://api.line.me/v2/bot/message/push';
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $channelAccessToken
        );

        $lineData = '{
            "to": "' . $userId . '",
            "messages": [
                {
                    "type": "flex",
                    "altText": "⚠️來自ESP32緊急通知⚠️",
                    "contents": {
                        "type": "bubble",
                        "size": "mega",
                        "header": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "⚠️來自ESP32緊急通知⚠️",
                                            "color": "#FF0000",
                                            "size": "md",
                                            "offsetStart": "none",
                                            "action": {
                                                "type": "postback",
                                                "label": "action",
                                                "data": "hello"
                                            },
                                            "weight": "bold"
                                        },
                                        {
                                            "type": "text",
                                            "text": " ",
                                            "margin": "sm"
                                        },
                                        {
                                            "type": "text",
                                            "text": "請馬上關注家庭老人狀況",
                                            "color": "#ffffff",
                                            "size": "xl",
                                            "flex": 4,
                                            "weight": "bold"
                                        }
                                    ]
                                }
                            ],
                            "paddingAll": "20px",
                            "backgroundColor": "#61BC8B",
                            "spacing": "md",
                            "height": "130px",
                            "paddingTop": "22px"
                        },
                        "body": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "' . date("H:i") . '",
                                            "size": "sm",
                                            "gravity": "center"
                                        },
                                        {
                                            "type": "box",
                                            "layout": "vertical",
                                            "contents": [
                                                {
                                                    "type": "filler"
                                                },
                                                {
                                                    "type": "box",
                                                    "layout": "vertical",
                                                    "contents": [],
                                                    "cornerRadius": "30px",
                                                    "height": "12px",
                                                    "width": "12px",
                                                    "borderColor": "#EF454D",
                                                    "borderWidth": "2px"
                                                },
                                                {
                                                    "type": "filler"
                                                }
                                            ],
                                            "flex": 0
                                        },
                                        {
                                            "type": "text",
                                            "text": "發送通知",
                                            "gravity": "center",
                                            "flex": 4,
                                            "size": "sm",
                                            "action": {
                                                "type": "uri",
                                                "label": "action",
                                                "uri": "https://topics.paki91.com/ETL/button_logs.txt"
                                            }
                                        }
                                    ],
                                    "spacing": "lg",
                                    "cornerRadius": "30px",
                                    "margin": "xxl"
                                },
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "contents": [
                                        {
                                            "type": "box",
                                            "layout": "baseline",
                                            "contents": [
                                                {
                                                    "type": "filler"
                                                }
                                            ],
                                            "flex": 1
                                        },
                                        {
                                            "type": "box",
                                            "layout": "vertical",
                                            "contents": [
                                                {
                                                    "type": "box",
                                                    "layout": "horizontal",
                                                    "contents": [
                                                        {
                                                            "type": "filler"
                                                        },
                                                        {
                                                            "type": "box",
                                                            "layout": "vertical",
                                                            "contents": [],
                                                            "width": "2px",
                                                            "backgroundColor": "#B7B7B7"
                                                        },
                                                        {
                                                            "type": "filler"
                                                        }
                                                    ],
                                                    "flex": 1
                                                }
                                            ],
                                            "width": "12px"
                                        },
                                        {
                                            "type": "text",
                                            "text": "進行中",
                                            "gravity": "center",
                                            "flex": 4,
                                            "size": "xs",
                                            "color": "#8c8c8c"
                                        }
                                    ],
                                    "spacing": "lg",
                                    "height": "80px"
                                },
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": []
                                },
                                {
                                    "type": "button",
                                    "action": {
                                        "type": "uri",
                                        "label": "📞+110 | 警察報案",
                                        "uri": "tel:110"
                                    },
                                    "margin": "xxl",
                                    "style": "primary",
                                    "color": "#E64949"
                                },
                                {
                                    "type": "button",
                                    "action": {
                                        "type": "uri",
                                        "label": "📞+119 | 消防署救護車",
                                        "uri": "tel:119"
                                    },
                                    "margin": "xxl",
                                    "style": "primary",
                                    "color": "#E64949"
                                }
                            ]
                        }
                    }
                }
            ]
        }';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $lineData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        echo $response;
    }
}
?>
