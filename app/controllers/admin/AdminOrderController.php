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
	public function __construct(Category $category) {
		parent::__construct();
		$this -> category = $category;
	}

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex() {
		// Title

		$title = Lang::get('admin/category/title.order_management');

		// Grab all the blog posts
		// $categories = Category::all();
		$order = CategoryOrder::all();
		$mode = CategoryOrder::getMode();
		$categories = CategoryOrder::getOrder($mode);
		$message = null;
		// Show the page
		return View::make('admin/order/index', compact('categories', 'title', 'mode','message'));
		
	}

	public function changeOrder($mode) {
		//Sort Category by mode
		$title = Lang::get('admin/category/title.order_management');
		$categories = CategoryOrder::getOrder($mode);
		$message = null;
		return View::make('admin/order/index', compact('categories', 'title', 'mode','message'));
		

	}

	public function saveOrder($mode) {
		//Sort Category by mode
		$title = Lang::get('admin/category/title.order_management');
		$categories = CategoryOrder::getOrder($mode);
		$message = "Change Category Order succeeded.";
		$rank = 1;
		foreach ($categories as $category) {
			$temp = Category::find($category -> id);
			$temp -> rank = $rank;
			$rank++;
			$temp -> save();
		}
		$order = CategoryOrder::all();
		$user = Auth::user();
		foreach ($order as $orderMode) {
			$orderMode -> mode = $mode;
			$orderMode -> user_id = $user->id;
			$orderMode -> save();
		}
		return Redirect::to('admin/order')->with('success', Lang::get('admin/order/messages.change.success'));
		

	}

}
