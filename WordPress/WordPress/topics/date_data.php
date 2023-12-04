<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
      $from = $_POST["from"];
      $to = $_POST["to"];

    $logFilePath = "date_logs.txt";
    $file = fopen($logFilePath, "w");
    
    if ($file) {
        fwrite($file,  "'".$from ."'". " AND " . "'".$to."'". PHP_EOL); 
        fclose($file);
        echo "Data has been written to logs.txt successfully.\n";
        echo  "'".$from ."'". " AND " . "'".$to."'";
    } else {
        echo "Error opening the file for writing.";
    }
} else {
    echo "Invalid request.";
}
?>