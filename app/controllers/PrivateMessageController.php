<?php

class PrivateMessageController extends BaseController {

	protected $privateMessage;

	/**
	 * Inject the models.
	 * @param $category $category
	 */
	public function __construct(PrivateMessage $privateMessage) {
		parent::__construct();
		$this -> privateMessage = $privateMessage;
	}

	public function getIndex() {
		// Title
		$title = Lang::get('messages.title');
		// Grab all the blog posts
		$privateMessage = PrivateMessage::where('receiver', '=', Auth::user() -> username);
		// Show the page
		return View::make('site/pm/index', compact('privateMessage', 'title'));
	}

	public function getMessage($privateMessage) {
		// Title
		$title = Lang::get('messages.title');
		$privateMessage -> read = 1;
		$privateMessage -> save();
		// Show the page
		return View::make('site/pm/detail', compact('privateMessage', 'title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {

		// Title
		$title = Lang::get('messages.create');
		/*$receiver = null;
		 if (Auth::user()->hasRole('admin'))
		 {
		 //Define Receiver all users
		 $receiver;
		 }
		 else {
		 //Define Receiver all admin users
		 //Category
		 $init_recv = User::first();
		 $receiver = array($init_recv->id => $init_recv->category_name);
		 $categories = Category::all();
		 foreach($categories as $temp)
		 {

		 $category = array_add($category, $temp->id, $temp->category_name);
		 }
		 }*/

		// Show the page
		return View::make('site/pm/new_reply', compact('title'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		// Declare the rules for the form validation
		$rules = array('content' => 'required|min:3', 'title' => 'required|min:3', 'to' => 'required|exists:users,username');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Update the blog post data
			$messageSender = new PrivateMessageSender;
			$from = Auth::user();
			$to = User::where('username', '=', Input::get('to')) -> firstOrFail();
			$this -> privateMessage -> content = Input::get('content');
			$this -> privateMessage -> title = Input::get('title');
			$this -> privateMessage -> sender = $from -> username;
			$this -> privateMessage -> receiver = $to -> username;

			$messageSender -> content = Input::get('content');
			$messageSender -> title = Input::get('title');
			$messageSender -> sender = $from -> username;
			$messageSender -> receiver = $to -> username;
			// Was the blog post updated?
			if ($this -> privateMessage -> save() && $messageSender -> save()) {
				// Redirect to the new blog post page
				//return Redirect::to('message_service/create') -> with('success', Lang::get('messages.success'));
				return View::make('closeme');
			}

			// Redirect to the blog post create page
			return Redirect::to('message_service/create') -> with('error', Lang::get('admin/campaign/messages.create.error'));
		}

		// Form validation failed
		return Redirect::to('message_service/create') -> withInput() -> withErrors($validator);
	}

	public function getReply($privateMessage) {
		$title = Lang::get('messages.reply_title');
		return View::make('site/pm/new_reply', compact('privateMessage', 'title'));
	}

	public function postReply($privateMessage) {
		// Declare the rules for the form validation
		$rules = array('content' => 'required|min:3', 'title' => 'required|min:3', 'to' => 'required|exists:users,username');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Update the blog post data
			$messageSender = new PrivateMessageSender;
			$from = Auth::user();
			$to = User::where('username', '=', Input::get('to')) -> firstOrFail();
			$this -> privateMessage -> content = Input::get('content');
			$this -> privateMessage -> title = Input::get('title');
			$this -> privateMessage -> sender = $from -> username;
			$this -> privateMessage -> receiver = $to -> username;

			$messageSender -> content = Input::get('content');
			$messageSender -> title = Input::get('title');
			$messageSender -> sender = $from -> username;
			$messageSender -> receiver = $to -> username;
			// Was the blog post updated?
			if ($this -> privateMessage -> save() && $messageSender -> save()) {
				// Redirect to the new blog post page
				//return Redirect::to('message_service/reply/' . $privateMessage -> id) -> with('success', Lang::get('messages.success'));
				return View::make('closemenoparent');
			}

			// Redirect to the blog post create page
			return Redirect::to('message_service/reply/' . $privateMessage -> id) -> with('error', Lang::get('admin/campaign/messages.create.error'));
		}

		// Form validation failed
		return Redirect::to('message_service/create') -> withInput() -> withErrors($validator);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $post
	 * @return Response
	 */

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $post
	 * @return Response
	 */
	public function getDelete($privateMessage) {
		// Title
		$title = Lang::get('messages.delete_title');

		// Show the page
		return View::make('site/pm/delete', compact('privateMessage', 'title'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $post
	 * @return Response
	 */
	public function postDelete($privateMessage) {
		// Declare the rules for the form validation
		if (Auth::user() -> username == $privateMessage -> receiver) {
			$rules = array('id' => 'required|integer');
			// Validate the inputs
			$validator = Validator::make(Input::all(), $rules);

			// Check if the form validates with success
			if ($validator -> passes()) {
				$id = $privateMessage -> id;
				$privateMessage -> delete();

				if (empty($privateMessage)) {
					// Redirect to the blog posts management page
					return Redirect::to('message_service') -> with('success', Lang::get('messages.delete.success'));
				}
			}
			// There was a problem deleting the blog post
			return Redirect::to('message_service') -> with('error', Lang::get('messages.delete.error'));
		}

	}

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {

		$privateMessage = PrivateMessage::select(array('private_message.id', 'private_message.title', 'private_message.sender', 'private_message.created_at','private_message.read')) -> where('private_message.receiver', '=', Auth::user() -> username);

		//$posts = Post::leftjoin('category', 'posts.category_id', '=', 'category.id')
		//->select(array('posts.id', 'posts.title', 'category.category_name as category ','posts.id as comments', 'posts.created_at'));

		return Datatables::of($privateMessage) 
		-> edit_column('title', '<a href="{{{ URL::to(\'message_service/view/\'. $id) }}}">{{{ Str::limit($title, 40, \'...\') }}}</a>') 
		-> add_column('actions', '<a href="{{{ URL::to(\'message_service/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>') 
        -> remove_column('id') 
        -> make();
	}

	public function autocomplete() {
		/*$mysql_server = 'localhost';
		$mysql_login = 'root';
		$mysql_password = '';
		$mysql_database = 'laravel';

		mysql_connect($mysql_server, $mysql_login, $mysql_password);
		mysql_select_db($mysql_database);

		$req = "SELECT username " . "FROM users " . "WHERE username LIKE '%" . $_REQUEST['term'] . "%' ";

		$query = mysql_query($req);

		while ($row = mysql_fetch_array($query)) {
			$results[] = array('label' => $row['username']);
		}

		echo json_encode($results);
		 
		*/
		$match = '%' .Input::get('term') . '%';
		$init_user =  User::where('username', 'like', $match)->firstOrFail();
		$results = array($init_user->id => $init_user->username);

		$query = User::where('username', 'like', $match)->get();
		foreach($query as $user)
		{
			$results = array_add($results, $user->id, $user->username);
		}
		echo json_encode($results);
		
	}

}
