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
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Vet Profile</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <?php include ('components/sidebar3.php'); ?>
        
        <div class="booking-container">
            <?php if (isset($vetDetails) && !empty($vetDetails)): ?>
            <?php $vet = $vetDetails[0]; ?>
            <div class="center-profile-section">
                <div class="cover-image">
                    <img src="<?=ROOT?>/assets/images/cover1-min.jpg" alt="Vet Cover Image" class="cover-image">
                </div>

                <div class="profile-header">
                    <div class="profile-image1">
                        <?php if (!empty($vet->profile_image)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($vet->profile_image) ?>" 
                                alt="Vet Profile Image" class="profile-image1">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Default Profile Image" class="profile-image1">
                        <?php endif; ?>
                    </div>
                    <div class="profile-info1">
                        <h1>Dr. <?= htmlspecialchars($vet->f_name) ?> <?= htmlspecialchars($vet->l_name) ?></h1>
                        
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(25 reviews)</span>
                        </div>
                        <!-- Message Button -->
                        <form method="POST" action="<?=ROOT?>/chatbox/index">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($vet->user_id) ?>">
                                <input type="hidden" name="receiver_role_number" value="3" >
                                <button type="submit" class="message-btn">Message</button>
                            </form>
                        <p class="location">
                            <i class="fas fa-map-marker-alt"></i> 
                            <?= htmlspecialchars($vet->district) ?>, 
                            <?= htmlspecialchars($vet->city) ?>
                        </p>
                        <p class="contact"><i class="fas fa-phone"></i> <?= htmlspecialchars($vet->contact_no) ?></p>
                        <p class="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($vet->email) ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-card">
                        <h3><i class="fas fa-user-md"></i> Professional Information</h3>
                        <p><strong>License No:</strong> <?= htmlspecialchars($vet->license_no) ?></p>
                        <p><strong>Years of Experience:</strong> <?= htmlspecialchars($vet->years_exp) ?></p>
                        <p><strong>Specializations:</strong> General Practice, Surgery</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3><i class="fas fa-info-circle"></i> About Me</h3>
                        <p><?= !empty($vet->about_us) ? htmlspecialchars($vet->about_us) : 'Dedicated veterinarian with '.htmlspecialchars($vet->years_exp).' years of experience providing exceptional care for pets. Committed to ensuring the health and well-being of all animals through compassionate service and medical expertise.' ?></p>
                    </div>
                    
                    
            </div>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-user-md"></i>
                    <p>No vet details found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
 
    
    
    <?php include ('components/footer.php'); ?>
</body>
</html>