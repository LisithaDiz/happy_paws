<?php
function renderPetCard($name, $image, $link) {
    ?>
    <div class="card">
        <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>" class="pet-profile-pic">
        <h3><?= htmlspecialchars($name) ?></h3>
        <a href="<?= htmlspecialchars($link) ?>" class="btn-dashboard">View Details</a>
    </div>
    <?php
}
?>
