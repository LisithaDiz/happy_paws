<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
  <title>Happy Paws - Contact Us</title>
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/contactus.css">
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include('components/nav.php'); ?>

<main>
  <section class="contact-section">
    <div class="contact-container">
      <div class="contact-info1">
        <div class="form-header">
          <h2>Contact Information</h2>
          <p>Reach out to us through any of these channels</p>
        </div>
        
        <div class="contact-list">
          <div class="contact-item">
            <div class="item-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="item-content">
              <h3>Our Location</h3>
              <p>123 Pet Street, Colombo, Sri Lanka</p>
            </div>
          </div>
          
          <div class="contact-item">
            <div class="item-icon">
              <i class="fas fa-phone-alt"></i>
            </div>
            <div class="item-content">
              <h3>Phone Number</h3>
              <p>+94 123 456 789</p>
            </div>
          </div>
          
          <div class="contact-item">
            <div class="item-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="item-content">
              <h3>Email Address</h3>
              <p>info@happypaws.com</p>
            </div>
          </div>
          
        </div>
      </div>

      <div class="contact-form-container">
        <div class="form-header">
          <h2>Contact Us</h2>
          <p>If you have any complaints or feedback, please don’t hesitate to let us know!<br></p>.
        </div>

        <!-- Display Success/Error Messages -->
        <?php if (!empty($success)): ?>
          <div class="success-message">
            <div class="message-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="message-content">
              <h4>Success!</h4>
              <p><?= htmlspecialchars($success) ?></p>
            </div>
          </div>
        <?php elseif (!empty($error)): ?>
          <div class="error-message">
            <div class="message-icon">
              <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="message-content">
              <h4>Error</h4>
              <p><?= htmlspecialchars($error) ?></p>
            </div>
          </div>
        <?php endif; ?>

        <form action="<?=ROOT?>/user/contactUs" method="POST" onsubmit="return validateForm()" class="contact-form">
          <div class="form-row">
            <div class="form-group">
              <div class="input-icon">
                <i class="fas fa-user"></i>
              </div>
              <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" placeholder="Your Name" required>
              <span class="error" id="nameError"></span>
            </div>

            <div class="form-group">
              <div class="input-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" placeholder="Email Address" required>
              <span class="error" id="emailError"></span>
            </div>
          </div>

          <div class="form-group">
            <div class="input-icon">
              <i class="fas fa-tag"></i>
            </div>
            <input type="text" id="subject" name="subject" value="<?= isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '' ?>" placeholder="Subject" required>
            <span class="error" id="subjectError"></span>
          </div>

          <div class="form-group">
            <div class="input-icon">
              <i class="fas fa-comment"></i>
            </div>
            <textarea id="message" name="message" placeholder="Your Message" required><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
            <span class="error" id="messageError"></span>
          </div>

          <button type="submit" class="submit-btn">
            <span class="btn-text">Send Message</span>
            <span class="btn-icon">
              <i class="fas fa-paper-plane"></i>
            </span>
          </button>
        </form>
      </div>
    </div>
  </section>
</main>

<?php include('components/footer.php'); ?>

<!-- JavaScript Validation -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("name").addEventListener("input", validateName);
  document.getElementById("email").addEventListener("input", validateEmail);
  document.getElementById("subject").addEventListener("input", validateSubject);
  document.getElementById("message").addEventListener("input", validateMessage);
});

function validateName() {
  let name = document.getElementById("name").value;
  let nameError = document.getElementById("nameError");

  if (!/^[a-zA-Z\s]+$/.test(name)) {
    nameError.textContent = "Name should contain only letters and spaces.";
    return false;
  } else {
    nameError.textContent = "";
    return true;
  }
}

function validateEmail() {
  let email = document.getElementById("email").value;
  let emailError = document.getElementById("emailError");

  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    emailError.textContent = "Enter a valid email address.";
    return false;
  } else {
    emailError.textContent = "";
    return true;
  }
}

function validateSubject() {
  let subject = document.getElementById("subject").value;
  let subjectError = document.getElementById("subjectError");

  if (subject.trim() === "") {
    subjectError.textContent = "Subject cannot be empty.";
    return false;
  } else {
    subjectError.textContent = "";
    return true;
  }
}

function validateMessage() {
  let message = document.getElementById("message").value;
  let messageError = document.getElementById("messageError");

  if (message.trim().length < 10) {
    messageError.textContent = "Message must be at least 10 characters.";
    return false;
  } else {
    messageError.textContent = "";
    return true;
  }
}

function validateForm() {
  let isValid = validateName() & validateEmail() & validateSubject() & validateMessage();
  return isValid;
}
</script>

</body>
</html>
