<?php
$access_token = 'RYx398mxwhtxFlsC6DT7bQBFn3iSDYlr+Qtrdcz4IYnq0Wj1/4vdyuuAcOOiSMEUroDLhPw9kVk4wYXAt8yP6hcHPUqy3r/eRXFB1/4IRPZ4gR2OenZ84CdKMgdo7i7YYXv//5EEG4lWg+lNkeCP1AdB04t89/1O/w1cDnyilFU='; // 替换为您的访问令牌
$userId = 'U2059804cf115fe02c13b4b87d1e12a68'; // 替换为接收消息的用户的Line用户ID

$servername = "localhost"; // MySQL服务器名称
$username = "root"; // MySQL用户名
$password = "QKV6yCs2ps.="; // MySQL密码
$dbname = "xkj"; // MySQL数据库名
$conn = mysqli_connect($servername, $username, $password, $dbname);// 创建连接

// 检测连接
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// 接受 ESP32 POST 的数据
    $dht22_temp1 = $_POST['dht22_temp1'];
    $dht22_humd1 = $_POST['dht22_humd1'];
    $dht22_temp2 = $_POST['dht22_temp2'];
    $dht22_humd2 = $_POST['dht22_humd2'];
    $scd40_temp = $_POST['scd40_temp'];
    $scd40_humd = $_POST['scd40_humd'];
    $scd40_co2 = $_POST['scd40_co2'];
    $bmp_temp = $_POST['bmp_temp'];
    $bmp_pressure = $_POST['bmp_pressure'];
    $bmp_altitude = $_POST['bmp_altitude'];
    $esp_pm1 = $_POST['esp_pm1'];
    $esp_pm25 = $_POST['esp_pm25'];
    $esp_pm100 = $_POST['esp_pm100'];
// 台灣中央氣象局 API 
$cwb_url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0001-001?Authorization=CWB-9164C5ED-C227-4AD9-947B-3EA579B94742&stationId=C0V810';	
$cwb_response = file_get_contents($cwb_url);	// 發送 GET 請求並取得回應
    // 解析 JSON 回應
      $cwb_data = json_decode($cwb_response, true);   
      $cwb_station = $cwb_data['records']['location'][0];	// 取得觀測站資料
      $cwb_temp = $cwb_station['weatherElement'][3]['elementValue']; // 取得目前的溫度
      $cwb_humd = $cwb_station['weatherElement'][4]['elementValue']; // 取得目前的濕度
      $cwb_humd = $cwb_humd * 100; //較正目前的濕度
      if ($cwb_humd == -9900){$cwb_humd = NULL;}
      if ($cwb_temp == -99){$cwb_temp = NULL;}

// 行政院環境保護署 API
$epa_url = 'https://data.moenv.gov.tw/api/v2/aqx_p_241?format=json&api_key=b00c9991-826c-4527-8c11-79720262618d&limit=6';	// 行政院環境保護署EPA API 網址
$epa_response = file_get_contents($epa_url);	// 發送 GET 請求並取得回應
    // 解析 JSON 回應
      $epa_data = json_decode($epa_response, true);   // 解析 JSON 回應
      $epa_pm25 = $epa_data['records'][0]['concentration']; //細懸浮微粒PM2.5
      $epa_pm10 = $epa_data['records'][2]['concentration']; //懸浮微粒PM10

$mathsql= $dht22_temp1*$dht22_humd1*$dht22_temp2*$dht22_humd2*$scd40_temp*$scd40_humd*$scd40_co2*$bmp_temp*$bmp_pressure*$bmp_altitude*$esp_pm1*$esp_pm25*$esp_pm100*$cwb_temp*$cwb_humd*$epa_pm25*$epa_pm10;//防止數據出現"0"

if ($mathsql != 0 ){
$sql = "INSERT INTO sensor_data (dht22_temp1, dht22_humd1, dht22_temp2, dht22_humd2, scd40_temp, scd40_humd, scd40_co2,
    bmp_temp, bmp_pressure, bmp_altitude, esp_pm1, esp_pm25, esp_pm100,cwb_temp, cwb_humd, epa_pm25, epa_pm10) VALUES ('$dht22_temp1', '$dht22_humd1', '$dht22_temp2', '$dht22_humd2', '$scd40_temp', '$scd40_humd', '$scd40_co2','$bmp_temp', '$bmp_pressure', '$bmp_altitude', '$esp_pm1', '$esp_pm25', '$esp_pm100','$cwb_temp', '$cwb_humd', '$epa_pm25', '$epa_pm10')";
    echo $sql;

    $maxtemp = ($dht22_temp1+$dht22_temp2+$bmp_temp+$scd40_temp)/4;
    $maxhumd = ($dht22_humd1+$dht22_humd2+$scd40_humd)/3;

if ($maxtemp > 38){ //溫度警告
    $data = [
        'to' => $userId,
        'messages' => [[
            'type' => 'text',
            'text' => "警告！目前家庭溫度過高\n溫度：". $maxtemp.' °C']]];
    $post_data = json_encode($data);
    $ch = curl_init('https://api.line.me/v2/bot/message/push');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token]);
    $result = curl_exec($ch);
    curl_close($ch);
}

if ($scd40_co2 > 1800){ //Co2警告 
    $data = [
        'to' => $userId,
        'messages' => [[
            'type' => 'text',
            'text' => "警告！目前家庭二氧化碳濃度過高 請打開窗通風 \nCO2：". $scd40_co2.'ppm']]];
    $post_data = json_encode($data);
    $ch = curl_init('https://api.line.me/v2/bot/message/push');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token]);
    $result = curl_exec($ch);
    curl_close($ch);
}




if (mysqli_query($conn, $sql)) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
}
?>