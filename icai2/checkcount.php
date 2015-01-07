<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> - jsFiddle demo</title>
  
  <script type='text/javascript' src='http://code.jquery.com/jquery-1.8.3.js'></script>
  <link rel="stylesheet" type="text/css" href="/css/normalize.css">
  
  
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  
  <style type='text/css'>
    
  </style>
  


<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
var counter = 1000;
    setInterval(function() {
        counter--;
        if(counter < 0) {
          //  window.location = 'login.php';
        } else {
            document.getElementById("count").innerHTML = counter;
             }
    }, 1000);
});//]]>  

</script>


</head>
<body>
  <div id="count"></div>
  
</body>


</html>

