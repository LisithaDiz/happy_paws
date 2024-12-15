<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetsearch.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">


    <title>Search Vets</title>
    <link rel="stylesheet" href="../css/vetsearch.css">
</head>
<body>

    <?php include ('components/nav2.php'); ?>
    
        <div class="dashboard-container">
        <?php include ('components/sidebar.php'); ?>


    <div class="search-container">
        <h1 class="search-heading">Search for Veterinary Surgeons</h1>
        <form action="<?=ROOT?>/VetSearch" method="POST">
            <input type="text" name="name" placeholder="Search by name" class="search-bar">
            <input type="text" name="location" placeholder="Search by location" class="search-bar">
            <button type="submit" name="search" class="search-button">Search</button>
            <button type="submit" name="clear" class="clear-button">Clear</button>
        </form>
    </div>

    <div class="results-container">
        <?php if (!empty($vets)): ?>
            <?php foreach ($vets as $vet): ?>
                <div class="vet-card">
                    <div class="vet-image">
                        <img src="<?=ROOT?>/assets/images/default-vet.jpg" alt="<?php echo htmlspecialchars($vet['name']); ?>">
                    </div>
                    <div class="vet-info">
                        <h2><?php echo htmlspecialchars($vet['name']); ?></h2>
                        <p>Location: <?php echo htmlspecialchars($vet['location']); ?></p>
                        <?php if (isset($vet['rating'])): ?>
                            <p>Rating: <span class="rating-stars"><?php echo str_repeat("⭐", floor($vet['rating'])); ?></span></p>
                        <?php else: ?>
                            <p>Rating: Not available</p>
                        <?php endif; ?>
                        <button class="view-reviews-btn" onclick="location.href='<?=ROOT?>/reviews2/index/<?= $vet['vet_id'] ?>'">View Reviews</button>
                        <p>Related Pets: Dogs, Cats, Birds</p>
                        <a href="<?=ROOT?>/PetOwnerAppointments" class="book-button">Book</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: black;">No results found.</p>
        <?php endif; ?>
    </div>
    </div>

    <?php include ('components/footer.php'); ?>
</body>
</html>
