<?php

class AdminBlogsController extends AdminController {

	/**
	 * Post Model
	 * @var Post
	 */
	protected $post;

	/**
	 * Inject the models.
	 * @param Post $post
	 */
	public function __construct(Post $post) {
		parent::__construct();
		$this -> post = $post;
	}

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex($directory = null, $postId = null) {

		if ($postId == "new") {
			if ($directory && file_exists(Config::get('app.image_path') . '/' . $directory)) {
				Picture::recursive_remove(Config::get('app.image_path') . '/' . $directory);
			}
		}
		// Title
		$title = Lang::get('admin/blogs/title.blog_management');

		// Grab all the blog posts
		$posts = $this -> post;
		$category = "all";
		// Show the page
		return View::make('admin/blogs/index', compact('posts', 'title', 'category'));
	}

	public function getSelectedPosts($category) {
		// Title
		$title = Lang::get('admin/blogs/title.blog_management');
		// Show the page
		return View::make('admin/blogs/index', compact('comments', 'title', 'category'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		// Title
		$title = Lang::get('admin/blogs/title.create_a_new_blog');
		$randAlbumName = date("YmdHis");
		//mkdir(Config::get('app.image_path') . '/' . $randAlbumName);
		//Category
		/*$init_cat = Category::first();
		$category = array($init_cat -> id => $init_cat -> category_name);
		$categories = Category::all();
		foreach ($categories as $temp) {

			$category = array_add($category, $temp -> id, $temp -> category_name);
		}*/
		$category = Category::all();
		$selectedCategories = array();
		$meal = Meal::all();
		$selectedMeals = array();
		$dressing = Dressing::all();
		$selectedDressings = array();
		$foodType = Foodtype::all();
		$selectedFoodTypes = array();
		//Province
		/*$init_province = Province::first();
		$provinceTemp = array($init_province -> id => $init_province -> province_name);
		$provinces = Province::all();
		foreach ($provinces as $temp) {
			$provinceTemp = array_add($provinceTemp, $temp -> id, $temp -> province_name);
		}*/
		// Show the page
		return View::make('admin/blogs/create_edit', 
		compact('title', 'category', 'randAlbumName', 'selectedCategories',
		'meal','selectedMeals','dressing','selectedDressings','foodType','selectedFoodTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3|unique:posts', 
		'restaurant_name' => 'required|min:3', 
		'content' => 'required|min:3', 
		'tel' => 'required|Regex:/^[0-9]{9,}([,][ ][0-9]{9,})*+$/i', 
		'album_name' => 'required|unique:posts',
		'tumbol' => 'required|exists:tumbol,tumbol_name',
		'amphur' => 'required|exists:amphur,amphur_name',
		'province' => 'required|exists:province,province_name',
		'publishedAt' => array('regex:([2][0]([0-2][0-9]|3[0-8])[-](0[1-9]|1[0-2])[-][0-3][0-9][ ]([0-1][0-9]|2[0-3])[:][0-5][0-9])'),
		'expiredAt' => array('regex:([2][0]([0-2][0-9]|3[0-8])[-](0[1-9]|1[0-2])[-][0-3][0-9][ ]([0-1][0-9]|2[0-3])[:][0-5][0-9])'),
		'newFoodType' => 'min:3',
		'newDressing' => 'min:3',
		'latitude' => 'min:3|regex:([-]{0,1}[0-9]+[.]{0,1}[0-9]*)',
		'longitude' => 'min:3|regex:([-]{0,1}[0-9]+[.]{0,1}[0-9]*)'
		);
		

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		//$image = Post::findImages(Input::get('content'));
		// Check if the form validates with success
		if ($validator -> passes()) {
			// Create a new blog post
			$user = Auth::user();

			//String replace to update picture path

			// Update the blog post data
			$this -> post -> title = Input::get('title');
			$this -> post -> restaurant_name = Input::get('restaurant_name');
			$this -> post -> tel = Input::get('tel');
			$this -> post -> street_addr = Input::get('street_addr');
			//$this -> post -> soi = Input::get('soi');
			//$this -> post -> road = Input::get('road');
			//$this -> post -> subdistrict = Input::get('subdistrict');
			//$this -> post -> district = Input::get('district');
			//$this -> post -> province = Input::get('province');
			$this -> post -> province = Input::get('province');
			$this -> post -> amphur = Input::get('amphur');
			$this -> post -> tumbol = Input::get('tumbol');
			
			$this -> post -> zip = Input::get('zip');
			$this -> post -> album_name = Input::get('album_name');
			$this -> post -> profile_picture_name = Input::get('profilePic');
			$this -> post -> latitude = Input::get('latitude');
			$this -> post -> longitude = Input::get('longitude');
			//$this->post->slug             = Str::slug(Input::get('title'));
			$this -> post -> content = Input::get('content');
			$this -> post -> meta_title = Input::get('meta-title');
			$this -> post -> meta_description = Input::get('meta-description');
			$this -> post -> meta_keywords = Input::get('meta-keywords');
			$this -> post -> user_id = $user -> id;
			if(Input::get('publishedAt'))
				$this -> post -> published_at = Input::get('publishedAt');
			else {
				$date = new DateTime;
				$this -> post -> published_at = $date;
			}
			if(Input::get('radio2') == "specfied")
			{
				$this -> post -> expired_at = Input::get('expiredAt');
				$this -> post -> is_permanent = 0;
				
			}
			else {
				$this -> post -> expired_at = "";
				$this -> post -> is_permanent = 1;
			}
			// Was the blog post created?

			if ($this -> post -> save()) {
				
				//Email to inform users of new review
				
				//Insert to PostsCategory Table		
				if(Input::get('category_id_temp'))	
				{	
					/*foreach (Input::get('category_id_temp') as $selected) {
						$postCategory = new PostsCategory;	
						$postCategory -> post_id = $this -> post -> id;
						$postCategory -> category_id = $selected;
						$postCategory -> save();
					}*/
					$this -> post->category()->sync(Input::get('category_id_temp'));
				}
				if(Input::get('meal_id_temp'))	
					$this -> post->meal()->sync(Input::get('meal_id_temp'));
				
				if(Input::get('foodType_id_temp'))
					$this -> post->foodType()->sync(Input::get('foodType_id_temp'));
				if(Input::get('dressing_id_temp'))
					$this -> post->dressing()->sync(Input::get('dressing_id_temp'));
				
				
				//Save new dressing 
				if(Input::get('dressingSpecify') == 1 && Input::get('newDressing')){
					$newDressing = new Dressing;
					$newDressing->name = Input::get('newDressing');
					if($newDressing->save())
						$newDressing->post()->attach($this -> post -> id);
					
				} 
				//Save new food type 
				if(Input::get('foodTypeSpecify') == 1 && Input::get('newFoodType')){
					$newFoodType = new FoodType;
					$newFoodType->name = Input::get('newFoodType');
					if($newFoodType->save())
						$newFoodType->post()->attach($this -> post -> id);
				} 
				
				
				return Redirect::to('admin/blogs/') -> with('success', Lang::get('admin/blogs/messages.create.success'));

			}

			// Redirect to the blog post create page
	
			return Redirect::to('admin/blogs/create') -> with('error', Lang::get('admin/blogs/messages.create.error'));

		}

		// Form validation failed

		return Redirect::to('admin/blogs/create') -> withInput() -> withErrors($validator);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $post
	 * @return Response
	 */
	public function getShow($post) {
		// redirect to the frontend
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $post
	 * @return Response
	 */
	public function getEdit($post) {
		// Title
		$title = Lang::get('admin/blogs/title.blog_update');
		//Category
		/*$init_cat = Category::first();
		$category = array($init_cat -> id => $init_cat -> category_name);
		$categories = Category::all();
		foreach ($categories as $temp) {
			$category = array_add($category, $temp -> id, $temp -> category_name);
		}*/
		$randAlbumName = $post -> album_name;
		$category = Category::all();
		//$postCategory = PostsCategory::where('post_id', '=', $post -> id)->get();
		
		$meal = Meal::all();
		$dressing = Dressing::all();
		$foodType = FoodType::all();
		$postCategory = $post->category;
		$postMeal = $post->meal;
		$postDressing = $post->dressing;
		$postFoodType = $post->foodType;
		//get selected categories
		$selectedCategories = Logic::preparePreselectedCheckBox($category,$postCategory);
		$selectedMeals = Logic::preparePreselectedCheckBox($meal,$postMeal);
		$selectedDressings = Logic::preparePreselectedCheckBox($dressing,$postDressing);
		$selectedFoodTypes = Logic::preparePreselectedCheckBox($foodType,$postFoodType);
		/*$selectedCategories = array();
		$i=0;
		foreach($category as $choice)
		{
		    $check=0;	
			foreach($postCategory as $selected)
			{
				if($selected->category_id == $choice->id)
				{
					$selectedCategories[$i] = 1;
					$check = 1;
					break;
				}
			}
			if($check == 0)
			{
				$selectedCategories[$i]=0;
			}
			$i++;
		}*/
		
		
		
		if(!file_exists(Config::get('app.image_path').'/'.$post -> album_name))
		{
			mkdir(Config::get('app.image_path').'/'.$post -> album_name);
			mkdir(Config::get('app.image_path').'/'.$post -> album_name.'/banner');
		}
		else if(!file_exists(Config::get('app.image_path').'/'.$post -> album_name.'/banner'))
		{
			mkdir(Config::get('app.image_path').'/'.$post -> album_name.'/banner');
		}
		/*$init_province = Province::first();
		$province = array($init_province -> id => $init_province -> province_name);
		$provinces = Province::all();
		foreach ($provinces as $temp) {
			$province = array_add($province, $temp -> id, $temp -> province_name);
		}*/
		
		// Show the page
		return View::make('admin/blogs/create_edit', 
		compact('post', 'title', 'category', 'randAlbumName', 'selectedCategories','meal','selectedMeals',
		'foodType','selectedFoodTypes', 'dressing','selectedDressings'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $post
	 * @return Response
	 */
	public function postEdit($post) {

		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3|unique:posts,title,' . $post -> id . ',id', 
		'restaurant_name' => 'required|min:3', 'content' => 'required|min:3', 
		'tel' => 'required|Regex:/^[0-9]{9,}([,][ ][0-9]{9,})*+$/i',
		'tumbol' => 'required|exists:tumbol,tumbol_name',
		'amphur' => 'required|exists:amphur,amphur_name',
		'province' => 'required|exists:province,province_name',
		'content' => 'required|min:3', 
		'publishedAt' => array('regex:([2][0]([0-2][0-9]|3[0-8])[-](0[1-9]|1[0-2])[-][0-3][0-9][ ]([0-1][0-9]|2[0-3])[:][0-5][0-9])'),
		'expiredAt' => array('regex:([2][0]([0-2][0-9]|3[0-8])[-](0[1-9]|1[0-2])[-][0-3][0-9][ ]([0-1][0-9]|2[0-3])[:][0-5][0-9])'),
		'newFoodType' => 'min:3',
		'newDressing' => 'min:3',
		'newDressing' => 'min:3',
		'latitude' => 'min:3|regex:([-]{0,1}[0-9]+[.]{0,1}[0-9]*)',
		'longitude' => 'min:3|regex:([-]{0,1}[0-9]+[.]{0,1}[0-9]*)',);
		
		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Update the blog post data
			//$oldImageDir = $post -> album_name;

			//$image = Post::findImages(Input::get('content'));

			//$content = str_replace('/images/user/', '/images/' . Input::get('album_name') . '/', Input::get('content'));
			/*if ($oldImageDir != Input::get('album_name')) {
				//String replace to update picture path
				$content = str_replace('/images/' . $oldImageDir . '/', '/images/' . Input::get('album_name') . '/', Input::get('content'));
			}*/
			$post -> title = Input::get('title');
			$post -> restaurant_name = Input::get('restaurant_name');
			$post -> tel = Input::get('tel');
			$post -> street_addr = Input::get('street_addr');
			$post -> soi = Input::get('soi');
			$post -> road = Input::get('road');
			$post -> tumbol = Input::get('tumbol');
			$post -> amphur = Input::get('amphur');
			$post -> province = Input::get('province');
			$post -> zip = Input::get('zip');
			$post -> album_name = Input::get('album_name');
			$post -> profile_picture_name = Input::get('profilePic');
			$post -> latitude = Input::get('latitude');
			$post -> longitude = Input::get('longitude');
			//$post->slug             = Str::slug(Input::get('title'));
			$post -> content = Input::get('content');
			$post -> meta_title = Input::get('meta-title');
			$post -> meta_description = Input::get('meta-description');
			$post -> meta_keywords = Input::get('meta-keywords');
			if(Input::get('publishedAt'))
				$post -> published_at = Input::get('publishedAt');
			else {
				$date = new DateTime;
				$post -> published_at = $date;
			}
			if(Input::get('radio2') == "specified")
			{					
				$post -> is_permanent = 0;
				$post -> expired_at = Input::get('expiredAt');	
			}
			else {
				$post -> is_permanent = 1;
				$post -> expired_at = "";
				//$post -> expired_at = "";
				/*$date = new DateTime;
				$date->setTimestamp(2147483647);
				$post -> expired_at = $date;
				 * */
			}
						
			//Remove PostsCategory and reinsert
			/*PostsCategory::where('post_id', '=', $post -> id) -> delete();
			if(Input::get('category_id_temp'))
			{
				foreach (Input::get('category_id_temp') as $selected) {		
						$postCategory = new PostsCategory;	
						$postCategory -> post_id = $post -> id;
						$postCategory -> category_id = $selected;
						$postCategory -> save();			
				}
			}*/
			
			if(Input::get('category_id_temp'))	
				$post->category()->sync(Input::get('category_id_temp'));
			if(Input::get('meal_id_temp'))	
				$post->meal()->sync(Input::get('meal_id_temp'));	
			if(Input::get('foodType_id_temp'))
				$post->foodType()->sync(Input::get('foodType_id_temp'));
			if(Input::get('dressing_id_temp'))
				$post->dressing()->sync(Input::get('dressing_id_temp'));
			
			// Was the blog post updated?

			if ($post -> save()) {
				/*if($oldImageDir == null)
				 {
				 mkdir(Config::get('app.image_path').'/'.Input::get('album_name'));
				 }
				 else if(!file_exists(Config::get('app.image_path').'/'.Input::get('album_name')))
				 {
				 Picture::recursive_copy(Config::get('app.image_path').'/'.$oldImageDir , Config::get('app.image_path').'/'.Input::get('album_name'));
				 }	*/
				// Delete so that everyone knows of its update
				PostsUserRead::where('post_id', '=', $post -> id) -> delete();
				//Save new dressing 
				if(Input::get('dressingSpecify') == 1 && Input::get('newDressing')){
					$newDressing = new Dressing;
					$newDressing->name = Input::get('newDressing');
					if($newDressing->save())
						$newDressing->post()->attach($post -> id);
					
				} 
				//Save new food type 
				if(Input::get('foodTypeSpecify') == 1 && Input::get('newFoodType')){
					$newFoodType = new FoodType;
					$newFoodType->name = Input::get('newFoodType');
					if($newFoodType->save())
						$newFoodType->post()->attach($post -> id);
				} 
				//return Redirect::to('admin/blogs/' . $post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.update.success'));

				//Check if admin update dir name
				/*if ($oldImageDir != Input::get('album_name')) {
					//rename old dir
					Picture::recursive_copy(Config::get('app.image_path') . '/' . $oldImageDir, Config::get('app.image_path') . '/' . Input::get('album_name'));
					Picture::recursive_remove(Config::get('app.image_path') . '/' . $oldImageDir);
				}*/
				//If admin add more images
				/* for($i=0;$i<count($image);$i++)
				 {
				 if(!Picture::where('filename', '=', $image[$i])->where('post_id', '=', $post->id)->first())
				 {
				 $images = new Picture;
				 $images->filename = $image[$i];
				 $images->post_id = $post->id;
				 $images->save();
				 }
				 }*/
				return Redirect::to('admin/blogs/') -> with('success', Lang::get('admin/blogs/messages.update.success'));
			}

			// Redirect to the blogs post management page
			return Redirect::to('admin/blogs/' . $post -> id . '/edit') -> with('error', Lang::get('admin/blogs/messages.update.error'));
		}

		// Form validation failed
		return Redirect::to('admin/blogs/' . $post -> id . '/edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $post
	 * @return Response
	 */
	public function getDelete($post) {
		// Title
		$title = Lang::get('admin/blogs/title.blog_delete');

		// Show the page
		return View::make('admin/blogs/delete', compact('post', 'title'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $post
	 * @return Response
	 */
	public function postDelete($post) {
		// Declare the rules for the form validation
		$rules = array('id' => 'required|integer');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			//delete image in albume
			$id = $post -> id;
			$albumName = $post -> album_name;
			
			$post -> delete();
			// Was the blog post deleted?
			$post = Post::find($id);
			if (empty($post)) {
				PostsCategory::where('post_id', '=', $id) -> delete();
				PostsUserRead::where('post_id', '=', $id) -> delete();
				Picture::recursive_remove(Config::get('app.image_path') . '/' . $albumName);
				// Redirect to the blog posts management page				
				return Redirect::to('admin/blogs') -> with('success', Lang::get('admin/blogs/messages.delete.success'));

			}
		}
		// There was a problem deleting the blog post
		return Redirect::to('admin/blogs') -> with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

	public function saveDraft() {
		if ($postId == 0) {
			mkdir(Config::get('app.image_path') . '/' . $new);
			return $postId;

		} else {
			return $postId;
		}
	}

	public function getProvince() {
		$match = '%' .Input::get('term') . '%';
		$init_province =  Province::where('province_name', 'like', $match)->firstOrFail();
		$results = array($init_province->id => $init_province->province_name);

		$query = Province::where('province_name', 'like', $match)->get();
		foreach($query as $province)
		{
			$results = array_add($results, $province->id, $province->province_name);
		}
		echo json_encode($results);
	}
	public function getAmphur() {
		$match = '%' .Input::get('term') . '%';
		$init_amphur =  Amphur::where('amphur_name', 'like', $match)->firstOrFail();
		$results = array($init_amphur->id => $init_amphur->amphur_name);

		$query = Amphur::where('amphur_name', 'like', $match)->get();
		foreach($query as $amphur)
		{
			$results = array_add($results, $amphur->id, $amphur->amphur_name);
		}
		echo json_encode($results);
	}
	public function getTumbol() {
		$match = '%' .Input::get('term') . '%';
		$init_tumbol =  Tumbol::where('tumbol_name', 'like', $match)->firstOrFail();
		$results = array($init_tumbol->id => $init_tumbol->tumbol_name);

		$query = Tumbol::where('tumbol_name', 'like', $match)->get();
		foreach($query as $tumbol)
		{
			$results = array_add($results, $tumbol->id, $tumbol->tumbol_name);
		}
		echo json_encode($results);
	}

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData($categoryId) {
		if ($categoryId == "all") {
			//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
			$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at', 'posts.published_at', 'posts.expired_at', 'posts.is_permanent')) 
			-> leftjoin('posts_category', 'posts.id', '=', 'posts_category.post_id') 
			-> leftjoin('category', 'posts_category.category_id', '=', 'category.id');
			
			//$posts = Post::select(array('posts.id', 'posts.title', 'posts.updated_at', 'posts.id as comments', 'posts.created_at')); 

			/*$posts = Category::rightjoin('posts_category', 'posts_category.category_id', '=', 'category.id')
                        ->rightjoin('posts', 'posts.id', '=','posts_category.post_id' )
                        ->select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at'));
		*/
		} else {
			//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id') -> where('category.id', '=', $categoryId);
			$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at', 'posts.published_at', 'posts.expired_at', 'posts.is_permanent')) 
			-> leftjoin('posts_category', 'posts.id', '=', 'posts_category.post_id') 
			-> leftjoin('category', 'posts_category.category_id', '=', 'category.id')
			-> where('category.id', '=', $categoryId);
		}

		//$posts = Post::leftjoin('category', 'posts.category_id', '=', 'category.id')
		//->select(array('posts.id', 'posts.title', 'category.category_name as category ','posts.id as comments', 'posts.created_at'));

		return Datatables::of($posts) 
		-> edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}') 
		-> edit_column('comments', '<a href="{{{ URL::to(\'admin/comments/\'.$id.\'/view_comments\' ) }}}">{{$comments}}</a>') 
		-> edit_column('published_at', '@if(strtotime($published_at) <= time() && ($is_permanent == 1 || strtotime($expired_at) > time())) active @else inactive @endif') 
		-> edit_column('title', '{{{ Str::limit($title, 40, \'...\') }}}')
		-> add_column('actions', '<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ') 
		-> remove_column('expired_at')
		-> remove_column('is_permanent')
        -> remove_column('id') -> make();

	}
	public function makeDir($directory) {
		if(!file_exists(Config::get('app.image_path').'/'.$directory))
		{
			mkdir(Config::get('app.image_path').'/'.$directory);
		}
	}	

}
