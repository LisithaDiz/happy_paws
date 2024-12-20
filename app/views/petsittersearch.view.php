<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsittersearch.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

    <title>Pet Sitter Search</title>
</head>
<body>
    <?php include ('components/nav.php'); ?>
    <?php
        include 'components/renderSidebar.php';
        echo renderSidebar(ROOT, $petowner);
        ?>
<div class="dashboard-container">
       
    <div class="search-container">
        <h1 class="search-heading">Search for Pet Sitters</h1>
        <form action="<?=ROOT?>/PetsitterSearch" method="POST">
            <input type="text" name="name" placeholder="Search by name" class="search-bar">
            <input type="text" name="location" placeholder="Search by location" class="search-bar">
            <button type="submit" name="search" class="search-button">Search</button>
            <button type="submit" name="clear" class="clear-button">Clear</button>
        </form>
    </div>

    <div class="results-container">
    <?php if (!empty($petSitters)): ?>
        <?php foreach ($petSitters as $petSitter): ?>
            <div class="petsitter-card">
                <div class="petsitter-image">
                    <img src="<?=ROOT?>/assets/images/<?=$petSitter['image']?>" alt="<?=htmlspecialchars($petSitter['name'])?>">
                </div>
                    <div class="petsitter-info">
                    <h2><?=htmlspecialchars($petSitter['name'])?></h2>
                    <p><i class="fas fa-map-marker-alt"></i> <?=htmlspecialchars($petSitter['location'])?></p>
                    
                    <!-- Rating and Reviews -->
                    <div class="rating">
                        <p>Rating: <span class="rating-stars"><?php echo str_repeat("⭐", floor($petSitter['rating'])); ?></span></p>
                        <a href="<?=ROOT?>/reviews/index/<?=$petSitter['sitter_id']?>" class="view-reviews-btn">
                            View Reviews
                        </a>
                    </div>
                    
                    <!-- Description -->
                    <p class="description"><?=htmlspecialchars($petSitter['description'])?></p>
                    
                    <!-- Details -->
                    <div class="sitter-details">
                        <p><strong>Experience:</strong> <?=htmlspecialchars($petSitter['experience'])?></p>
                        <p><strong>Availability:</strong> <?=htmlspecialchars($petSitter['availability'])?></p>
                        <p><strong>Price:</strong> <?=htmlspecialchars($petSitter['price'])?></p>
                        <p><strong>Contact:</strong> <?=htmlspecialchars($petSitter['contact_no'])?></p>
                    </div>
                    
                    <!-- Services -->
                    <div class="services">
                        <h4>Services:</h4>
                        <p><?=htmlspecialchars($petSitter['services'])?></p>
                    </div>
                    
                    <button class="book-button" onclick="location.href='<?=ROOT?>/PetOwnerSitterSelection'"> 
                                                                                                                       <!-- <?=$petSitter['sitter_id']?> -->
                        Book Now
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-results">No pet sitters found matching your criteria.</p>
    <?php endif; ?>
    </div>
</div>
    <?php include ('components/footer.php'); ?>
</body>
</html>
