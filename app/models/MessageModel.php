<?php 

class MessageModel
{
	
	use Model;

	protected $table = 'messages';

	protected $allowedColumns = [

	        'message_id',
            'sender_id',
            'sender_role_number',
            'receiver_id',
            'receriver_role_number',
            'message',
            'created_at',
            'is_read'

	];

	
   


}