<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
<footer>
    <div class="footer-container">
        <div class="footer-about">
            <div class="footer-logo">
                <img src="<?=ROOT?>/assets/images/happy-paws-logo.png" alt="Happy Paws Logo">
                <h2>Happy Paws <i class="fas fa-heart"></i></h2>
            </div>
            <p>Where Every Pet is Loved!</p>
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-links">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Services</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Services</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-paw"></i> Veterinary Care</a></li>
                    <li><a href="#"><i class="fas fa-home"></i> Pet Care Centers</a></li>
                    <li><a href="#"><i class="fas fa-user-nurse"></i> Pet Sitters</a></li>
                    <li><a href="#"><i class="fas fa-pills"></i> Pharmacies</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul class="contact-info">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>123 Pet Street, Animal City</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>+1 234 567 890</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@happypaws.com</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <p>&copy; <?php echo date('Y'); ?> Happy Paws. All Rights Reserved.</p>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<script>
// Add hover effect to services links
const serviceLinks = document.querySelectorAll('.footer-services a');
serviceLinks.forEach(link => {
  link.addEventListener('mouseenter', (e) => {
    e.target.style.color = '#2563eb';
  });
  
  link.addEventListener('mouseleave', (e) => {
    e.target.style.color = '';
  });
});

// Add hover effect to social links
const socialLinks = document.querySelectorAll('.social-link');
socialLinks.forEach(link => {
  link.addEventListener('mouseenter', (e) => {
    const icon = e.target.querySelector('.social-icon');
    if (icon) {
      icon.style.transform = 'scale(1.1)';
    }
  });
  
  link.addEventListener('mouseleave', (e) => {
    const icon = e.target.querySelector('.social-icon');
    if (icon) {
      icon.style.transform = '';
    }
  });
});


</script>