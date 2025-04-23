<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/chatbox.css">
</head>
<body>
    <?php include('components/nav2.php'); ?>

    

        <div class="main-content">
            <h2></h2>
            
            <div class="chat-box">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <?php 
                            $isSender = $message->sender_id == $_SESSION['user_id']; 
                        ?>
                        <div class="message <?php echo $isSender ? 'sender' : 'receiver'; ?>">
                            <p><strong><?php echo $isSender ? '' : ''; ?>:</strong> <?php echo htmlspecialchars($message->message); ?></p>
                            <span class="time">
                                <?php echo date('M d, Y h:i A', strtotime($message->created_at)); ?>
                            </span>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-messages">No messages yet. Start the conversation!</p>
                <?php endif; ?>
            </div>


            <div class="chat-input">
                <form action="<?= ROOT ?>/ChatBox/sendMessage" method="POST">
                    <input type="text" name="message" placeholder="Type your message..." required>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
   

    <!-- <?php include('components/footer.php'); ?> -->

</body>
</html>
