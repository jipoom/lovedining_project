<?php

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect){return $redirect;}

        // Show the page
        return View::make('site/user/index', compact('user'));
    }

    /**
     * Stores new user
     *
     */
    public function postIndex()
    {
        $rules = array(
			'email' => array('regex:(^((?![0-9A-Za-z]*@hotmail.com[0-9A-Za-z]*).)*$)')
		);
		
		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);	
		// Check if the form validates with success
		if ($validator->passes())
		{
			
	        $this->user->username = Input::get( 'username' );
	        $this->user->email = Input::get( 'email' );
			$this->user->firstname = Input::get( 'firstname' );
			$this->user->lastname = Input::get( 'lastname' );
			$this->user->age_id = Input::get( 'age' );
			$this->user->sex_id = Input::get( 'sex' );
			$this->user->income_id = Input::get( 'income' );
	        $password = Input::get( 'password' );
	        $passwordConfirmation = Input::get( 'password_confirmation' );
	
	        if(!empty($password)) {
	            if($password === $passwordConfirmation) {
	                $this->user->password = $password;
	                // The password confirmation will be removed from model
	                // before saving. This field will be used in Ardent's
	                // auto validation.
	                $this->user->password_confirmation = $passwordConfirmation;
	            } else {
	                // Redirect to the new user page
	                return Redirect::to('user/create')
	                    ->withInput(Input::except('password','password_confirmation'))
	                    ->with('error', Lang::get('admin/users/messages.password_does_not_match'));
	            }
	        } else {
	            unset($this->user->password);
	            unset($this->user->password_confirmation);
	        }
	
	        // Save if valid. Password field will be hashed before save
	        $this->user->save();
			if(Input::get('foodType_id_temp'))
					$this->user->foodType()->sync(Input::get('foodType_id_temp'));
	        if ( $this->user->id )
	        {
	            // Redirect with success message, You may replace "Lang::get(..." for your custom message.
	            $roles = array('0'=>'2');
				$this->user->saveRoles($roles);
	            return Redirect::to('user/login')
	                ->with( 'notice', Lang::get('user/user.user_account_created') );
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            $error = $this->user->errors()->all();
	
	            return Redirect::to('user/create')
	                ->withInput(Input::except('password'))
	                ->with( 'error', $error );
	        }
	       }
		else{
			 return Redirect::to('user/create')
	                    ->withInput(Input::except('password','password_confirmation'))
	                    ->with('error', 'Please change your email, domain hotmail.com is not reachable');
		}
				
    }

    /**
     * Edits a user
     *
     */
    public function postEdit($user)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), $user->getUpdateRules());


        if ($validator->passes())
        {
            $oldUser = clone $user;
            $user->username = Input::get( 'username' );
            $user->email = Input::get( 'email' );
			$user->firstname = Input::get( 'firstname' );
			$user->lastname = Input::get( 'lastname' );
			$user->age_id = Input::get( 'age' );
			$user->sex_id = Input::get( 'sex' );
			$user->income_id = Input::get( 'income' );
			
            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );
			
            if(!empty($password)) {
                if($password === $passwordConfirmation) {
                    $user->password = $password;
                    // The password confirmation will be removed from model
                    // before saving. This field will be used in Ardent's
                    // auto validation.
                    $user->password_confirmation = $passwordConfirmation;
                } else {
                    // Redirect to the new user page
                    return Redirect::to('users')->with('error', Lang::get('admin/users/messages.password_does_not_match'));
                }
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            $user->prepareRules($oldUser, $user);
			// Save Favorite Food Type
			if(Input::get('foodType_id_temp'))
				$newUser = User::where('username','=',Input::get( 'username' ))->first();
				$newUser->foodType()->sync(Input::get('foodType_id_temp'));
            // Save if valid. Password field will be hashed before save
            $user->amend();
        }

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
            return Redirect::to('user')
                ->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            return Redirect::to('user')
                ->withInput(Input::except('password','password_confirmation'))
                ->with( 'error', $error );
        }
    }

    /**
     * Displays the form for user creation
     *
     */
    public function getCreate()
    {
        return View::make('site/user/create');
    }


    /**
     * Displays the login form
     *
     */
    public function getLogin()
    {
        //Logout from the userSocial
        Session::forget('socialUser');	
        $user = Auth::user();
        if(!empty($user->id)){
            return Redirect::to('/');
        }

        return View::make('site/user/login');
    }

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        $input = array(
            'email'    => Input::get( 'email' ), // May be the username too
            'username' => Input::get( 'email' ), // May be the username too
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
        );
		
        // If you wish to only allow login from confirmed users, call logAttempt
        // with the second parameter as true.
        // logAttempt will check if the 'email' perhaps is the username.
        // Check that the user is confirmed.
        if ( Confide::logAttempt( $input, true ) )
        {
            $url = Session::get('previousPage');
            Session::forget('previousPage');	
            return Redirect::intended($url);
        }
        else
        {
            // Check if there was too many login attempts
            if ( Confide::isThrottled( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ( $this->user->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::to('user/login')
                ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string  $code
     */
    public function getConfirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public function postForgot()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_forgot') );
        }
        else
        {
            return Redirect::to('user/forgot')
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_forgot') );
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {

        return View::make('site/user/reset')
            ->with('token',$token);
    }


    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( Confide::resetPassword( $input ) )
        {
            return Redirect::to('user/login')
            ->with( 'notice', Lang::get('confide::confide.alerts.password_reset') );
        }
        else
        {
            return Redirect::to('user/reset/'.$input['token'])
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_reset') );
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();
		Session::flush();
        return Redirect::to('/');
    }

    /**
     * Get user's profile
     * @param $username
     * @return mixed
     */
    public function getProfile($username)
    {
        $userModel = new User;
        $user = $userModel->getUserByUsername($username);

        // Check if the user exists
        if (is_null($user))
        {
            return App::abort(404);
        }

        return View::make('site/user/profile', compact('user'));
    }

    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect){return $redirect;}

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect($url1,$url2,$url3)
    {
        $redirect = '';
        if( ! empty( $url1 ) )
        {
            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }
	
	
	
	// Facebook Login
	public function fbLoginAction(){
		//Logout from the website
		Confide::logout();
        // get data from input
	    $code = Input::get( 'code' );
	
	    // get fb service
	    $fb = OAuth::consumer( 'Facebook' );
	
	    // check if code is valid
	
	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {
	
	        // This was a callback request from facebook, get the token
	        $token = $fb->requestAccessToken( $code );
	
	        // Send a request with it
	        $result = json_decode( $fb->request( '/me' ), true );
	
	        $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
	        echo $message. "<br/>";
	
	        //Var_dump
	        //display whole array().
	        
	        /*
			 * 
			 *array(11) { ["id"]=> string(17) "10154442001970001" ["email"]=> string(19) "ji_poom@hotmail.com" ["first_name"]=> string(7) "Jirapat" ["gender"]=> string(4) "male" ["last_name"]=> string(12) "Temvuttirojn" ["link"]=> string(62) "https://www.facebook.com/app_scoped_user_id/10154442001970001/" ["locale"]=> string(5) "en_US" ["name"]=> string(20) "Jirapat Temvuttirojn" ["timezone"]=> int(7) ["updated_time"]=> string(24) "2014-04-10T02:46:50+0000" ["verified"]=> bool(true) }
			 */

	        Session::put('socialUser', $result);
	        Session::put('socialUser.isLogin', true);

	        return Redirect::to('/');
	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();
	
	        // return to facebook login url
	        return Redirect::to( (string)$url );
	    }  
	}
 	public function logoutSocial()
    {
         Session::forget('socialUser');	
         return Redirect::to('/');
    }
	
}
