<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["data"])) {

    $data = $_POST["data"];
    

    $logFilePath = "logs.txt";
    

    $file = fopen($logFilePath, "w");
    
    if ($file) {
       
        fwrite($file, $data . PHP_EOL); 
        fclose($file);
        echo "Data has been written to logs.txt successfully.\n";
        echo "data:".$data."\n"; 
    } else {
        echo "Error opening the file for writing.";
    }
} else {
    echo "Invalid request.";
}
?>
