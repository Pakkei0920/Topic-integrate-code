<?php

$logFilePath = "date_logs.txt";
if (file_exists($logFilePath)) {
    $logs = file_get_contents($logFilePath);
}

$connection = mysqli_connect('localhost', 'root', 'QKV6yCs2ps.=', 'xkj');
if (!$connection) { die("Connection failed: " . mysqli_connect_error());}

$query = "SELECT datetime, dht22_temp1, dht22_humd1, dht22_temp2, dht22_humd2, bmp_temp, bmp_pressure, bmp_altitude, esp_pm1, esp_pm25, esp_pm100, cwb_temp, cwb_humd, epa_pm25, epa_pm10, scd40_temp, scd40_humd, scd40_co2
	  FROM `sensor_data` WHERE `datetime` BETWEEN $logs";
$result = mysqli_query($connection, $query);  // Use mysqli_query to execute the query

while ($row = mysqli_fetch_assoc($result)) {
    $dht22_temp1Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['dht22_temp1'])
    );
    $dht22_humd1Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['dht22_humd1'])
    );
    $dht22_temp2Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['dht22_temp2'])
    );
    $dht22_humd2Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['dht22_humd2'])
    );
    $bmp_tempData[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['bmp_temp'])
    );
    $bmp_pressureData[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['bmp_pressure'])
    );
    $bmp_altitudeData[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['bmp_altitude'])
    );
    $cwb_tempData[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['cwb_temp'])
    );
    $cwb_humd[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['cwb_humd'])
    );
    $esp_pm1Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['esp_pm1'])
    );
    $esp_pm25Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['esp_pm25'])
    );
    $esp_pm100Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['esp_pm100'])
    );
    $epa_pm25Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['epa_pm25'])
    );
    $epa_pm10Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['epa_pm10'])
    );
    $scd40_tempData[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['scd40_temp'])
    );
    $scd40_humdData[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['scd40_humd'])
    );
    $scd40_co2Data[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['scd40_co2'])
    );
}

// Convert the data to JSON format and send the response
$data = array(
    "dht22_temp1Data" => $dht22_temp1Data,
    "dht22_humd1Data" => $dht22_humd1Data,
    "dht22_temp2Data" => $dht22_temp2Data,
    "dht22_humd2Data" => $dht22_humd2Data,
    "bmp_tempData" => $bmp_tempData,
    "bmp_altitudeData" => $bmp_altitudeData,
    "bmp_pressureData" => $bmp_pressureData,
    "cwb_tempData" => $cwb_tempData,
    "cwb_humd" => $cwb_humd,
    "esp_pm1Data" => $esp_pm1Data,
    "esp_pm25Data" => $esp_pm25Data,
    "esp_pm100Data" => $esp_pm100Data,
    "epa_pm25Data" => $epa_pm25Data,
    "epa_pm10Data" => $epa_pm10Data,
    "scd40_tempData" => $scd40_tempData,
    "scd40_humdData" =>$scd40_humdData,
    "scd40_co2Data" =>$scd40_co2Data,
);
header('Content-Type: application/json');
echo $response = json_encode($data);

mysqli_free_result($result); //釋放與結果關聯的內存
mysqli_close($connection);

?>