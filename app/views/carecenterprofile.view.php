<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">

    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/carecenterprofile.css">

    <title>Pet Care Search</title>
    <!-- <link rel="stylesheet" href="../css/petcaresearch.css"> -->
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php
            if ($_SESSION['user_role']==4){
                include ('components/sidebar5.php');
            }
            if ($_SESSION['user_role']==1){
                // include ('components/sidebar5.php');
                include 'components/renderSidebar.php';
                echo renderSidebar(ROOT, $petowner);
                
            }
        ?>
    <!-- <div class="results-container"> -->
    <div class="main-content">
    <?php
            // Assuming $care_center[0]->cover_image and $care_center[0]->profile_image contain binary image data
            $cover_image_base64 = base64_encode($care_center[0]->cover_image ?? '');
            $profile_image_base64 = base64_encode($care_center[0]->profile_image ?? '');

            $default_cover_image = 'default_cover.jpg';
            $default_profile_image = 'default_profile.jpg';

            $cover_image_src = !empty($cover_image_base64) ? "data:image/jpeg;base64,{$cover_image_base64}" : $default_cover_image;
            $profile_image_src = !empty($profile_image_base64) ? "data:image/jpeg;base64,{$profile_image_base64}" : $default_profile_image;
        ?>
        
        <section id="profile">
            <div class="container">
                <div class="cover-image" style="background-image: url('<?php echo $cover_image_src; ?>');"></div>
                <div class="profile-image">
                    <img src="<?php echo $profile_image_src; ?>" alt="Profile Image">
                </div>
            </div>
            
            <h2><?php echo htmlspecialchars($care_center[0]->name ?? 'Care Center Name'); ?></h2>
            <p><strong>District:</strong> <?= htmlspecialchars($care_center[0]->district ?? 'N/A') ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($care_center[0]->city ?? 'N/A') ?></p>
            <p><strong>Contact Number:</strong> <?= htmlspecialchars($care_center[0]->contact_no ?? 'N/A') ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($care_center[0]->email ?? 'N/A') ?></p>
            <p><strong>Opening Hours:</strong> <?= htmlspecialchars($care_center[0]->opening_hours ?? 'N/A') ?></p>
            <p><strong>Services Offered:</strong> <?= htmlspecialchars($care_center[0]->services_offered ?? 'N/A') ?></p>
            <p><strong>About Us:</strong> <?= htmlspecialchars($care_center[0]->about_us ?? 'N/A') ?></p>
            <?php if ($_SESSION['user_role'] == 'petCareCenter'){?>
                <button onclick="window.location.href='edit_profile.php'"><i class="fas fa-edit"></i> Edit Profile</button>
            <?php } ?>
        </section>

        <section id="cage-management">
            <h2><i class="fas fa-home"></i> Cages</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cage Name</th>
                        <th>Number of Cages</th>
                        <th>Size (H x L x W) (m)</th>
                        <th>Designed For</th>
                        <th>Location</th>
                        <th>Additional Features</th>
                        <th>Available Cages</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cages)): foreach ($cages as $cage): ?>
                        <tr>
                            <td><?= htmlspecialchars($cage->cage_name ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($cage->number_of_cages ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($cage->height ?? 'N/A') . ' x ' . htmlspecialchars($cage->length ?? 'N/A') . ' x ' . htmlspecialchars($cage->width ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($cage->designed_for ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($cage->location ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($cage->additional_features ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($cage->available_cages ?? 'N/A'); ?></td>
                            <td>
                                <button class="book-btn" data-cage-id="<?= htmlspecialchars($cage->cage_id ?? '') ?>"> 
                                    <i class="fas fa-calendar-check"></i> Book
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="8">No cages found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

 
    <?php include ('components/footer.php'); ?>
</body>
</html>


