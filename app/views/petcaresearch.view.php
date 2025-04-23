<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petcaresearch.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Pet Care Search</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
    <?php include ('components/sidebar.php'); ?>
        <div class="search-container">
            <div class="search-header">
                <h1 class="search-heading">Search for Pet-Care Centers</h1>
                <form action="<?=ROOT?>/PetcareSearch" method="POST" class="search-form">
                    <div class="search-inputs">
                        <input type="text" name="name" placeholder="Search by name" class="search-bar">
                        <input type="text" name="location" placeholder="Search by location" class="search-bar">
                    </div>
                    <div class="search-buttons">
                        <button type="submit" name="search" class="search-button">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="submit" name="clear" class="clear-button">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <div class="results-container">
                <?php if (!empty($petCareCenters)): ?>
                    <div class="petCareCenter-grid">
                        <?php foreach ($petCareCenters as $petCareCenter): ?>
                            <div class="petCareCenter-card">
                                <div class="petCareCenter-image">
                                    <?php if (!empty($petCareCenter['profile_image'])): ?>
                                        <img src="data:image/jpeg;base64,<?= base64_encode($petCareCenter['profile_image']) ?>" 
                                            alt="<?= htmlspecialchars($petCareCenter['name']) ?>">
                                    <?php else: ?>
                                        <img src="<?=ROOT?>/assets/images/careprofile1.jpg" 
                                            alt="<?= htmlspecialchars($petCareCenter['name']) ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="petCareCenter-info">
                                    <h2><?= htmlspecialchars($petCareCenter['name']) ?></h2>
                                    <div class="rating">
                                        <span class="stars"><?= str_repeat("★", $petCareCenter['rating'] ?? 0) ?></span>
                                        <span class="reviews">(<?= $petCareCenter['review_count'] ?? 0 ?> reviews)</span>
                                    </div>
                                    <p class="location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= htmlspecialchars($petCareCenter['city']) . ', ' . htmlspecialchars($petCareCenter['district']) ?>
                                    </p>
                                    <p class="contact">
                                        <i class="fas fa-phone"></i>
                                        <?= htmlspecialchars($petCareCenter['contact_no']) ?>
                                    </p>
                                    <p class="services">
                                        <i class="fas fa-concierge-bell"></i>
                                        <?= htmlspecialchars($petCareCenter['services_offered'] ?? "Not Specified") ?>
                                    </p>
                                    
                                    <div class="card-buttons">
                                        <a href="<?=ROOT?>/reviews4/index/<?= $petCareCenter['care_center_id'] ?>" class="view-reviews-button">
                                            <i class="fas fa-star"></i> View Reviews
                                        </a>
                                        
                                        <form action="CareCenterProfile" method="POST" class="book-form">
                                            <input type="hidden" name="id" value="<?= $petCareCenter['care_center_id'] ?>">
                                            <button type="submit" class="book-button">
                                                <i class="fas fa-calendar-check"></i> Book Now
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <p>No results found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
