<?php


class PrivateMessageSender extends Eloquent {	
    protected $table = 'private_message_sender';
		public $timestamps = false;
	public function sender()
	{
		return $this->belongsTo('User', 'sender');
	}
	public function receiver()
	{
		return $this->belongsTo('User', 'receiver');
	}
	
}

?>