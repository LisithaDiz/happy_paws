<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
  <title>Happy Paws - Contact Us</title>
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/contactus.css">
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
</head>
<body>

<?php include('components/nav.php'); ?>

<main>
  <section class="contact-section">
    <h1>Contact Us</h1>

    <!-- Display Success/Error Messages -->
    <?php if (!empty($success)): ?>
    <p class="success-message"><?= htmlspecialchars($success) ?>
    <?php elseif (!empty($error)): ?>
    <p class="error-message><?= htmlspecialchars($error) ?>
    <?php endif; ?>


    <form action="<?=ROOT?>/user/contactUs" method="POST" onsubmit="return validateForm()">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
      <span class="error" id="nameError"></span>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
      <span class="error" id="emailError"></span>

      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" value="<?= isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '' ?>" required>
      <span class="error" id="subjectError"></span>

      <label for="message">Message:</label>
      <textarea id="message" name="message" required><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
      <span class="error" id="messageError"></span>

      <button type="submit">Submit</button>
    </form>

  </section>
</main>

<?php include('components/footer.php'); ?>

<!--  JavaScript Validation -->
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
