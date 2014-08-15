<html>
<head>
<script>
function CloseMe() 
{
    parent.oTable.fnReloadAjax();
	parent.jQuery.fn.colorbox.close();
	return false;
}
</script>
</head>
<body onLoad="CloseMe()">
</body>