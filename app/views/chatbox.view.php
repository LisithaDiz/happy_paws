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

    <div class="dashboard-container">
        <?php include('components/sidebar.php'); ?>

        <div class="main-content">
            <h2>Chat with Dr. Smith (Vet)</h2>
            
            <div class="chat-box">
                <?php
                // Assuming you fetched the messages in $messages array from your database
                $messages = [
                    ['sender_id' => 1, 'receiver_id' => 2, 'message' => 'Hi Doctor, my dog seems to be limping since morning.', 'timestamp' => '2025-04-19 09:02:00'],
                    ['sender_id' => 2, 'receiver_id' => 1, 'message' => 'Sorry to hear that! Did something happen?', 'timestamp' => '2025-04-19 09:05:00'],
                    ['sender_id' => 1, 'receiver_id' => 2, 'message' => 'I’m not sure. She was playing in the garden yesterday evening.', 'timestamp' => '2025-04-19 09:06:00'],
                    ['sender_id' => 2, 'receiver_id' => 1, 'message' => 'Bring her to the clinic if the limp continues. I’ll be available at 4 PM.', 'timestamp' => '2025-04-19 09:10:00'],
                ];

                // Loop through each message and display it
                foreach ($messages as $message) {
                    $isSender = $message['sender_id'] == 1; // Assuming 1 is Pet Owner (sender)
                    ?>
                    <div class="message <?php echo $isSender ? 'sender' : 'receiver'; ?>">
                        <p><strong><?php echo $isSender ? 'You' : 'Dr. Smith'; ?>:</strong> <?php echo $message['message']; ?></p>
                        <span class="time"><?php echo date('h:i A', strtotime($message['timestamp'])); ?></span>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="chat-input">
                <form action="<?= ROOT ?>/sendMessage" method="POST">
                    <input type="text" name="message" placeholder="Type your message..." required>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>

    <?php include('components/footer.php'); ?>

</body>
</html>
