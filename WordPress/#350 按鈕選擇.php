<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
        .button {
            background-color: #ea3170;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .button:hover {
            background-color: #fff;
            color: #ea3170;
        }
    </style>
</head>
<body>
	<p>
    <button class="button" id="writeButton2">2分鐘</button>
    <button class="button" id="writeButton5">5分鐘</button>
    <button class="button" id="writeButton10">10分鐘</button>
    <button class="button" id="writeButton30">30分鐘</button>
    <button class="button" id="writeButton60">1小時</button> 
	<button class="button" id="writeButton0.5D">半天</button> 
    <button class="button" id="writeButton1D">1天</button> 
    <script>
        document.getElementById("writeButton2").addEventListener("click", function() {
            writeDataToLogFile(4);
        });

        document.getElementById("writeButton5").addEventListener("click", function() {
            writeDataToLogFile(10);
        });

        document.getElementById("writeButton10").addEventListener("click", function() {
            writeDataToLogFile(20);
        });

        document.getElementById("writeButton30").addEventListener("click", function() {
            writeDataToLogFile(60);
        });

        document.getElementById("writeButton60").addEventListener("click", function() {
            writeDataToLogFile(120); 
        });
         document.getElementById("writeButton0.5D").addEventListener("click", function() {
            writeDataToLogFile(1440); 
        });
        document.getElementById("writeButton1D").addEventListener("click", function() {
            writeDataToLogFile(2880); 
        });
        function writeDataToLogFile(data) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "https://wp.paki91.com/topics/write_to_log.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`data=${data}`);
        }
    </script>
</body>
</html>
