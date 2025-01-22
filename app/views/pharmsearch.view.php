<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmsearch.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <title>Pharmacy Search</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    
    <div class="dashboard-container">
    <?php include ('components/sidebar.php'); ?>
    <div class="search-container">
        <h1 class="search-heading">Search for Pharmacies</h1>
        <form action="<?=ROOT?>/PharmSearch" method="POST">
            <input type="text" name="name" placeholder="Search by name" class="search-bar">
            <input type="text" name="location" placeholder="Search by location" class="search-bar">
            <button type="submit" name="search" class="search-button">Search</button>
            <button type="submit" name="clear" class="clear-button">Clear</button>
        </form>
    </div>

    <div class="results-container">
    <?php if (!empty($pharmacies)): ?>
        <?php foreach ($pharmacies as $pharmacy): ?>
            <div class="pharmacy-card">
                <div class="pharmacy-image">
                    <img src="<?=ROOT?>/assets/images/<?=$pharmacy['image']?>" alt="<?=htmlspecialchars($pharmacy['name'])?>">
                </div>
                <div class="pharmacy-info">
                    <h2><?=htmlspecialchars($pharmacy['name'])?></h2>
                    <p><i class="fas fa-map-marker-alt"></i> <?=htmlspecialchars($pharmacy['location'])?></p>
                    
                    <!-- Rating and Reviews -->
                        <div class="rating">
                            <p>Rating: 
                                <span class="rating-stars">
                                    <?php 
                                    $rating = $pharmacy['rating'];
                                    echo str_repeat("⭐", floor($rating));
                                    if ($rating - floor($rating) >= 0.5) {
                                        echo "½";
                                    }
                                    ?>
                                </span>
                                <span class="rating-number">(<?= number_format($rating, 1) ?>)</span>
                            </p>
                            <button class="view-reviews-btn" onclick="location.href='<?=ROOT?>/reviews3/index/<?= $pharmacy['pharmacy_id'] ?>'">View Reviews</button>
                        </div>
                    
                    <!-- Description -->
                    <p class="description"><?=htmlspecialchars($pharmacy['description'])?></p>
                    
                    <!-- Details -->
                    <div class="pharmacy-details">
                        <p><strong>Contact:</strong> <?=htmlspecialchars($pharmacy['contact_no'])?></p>
                    </div>
                    
                    <!-- Services -->
                    <div class="services">
                        <h4>Services:</h4>
                        <p><?=htmlspecialchars($pharmacy['services'])?></p>
                    </div>
                    <button onclick="location.href='<?=ROOT?>/PetOwnerPlaceOrder'" class="book-button">Place Order</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-results">No results found.</p>
    <?php endif; ?>
    </div>
</div>
    <?php include ('components/footer.php'); ?>
</body>
</html> 