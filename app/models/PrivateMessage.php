<?php


class PrivateMessage extends Eloquent {	
    protected $table = 'private_message';
		public $timestamps = false;
	public function sender()
	{
		return $this->belongsTo('User', 'sender');
	}
	public function receiver()
	{
		return $this->belongsTo('User', 'receiver');
	}
	public static function newMessage($username)
	{
		return PrivateMessage::where('receiver', '=', $username)->where('read','=','new')->count();
	}
}

?>