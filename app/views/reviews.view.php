<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Sitter Reviews</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <!-- <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsittersearch.css"> -->
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/reviews.css">
</head>
<body>
    <?php include 'components/nav.php'; ?>

    <div class="container">
        <div class="reviews-container">
            <?php if(isset($is_editing) && isset($review)): ?>
                <!-- Edit Review Form -->
                <h3 class="search-heading">Edit Review for <?=$sitter_name?></h3>
                <div class="edit-review-container petsitter-card">
                    <form method="POST" action="<?=ROOT?>/reviews/edit/<?=$review->id?>">
                        <div class="form-group">
                            <label>Rating:</label>
                            <select name="rating" required class="search-bar">
                                <option value="5" <?=$review->rating == 5 ? 'selected' : ''?>>5 Stars ⭐⭐⭐⭐⭐</option>
                                <option value="4" <?=$review->rating == 4 ? 'selected' : ''?>>4 Stars ⭐⭐⭐⭐</option>
                                <option value="3" <?=$review->rating == 3 ? 'selected' : ''?>>3 Stars ⭐⭐⭐</option>
                                <option value="2" <?=$review->rating == 2 ? 'selected' : ''?>>2 Stars ⭐⭐</option>
                                <option value="1" <?=$review->rating == 1 ? 'selected' : ''?>>1 Star ⭐</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Comment:</label>
                            <textarea name="comment" required class="search-bar" style="min-height: 100px;"><?=$review->comment?></textarea>
                        </div>
                        <div class="button-group">
                            <button type="submit" class="book-button">Update</button>
                            <a href="<?=ROOT?>/reviews/index/<?=$review->sitter_id?>" class="search-button">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <h2 class="search-heading">Reviews for <?=$sitter_name?></h2>
                
                <!-- Add New Review Section -->
                <?php if(!isset($_SESSION['owner_id'])): ?>
                    <p class="login-prompt">Please <a href="<?=ROOT?>/login">login</a> to leave a review</p>
                <?php elseif(!$has_reviewed): ?>
                    <div class="add-review-container petsitter-card">
                        <form method="POST" action="<?=ROOT?>/reviews/add">
                            <input type="hidden" name="sitter_id" value="<?=$sitter_id?>">
                            <div class="form-group">
                                <label>Rating:</label>
                                <select name="rating" required class="search-bar">
                                    <option value="5">5 Stars ⭐⭐⭐⭐⭐</option>
                                    <option value="4">4 Stars ⭐⭐⭐⭐</option>
                                    <option value="3">3 Stars ⭐⭐⭐</option>
                                    <option value="2">2 Stars ⭐⭐</option>
                                    <option value="1">1 Star ⭐</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Comment:</label>
                                <textarea name="comment" required class="search-bar" style="min-height: 100px;" placeholder="Write your review here..."></textarea>
                            </div>
                            <button type="submit" class="book-button">Submit Review</button>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Reviews List -->
                <div class="results-container">
                    <?php if(!empty($reviews)): ?>
                        <?php foreach($reviews as $review): ?>
                            <div class="petsitter-card">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <h3 class="reviewer-name"><?=$review->owner_name?></h3>
                                        <div class="rating-date">
                                            <span class="rating">
                                                <?php 
                                                    for($i = 0; $i < $review->rating; $i++) {
                                                        echo "⭐";
                                                    }
                                                ?>
                                            </span>
                                            <span class="date"><?=date('M d, Y', strtotime($review->created_at))?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="comment">
                                    <?=htmlspecialchars($review->comment)?>
                                </div>
                                
                                <?php if(isset($_SESSION['owner_id']) && $_SESSION['owner_id'] == $review->owner_id): ?>
                                    <div class="review-actions">
                                        <a href="<?=ROOT?>/reviews/edit/<?=$review->id?>" class="search-button">Edit</a>
                                        <a href="<?=ROOT?>/reviews/delete/<?=$review->id?>" 
                                           class="clear-button" 
                                           onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="petsitter-card">
                            <p class="no-reviews">No reviews yet for this pet sitter. Be the first to review!</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
</body>
</html>