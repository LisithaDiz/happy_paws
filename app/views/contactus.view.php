<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
  <title>Happy Paws - Contact Us</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/contactus.css">
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
</head>
<body>
  
 <?php include ('components/nav.php'); ?>
  <main>
  
    <section class="contact-section">
      <h1>Contact Us</h1>
    
      <form class="contact-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Submit</button>
      </form>
   
    </section>

  </main>

  <?php include ('components/footer.php'); ?>

  <script src="script.js"></script>
</body>
</html>