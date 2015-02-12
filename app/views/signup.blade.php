<form method="POST" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        
        <div class="form-group">
            <label for="firstname">Firstname*</label>
            <input class="form-control" placeholder="  ชื่อ" type="text" name="firstname" id="firstname" value="{{{ Input::old('firstname') }}}">
        </div>
        <div class="form-group">
            <label for="lastname">Lastname*</label>
            <input class="form-control" placeholder="  นามสกุล" type="text" name="lastname" id="lastname" value="{{{ Input::old('lastname') }}}">
        </div>
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}*</label>
            <input class="form-control" placeholder="  {{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}}* <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
            <input class="form-control" placeholder="  {{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}"><font color="blue">We do not support <strong>hotmail.com</strong> </font>
        </div>
         <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}*</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
         <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}*</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>
        <div class="form-group">
            <label for="age">Age</label>
        	{{ Form::select('age', Age::getAllAgeArray(), '2', array('class'=>'input-block-level'))}}   
        </div>
        <div class="form-group">
            <label for="sex">Sex</label>
        	 {{ Form::select('sex', Sex::getAllSexArray(), '1', array('class'=>'input-block-level'))}}
        </div>
        <div class="form-group">
            <label for="income">Income</label>
        	{{ Form::select('income', Income::getAllIncomeArray(), '1', array('class'=>'input-block-level'))}} 
        </div>
        <div class="form-group">
            <label for="age">ประเภทอาหารที่ชอบ</label></br>
        	 <?php 
        	 $i=0; 
        	 ?>
			 @foreach(FoodType::orderBy('name','asc')->get() as $temp)
				{{ Form::checkbox('foodType_id_temp[]', $temp->id, null, array('class'=>'input-block-level'))}}
				{{ $temp->name}}
				<P>	 
				<?php $i++;?>
			@endforeach 
        </div>
        

        @if ( Session::get('error') )
            <div class="alert alert-error alert-danger">
                @if ( is_array(Session::get('error')) )
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if ( Session::get('notice') )
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
