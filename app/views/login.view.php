<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Happy Paws</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/login.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include ('components/nav.php'); ?>

    <div class="login-container">
        <div class="login-box">
            <h2><i class="fas fa-paw"></i> Welcome Back!</h2>

            <!-- Display error message if present -->
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="<?=ROOT?>/user/login" method="POST" onsubmit="return validateForm()">
                <div class="input-group">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                    <i class="fas fa-user input-icon"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fas fa-lock input-icon"></i>
                </div>
                <div class="input-group">
                    <select id="user_role" name="user_role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="petOwner">Pet Owner</option>
                        <option value="veterinary">Veterinary Surgeon</option>
                        <option value="petSitter">Pet Sitter</option>
                        <option value="petCareCenter">Pet Care Center</option>
                        <option value="pharmacy">Pharmacy</option>
                    </select>
                    <i class="fas fa-user-tag input-icon"></i>
                </div>
                
                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <div class="register-link">
                    <p>Don't have an account? <a href="signup_role">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>

    <script>
        function validateForm() {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const userRole = document.getElementById('user_role').value;

            if (username === "") {
                showError("Please enter your username");
                return false;
            }

            if (password === "") {
                showError("Please enter your password");
                return false;
            }

            if (userRole === "") {
                showError("Please select a login role");
                return false;
            }

            return true;
        }

        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
            
            const form = document.querySelector('form');
            const existingError = form.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
            
            form.insertBefore(errorDiv, form.firstChild);
            
            setTimeout(() => {
                errorDiv.style.opacity = '0';
                setTimeout(() => errorDiv.remove(), 500);
            }, 3000);
        }

        // Add focus effects to input fields
        document.querySelectorAll('.input-group input, .input-group select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Add password visibility toggle
        const passwordInput = document.querySelector('input[type="password"]');
        const passwordIcon = passwordInput.nextElementSibling;
        
        passwordIcon.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('fa-lock');
                this.classList.add('fa-lock-open');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('fa-lock-open');
                this.classList.add('fa-lock');
            }
        });
    </script>
</body>
</html>
