<?php
// 创建连接
$conn = new mysqli('localhost', 'root', 'QKV6yCs2ps.=', 'xkj');
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
$sql = "SELECT datetime, dht22_temp1, dht22_humd1, dht22_temp2, dht22_humd2, bmp_temp, bmp_pressure, bmp_altitude, esp_pm1, esp_pm25, esp_pm100, scd40_co2,cwb_temp, cwb_humd, epa_pm25, epa_pm10, scd40_temp, scd40_humd, scd40_co2 FROM sensor_data ORDER BY datetime DESC LIMIT 1";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    $datetime = $row["datetime"];
    $dht22_temp1 = $row["dht22_temp1"];
    $dht22_humd1 = $row["dht22_humd1"];
    $dht22_temp2 = $row["dht22_temp2"];
    $dht22_humd2 = $row["dht22_humd2"];
    $scd40_temp = $row["scd40_temp"];
    $scd40_humd = $row["scd40_humd"];
    $bmp_temp = $row["bmp_temp"];
    $bmp_pressure = $row["bmp_pressure"];
    $bmp_altitude = $row["bmp_altitude"];
    $esp_pm1 = $row["esp_pm1"];
    $esp_pm25 = $row["esp_pm25"];
    $esp_pm100 = $row["esp_pm100"];
    $scd40_co2 = $row["scd40_co2"];
    $cwb_temp = $row["cwb_temp"];
    $cwb_humd = $row["cwb_humd"];
    $epa_pm25 = $row["epa_pm25"];
    $epa_pm10 = $row["epa_pm10"];
    }
} 
$conn->close();
?>


<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #e0e0ff; /* 淡蓝色背景 */
            font-family: Arial, sans-serif;
            text-align: center;
        }
        
        .sensor-container {
            display: inline-block;
            margin: 10px;
            padding: 12px;
            border-radius: 18px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 36.8%;
            
            
        }

        .container {
            display: flex;
            flex-wrap: wrap;

        }
}
    </style>
</head>
<body><br>
   <h1>當前環境資訊小盒子</h1>
    <h3>Environmental Box</h3> </div>

<div class="container">
<h2>溫濕度:</h2>
    </div>
        <div class="sensor-container">
            <h2>DHT22-1</h2>
            <p><?php echo $dht22_temp1; ?>°C&nbsp; &nbsp;<?php echo $dht22_humd1; ?>%</p>
        </div>
    
        <div class="sensor-container">
            <h2>DHT22-2</h2>
            <p><?php echo $dht22_temp2; ?>°C&nbsp; &nbsp;<?php echo $dht22_humd2; ?>%</p>
        </div>

        <div class="sensor-container">
            <h2>SCD40</h2>
            <p><?php echo $scd40_temp; ?>°C&nbsp; &nbsp;<?php echo $scd40_humd;?>%</p>
        </div>

        <div class="sensor-container">
            <h2>BME280</h2>
            <p><?php echo $bmp_temp; ?>°C</p>
        </div>
    
 <div class="container">
    <h2>空氣品質指數:</h2></div>
    
    <div class="sensor-container">
            <h2>PM1.0</h2>
      <p><?php echo $esp_pm1; ?>(μg/m3)</p>
        </div>
    <div class="sensor-container">
                <h2>PM2.5</h2>
      <p><?php echo $esp_pm25; ?>(μg/m3)</p>
</div>
    <div class="sensor-container">
                <h2>PM10</h2>
      <p><?php echo $esp_pm100; ?>(μg/m3)</p>
</div>
    </div>
    <div class="sensor-container">
                <h2>CO2</h2>
      <p><?php echo $scd40_co2; ?>ppm</p>
</div>
<div class="container">
    <h2>其他項目指數：</h1></div>

    <div class="sensor-container">
                <h2>Pressure</h2>
      <p><?php echo $bmp_pressure; ?>hPa</p>
</div>
    <div class="sensor-container">
                <h2>Altitude</h2>
      <p><?php echo $bmp_altitude; ?>m</p>
</div>
    </div>

    <div class="container">
    <h2>API：</h1></div>
    <div class="sensor-container">
                <h2>CWB-Temp</h2>
      <p><?php echo $cwb_temp; ?>°C</p>
</div>
    <div class="sensor-container">
                <h2>CWB-Humd</h2>
      <p><?php echo $cwb_humd; ?>%</p>
</div>
    <div class="sensor-container">
                <h2>EPA-PM2.5</h2>
      <p><?php echo $epa_pm25; ?>(μg/m3)</p>
</div>
   <div class="sensor-container">
                <h2>EPA-PM10</h2>
     <p><?php echo $epa_pm10; ?>(μg/m3)</p>
</div>
    <h5><p align="right">更新時間 | <?php echo $datetime?></p></h5>
    </div>
<h5>© 2023 HKSAC | Website</h5>
</body>
</html>
