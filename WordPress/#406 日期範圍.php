<!DOCTYPE html>
<html>

<head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* 自定义提交按钮的样式 */
        #submitForm {
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
    </style>
</head>
<body>
		
<form id="myForm">
  <h4>輸入日期範圍：</h4>
	<p>
  <input type="datetime-local" id="from" name="from">
  - 
  <input type="datetime-local" id="to" name="to">
   | 
  <input type="submit" id="submitForm" value="確認"> 
</form>

<script>
// JavaScript部分可以不变
$(document).ready(function(){
    $('#submitForm').click(function(e){
        e.preventDefault();
        var from = $('#from').val();
        var to = $('#to').val();
        $.ajax({
            type: 'POST',
            url: 'https://wp.paki91.com/topics/date_data.php',
            data: { from: from, to: to },
            success: function(response) {
                // 在此处处理服务器的响应，如果需要的话
            }
        });
    });
});
</script>

</body>
</html>
