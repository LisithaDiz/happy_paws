<?php

class ChatBox
{
    use Controller;

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receiver_id'])) {
            $_SESSION['receiver_id'] = $_POST['receiver_id'];
            $receiver_id = $_POST['receiver_id'];
        } elseif (isset($_SESSION['receiver_id'])) {
            $receiver_id = $_SESSION['receiver_id'];
        } 

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receiver_role_number'])) {
            $_SESSION['receiver_role_number'] = $_POST['receiver_role_number'];
            $receiver_role_number = $_POST['receiver_role_number'];
        } elseif (isset($_SESSION['receiver_role_number'])) {
            $receiver_role_number = $_SESSION['receiver_role_number'];
        } 

        $messageModel = new MessageModel;
        $messages = $messageModel->getMessages($receiver_id,$receiver_role_number);

        $this->view('chatbox',['messages'=> $messages]);
    }

    public function sendMessage()
    {
        $receiver_id = $_SESSION['receiver_id'];
        $receiver_role_number = $_SESSION['receiver_role_number'];
        $message = $_POST['message'];
        $sender_id = $_SESSION['user_id'];
        $sender_role_number = $_SESSION['user_role']; 
        var_dump($receiver_id);
        var_dump($receiver_role_number);

        $data = [
            'sender_id' => $sender_id,
            'sender_role_number' => $sender_role_number,
            'receiver_id' => $receiver_id,
            'receiver_role_number' => $receiver_role_number,
            'message' => $message
        ];

        $messageModel = new MessageModel;
        $result = $messageModel->insert($data);

        if($result)
        {
            header("Location: " . ROOT . "/chatbox");
            exit;
        }
        else{
            echo "Something went wrong. Appointment could not be cancelled.";
        }


    }

}