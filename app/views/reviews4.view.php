<?php
// Debug output
echo "<!-- Debug Info:\n";
echo "care_center_id: " . (isset($care_center_id) ? $care_center_id : 'not set') . "\n";
echo "care_center_name: " . (isset($care_center_name) ? $care_center_name : 'not set') . "\n";
echo "reviews count: " . (isset($reviews) ? count($reviews) : 'not set') . "\n";
echo "-->";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <title>PetCare Center Reviews</title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/reviews4.css">
</head>
<body>
    <?php include 'components/nav2.php'; ?>
    <?php include ('components/sidebar.php'); ?>
    <div class="container">
        <div class="reviews-container">
            <?php if (isset($is_editing) && isset($review)): ?>
                <!-- Edit Review Form -->
                <h3 class="search-heading">Edit Review for <?= htmlspecialchars($care_center_name) ?></h3>
                <div class="edit-review-container care_center-card">
                    <form method="POST" action="<?= ROOT ?>/reviews4/edit/<?= $review->review_id ?>">
                        <div class="form-group">
                            <label>Rating:</label>
                            <select name="rating" required class="search-bar">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <option value="<?= $i ?>" <?= $review->rating == $i ? 'selected' : '' ?>>
                                        <?= $i ?> Star<?= $i > 1 ? 's' : '' ?> <?= str_repeat('⭐', $i) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Comment:</label>
                            <textarea name="comment" required class="search-bar" style="min-height: 100px;"><?= htmlspecialchars($review->comment) ?></textarea>
                        </div>
                        <div class="button-group">
                            <button type="submit" class="button update-button">Update Review</button>
                            <a href="<?= ROOT ?>/reviews4/index/<?= $review->care_center_id ?>" class="button search-button">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <h2 class="search-heading">
                    Reviews for <?= isset($care_center_name) && $care_center_name ? htmlspecialchars($care_center_name) : 'Pet Care Center' ?>
                    <?php if (isset($error)): ?>
                        <div class="error-message"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                </h2>
                <?php if (!isset($_SESSION['owner_id'])): ?>
                    <p class="login-prompt">Please <a href="<?= ROOT ?>/login">login</a> to leave a review</p>
                <?php elseif (!isset($has_reviewed) || !$has_reviewed): ?>
                    <!-- Add New Review Section -->
                    <div class="add-review-container care_center-card">
                        <?php
                        echo "<!-- Debug: \n";
                        echo "care_center_id: " . (isset($care_center_id) ? $care_center_id : 'not set') . "\n";
                        echo "owner_id: " . (isset($_SESSION['owner_id']) ? $_SESSION['owner_id'] : 'not set') . "\n";
                        echo "-->";
                        ?>

                        <form method="POST" action="<?= ROOT ?>/reviews4/add" onsubmit="return validateForm()">
                            <?php if(isset($error)): ?>
                                <div class="error-message"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>
                            
                            <input type="hidden" name="care_center_id" value="<?= htmlspecialchars($care_center_id) ?>">
                            <div class="form-group">
                                <label>Rating:</label>
                                <select name="rating" required class="search-bar">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?> <?= str_repeat('⭐', $i) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Comment:</label>
                                <textarea name="comment" required class="search-bar" style="min-height: 100px;" placeholder="Write your review here..."></textarea>
                            </div>
                            <button type="submit" name="submit_review" class="button submit-button">Submit Review</button>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Reviews List -->
                <div class="results-container">
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="care_center-card">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <h3 class="reviewer-name"><?= htmlspecialchars($review->owner_name) ?></h3>
                                        <div class="rating-date">
                                            <span class="rating"><?= str_repeat('⭐', $review->rating) ?></span>
                                            <span class="date"><?= date('M d, Y', strtotime($review->created_at)) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment">
                                    <?= nl2br(htmlspecialchars($review->comment)) ?>
                                </div>
                                <?php if (isset($_SESSION['owner_id']) && $_SESSION['owner_id'] == $review->owner_id): ?>
                                    <div class="review-actions">
                                        <a href="<?= ROOT ?>/reviews4/edit/<?= $review->review_id ?>" class="button search-button">Edit</a>
                                        <form method="POST" action="<?= ROOT ?>/reviews4/delete/<?= $review->review_id ?>" style="display: inline;">
                                            <button type="submit" class="button clear-button" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="care_center-card">
                            <p class="no-reviews">No reviews yet for this veterinarian. Be the first to review!</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
    <script>
    function validateForm() {
        var comment = document.querySelector('textarea[name="comment"]').value;
        var rating = document.querySelector('select[name="rating"]').value;
        var vetId = document.querySelector('input[name="pharmacy_id"]').value;
        
        console.log('Form submission:', {
            comment: comment,
            rating: rating,
            pharmacyId: pharmacyId
        });
        
        if (!comment || !rating || !pharmacyId) {
            alert('Please fill in all fields');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
