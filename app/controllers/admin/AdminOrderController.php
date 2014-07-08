<?php

class AdminOrderController extends AdminController {


    /**
     * Post Model
     * @var Category
     */
    protected $category;

    /**
     * Inject the models.
     * @param $category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title

		$title = Lang::get('admin/category/title.order_management');

        // Grab all the blog posts
        $categories = Category::all();
        // Show the page
        return View::make('admin/order/index', compact('categories', 'title'));
    }

	public function changeOrder($mode)
	{
		 //Sort Category by mode
			$title = Lang::get('admin/category/title.order_management');           
			if($mode == "custom"){
				$categories = Category::all();	
				return View::make('admin/order/temp', compact('categories','title'));
			}
			else if($mode == "name")
			{
				  $categories =  DB::table('category')->orderBy('category_name', 'ASC')->paginate(10);
			}
			else if($mode == "popularity")
			{
				 $categories = Category::all();
			}
			else if($mode == "numReviews")
			{
				  
				  $categories = DB::select(DB::raw('SELECT count(*) as counts,category_name
								FROM category
								LEFT JOIN posts
								ON category.id=posts.category_id
								group by category.id
								order by counts desc'));
			}
			
			return View::make('admin/order/index', compact('categories','title'));

            
	}

}