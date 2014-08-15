<html>
<head>
<script>
function loaded()
{
    alert("Beep!");
    window.setTimeout(CloseMe, 500);
}

function CloseMe() 
{
    window.close();
}
</script>
</head>
<body onLoad="loaded()">
Hello!
</body>