<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsitterprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Sitter Profile</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include ('components/sidebar3.php'); ?>

        <div class="booking-container">
            <?php if (isset($sitterDetails) && !empty($sitterDetails)): ?>
            <?php $sitter = $sitterDetails[0]; ?>
            <div class="center-profile-section">
                <div class="cover-image">
                    <img src="<?=ROOT?>/assets/images/cover1-min.jpg" alt="Sitter Cover Image" class="cover-image">
                </div>

                <div class="profile-header">
                    <div class="profile-image1">
                        <?php if (!empty($sitter->profile_image)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($sitter->profile_image) ?>" 
                                alt="Sitter Profile Image" class="profile-image1">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Default Profile Image" class="profile-image1">
                        <?php endif; ?>
                    </div>
                    <div class="profile-info1">
                        <h1><?= htmlspecialchars($sitter->f_name) ?> <?= htmlspecialchars($sitter->l_name) ?></h1>
                        
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(30 reviews)</span>
                        </div>
                        <!-- Message Button -->
                        <form method="POST" action="<?=ROOT?>/chatbox/index">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($sitter->user_id) ?>">
                                <input type="hidden" name="receiver_role_number" value="3" >
                                <button type="submit" class="message-btn">Message</button>
                            </form>
                        <p class="location">
                            <i class="fas fa-map-marker-alt"></i> 
                            <?= htmlspecialchars($sitter->street) ?>,
                            <?= htmlspecialchars($sitter->city) ?>,
                            <?= htmlspecialchars($sitter->district) ?>
                            
                        </p>
                        <p class="contact"><i class="fas fa-phone"></i> <?= htmlspecialchars($sitter->contact_no) ?></p>
                        <p class="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($sitter->email) ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-card">
                        <h3><i class="fas fa-paw"></i> Pet Sitting Details</h3>
                        <p><strong>Username:</strong> <?= htmlspecialchars($sitter->username) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($sitter->email) ?></p>
                        <p><strong>Age:</strong> <?= htmlspecialchars($sitter->age) ?></p>
                        <p><strong>Years of Experience:</strong> <?= htmlspecialchars($sitter->years_exp) ?></p>
                        <p><strong>Service Types:</strong> <?= htmlspecialchars($sitter->service_types ?? 'Pet Boarding, Home Visits') ?></p>
                    </div>

                    <div class="detail-card">
                        <h3><i class="fas fa-info-circle"></i> About Me</h3>
                        <p><?= !empty($sitter->about_us) ? htmlspecialchars($sitter->about_us) : 'Passionate pet sitter with '.htmlspecialchars($sitter->years_exp).' years of experience, providing loving care for pets in their owner’s absence.' ?></p>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-user"></i>
                    <p>No sitter details found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


  

    <?php include ('components/footer.php'); ?>
</body>
</html>
