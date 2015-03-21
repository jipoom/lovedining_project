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
		$category = Category::getAllCategoryArray();
		//$selectedCategories = array();
		$meal = Meal::getAllMealArray();
		//$selectedMeals = array();
		$dressing = Dressing::getAllDressingArray();
		//$selectedDressings = array();
		$foodType = FoodType::getAllFoodTypeArray();
		//$selectedFoodTypes = array();
		$allProvince = Province::getAllProvinceArray();
		//Province
		/*$init_province = Province::first();
		$provinceTemp = array($init_province -> id => $init_province -> province_name);
		$provinces = Province::all();
		foreach ($provinces as $temp) {
			$provinceTemp = array_add($provinceTemp, $temp -> id, $temp -> province_name);
		}*/
		// Show the page
		return View::make('admin/blogs/create_edit', 
		compact('title', 'category', 'randAlbumName',
		'meal','dressing','foodType','allProvince'));
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
		//'tel' => 'required|Regex:/^[0-9]{9,}([,][ ][0-9]{9,})*+$/i', 
		'tel' => 'required',
		'album_name' => 'required|unique:posts',
		//'tumbol' => 'exists:tumbol,tumbol_name',
		//'amphur' => 'exists:amphur,amphur_name',
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
			$this -> post -> title_2 = Input::get('title2');
			$this -> post -> restaurant_name = Input::get('restaurant_name');
			$this -> post -> tel = Input::get('tel');
			$this -> post -> address1 = Input::get('address1');
			$this -> post -> address2 = Input::get('address2');
			//$this -> post -> soi = Input::get('soi');
			//$this -> post -> road = Input::get('road');
			//$this -> post -> subdistrict = Input::get('subdistrict');
			//$this -> post -> district = Input::get('district');
			//$this -> post -> province = Input::get('province');
			$this -> post -> province_id = Input::get('province');
			$this -> post -> amphur = Input::get('amphur');
			$this -> post -> tumbol = Input::get('tumbol');
			
			$this -> post -> zip = Input::get('zip');
			$this -> post -> album_name = Input::get('album_name');
			$this -> post -> profile_picture_name = Input::get('profilePic');
			$this -> post -> latitude = Input::get('latitude');
			$this -> post -> longitude = Input::get('longitude');
			$this -> post -> route = Input::get('route');
			$this -> post -> route_en = Input::get('route_en');
			$this -> post -> route_cn = Input::get('route_cn');
			//$this->post->slug             = Str::slug(Input::get('title'));
			$this -> post -> content = Input::get('content');
			$this -> post -> content_en = Input::get('content_en');
			$this -> post -> content_cn = Input::get('content_cn');
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
				
				//Email to inform users of new review
				$users = User::where('confirmed','=','1')->get();
				
				if(!Input::get('radio1') == "now")
					$publishedDate = Input::get('publishedAt');
				else {
					$publishedDate = "now";
				}
				foreach($users as $user)
				{
					//echo $user->firstname;
					//Post::sendEmail("New Review","We have new review available for you",$this->post,$user,$publishedDate);
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
		$category = Category::getAllCategoryArray();
		//$postCategory = PostsCategory::where('post_id', '=', $post -> id)->get();
		
		$meal = Meal::getAllMealArray();
		$dressing = Dressing::getAllDressingArray();
		$foodType = FoodType::getAllFoodTypeArray();
		$allProvince = Province::getAllProvinceArray();
		//get selected categories
		//$selectedCategories = Logic::preparePreselectedCheckBox($category,$postCategory);
		$selectedCategories = Logic::preparePreselectedSelect($post->category);
		//$selectedMeals = Logic::preparePreselectedCheckBox($meal,$postMeal);
		$selectedMeals = Logic::preparePreselectedSelect($post->meal);
		//$selectedDressings = Logic::preparePreselectedCheckBox($dressing,$postDressing);
		$selectedDressings = Logic::preparePreselectedSelect($post->dressing);
		//$selectedFoodTypes = Logic::preparePreselectedCheckBox($foodType,$postFoodType);
		$selectedFoodTypes = Logic::preparePreselectedSelect($post->foodType);
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
		'foodType','selectedFoodTypes', 'dressing','selectedDressings','allProvince'));
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
		//'tel' => 'required|Regex:/^[0-9]{9,}([,][ ][0-9]{9,})*+$/i',
		'tel' => 'required',
		//'tumbol' => 'exists:tumbol,tumbol_name',
		//'amphur' => 'exists:amphur,amphur_name',
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
			$post -> title_2 = Input::get('title2');
			$post -> restaurant_name = Input::get('restaurant_name');
			$post -> tel = Input::get('tel');
			$post -> address1 = Input::get('address1');
			$post -> address2 = Input::get('address2');
			//$post -> road = Input::get('road');
			$post -> tumbol = Input::get('tumbol');
			$post -> amphur = Input::get('amphur');
			$post -> province_id = Input::get('province');
			$post -> zip = Input::get('zip');
			$post -> album_name = Input::get('album_name');
			$post -> profile_picture_name = Input::get('profilePic');
			$post -> latitude = Input::get('latitude');
			$post -> longitude = Input::get('longitude');
			$post -> route = Input::get('route');
			$post -> route_en = Input::get('route_en');
			$post -> route_cn = Input::get('route_cn');
			//$post->slug             = Str::slug(Input::get('title'));
			$post -> content = Input::get('content');
			$post -> content_en = Input::get('content_en');
			$post -> content_cn = Input::get('content_cn');
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
			else {
				$post->category()->detach();
			}
			if(Input::get('meal_id_temp'))	
				$post->meal()->sync(Input::get('meal_id_temp'));	
			else {
				$post->meal()->detach();
			}
			if(Input::get('foodType_id_temp'))
				$post->foodType()->sync(Input::get('foodType_id_temp'));
			else {
				$post->foodType()->detach();
			}
			if(Input::get('dressing_id_temp'))
				$post->dressing()->sync(Input::get('dressing_id_temp'));
			else {
				$post->dressing()->detach();
			}
			
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
				/*if(Input::get('dressingSpecify') == 1 && Input::get('newDressing')){
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
				} */
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
				 
				 //Inform users of updated review
				 $users = User::where('confirmed','=','1')->get();
				 foreach($users as $user)
				{
					//echo $user->firstname;
					//Post::sendEmail("Review updated!","We have updated a review and would like you to check it out",$post,$user,$post->published_at);
		
				}
				 
				 
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
			$posts = Post::select(array('posts.id', 'posts.title', 'posts.is_home as category', 'posts.id as comments', 'posts.created_at', 'posts.published_at', 'posts.expired_at', 'posts.is_permanent'));
			//-> leftjoin('posts_category', 'posts.id', '=', 'posts_category.post_id') 
			//-> leftjoin('category', 'posts_category.category_id', '=', 'category.id');
			
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
		-> edit_column('category', '<?php $post_cat = DB::table(\'posts_category\')
			-> leftjoin(\'category\', \'posts_category.category_id\', \'=\', \'category.id\')
			-> where(\'posts_category.post_id\',\'=\',$id)->get(); 
			$i=0;
			?>
			@foreach($post_cat as $cat)
			<?php $i++; ?>
				@if($i < count($post_cat)) 
					{{$cat->category_name}},
				@else
					{{$cat->category_name}}
				@endif
			@endforeach
			') 
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
