<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>sortable demo</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

</head>
<body>
<h3>Customize Category Order </h3>
<h5>Drag and Drop แต่ละ category ตามลำดับที่ต้องการ</h5>
<ul id="sortable">
	@foreach($categories as $category)
  	<li>{{$category->category_name}}</li>
  	@endforeach
</ul>
 
<script>$("#sortable").sortable();</script>
 
</body>
</html>