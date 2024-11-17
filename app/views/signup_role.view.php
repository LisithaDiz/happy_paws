<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/signup_role.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
</head>
<body>
    <?php include ('components/nav.php'); ?>

    <div class="signup-container">
        <div class="signup-box">
            <h2>Sign Up</h2>
            <form action="signup" method="POST">
                
                <div class="role-selection">
                    <label for="user-type">Sign up as:</label>
                    <input type="hidden" id="user-type" name="user-type" required>

                    <div class="role-cards">
                        <div class="role-card" data-role="petOwner">
                            <img src="<?=ROOT?>/assets/images/prof/pet_owner_prof.jpg" alt="Pet Owner">
                            <p>Pet Owner</p>
                        </div>
                        <div class="role-card" data-role="veterinary">
                            <img src="<?=ROOT?>/assets/images/prof/vet_prof.webp" alt="Veterinary Surgeon">
                            <p>Veterinary Surgeon</p>
                        </div>
                        <div class="role-card" data-role="petSitter">
                            <img src="<?=ROOT?>/assets/images/prof/pet_sitter_prof.png" alt="Pet Sitter">
                            <p>Pet Sitter</p>
                        </div>
                        <div class="role-card" data-role="petCareCenter">
                            <img src="<?=ROOT?>/assets/images/prof/pet_care_center_prof.png" alt="Pet Care Center">
                            <p>Pet Care Center</p>
                        </div>
                        <div class="role-card" data-role="pharmacy">
                            <img src="<?=ROOT?>/assets/images/prof/pharmacy_prof.jpg" alt="Pharmacy">
                            <p>Pharmacy</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="signup-button" style="display:none;">Next</button>
            </form>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>

    <!-- <script src="script.js"></script> -->
    <script>
    // Select all role cards and the hidden input
    const roleCards = document.querySelectorAll('.role-card');
    const userTypeInput = document.getElementById('user-type');
    const signupForm = document.querySelector('form');

    // Add a click event listener for each card
    roleCards.forEach(card => {
        card.addEventListener('click', function() {
            // Get the role from the data-role attribute
            const selectedRole = this.getAttribute('data-role');
            
            // Set the hidden input value to the selected role
            userTypeInput.value = selectedRole;
            
            // Submit the form
            signupForm.submit();
        });
    });

</script>

</body>
</html>
