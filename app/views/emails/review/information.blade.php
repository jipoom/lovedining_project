<h1>Hi, {{ $firstname }}!</h1>
<p>{{ $emailTitle }}</p> 
<p>Review name: {{ $postTitle }}</p>
<p>Restaurant: {{ $restaurant }}</p>
<p>available: {{ $publishedDate }}</p>
@if($profile_picture_name!="")
<a href="{{{ $url }}}" class="thumbnail"><img src="{{$message->embed(Config::get('app.image_path').'/'.$album_name.'/'.$profile_picture_name)}}" alt=""></a>
@endif