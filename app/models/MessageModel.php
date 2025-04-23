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
            'receiver_role_number',
            'message',
            'created_at',
            'is_read'

	];

    public function getMessages($receiver_id, $receiver_role_number)
    {
        $sender_id = $_SESSION['user_id'];
        $sender_role_number = $_SESSION['user_role'];  

        $query = "SELECT * FROM messages
                WHERE 
                (sender_id = :sender_id AND sender_role_number = :sender_role_number 
                AND receiver_id = :receiver_id AND receiver_role_number = :receiver_role_number)
                OR
                (sender_id = :receiver_id AND sender_role_number = :receiver_role_number 
                AND receiver_id = :sender_id AND receiver_role_number = :sender_role_number)
                ORDER BY created_at ASC";  

        $data = [
            'sender_id' => $sender_id,
            'sender_role_number' => $sender_role_number,
            'receiver_id' => $receiver_id,
            'receiver_role_number' => $receiver_role_number
        ];

        $result =  $this->query($query, $data);
        return $result;


    }

    

	
   


}