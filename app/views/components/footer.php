<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
<footer>
 
  <div class="footer-container">
    <div class="footer-about">
      <h2>Happy Paws <span class="heart-icon">❤️</span></h2>
      <p>Where Every Pet is Loved!</p>
    </div>

    <div class="footer-contact">
      <h3>Contact Us</h3>
      <ul>
        <li>
          <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
          </svg>
          <span>+1 (800) 123-4567</span>
        </li>
        <li>
          <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
            <polyline points="22,6 12,13 2,6"></polyline>
          </svg>
          <a href="mailto:info@happypaws.com" class="hover-underline">info@happypaws.com</a>
        </li>
        <li>
          <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
            <circle cx="12" cy="10" r="3"></circle>
          </svg>
          <span>1234 Pet Street, Animal City, PA 12345</span>
        </li>
      </ul>
    </div>

    <div class="footer-services">
      <h3>Services</h3>
      <ul>
        <li><a href="#" class="hover-underline">Veterinary Care</a></li>
        <li><a href="#" class="hover-underline">Pet Sitting</a></li>
        <li><a href="#" class="hover-underline">Pharmacy</a></li>
        <li><a href="#" class="hover-underline">Pet Boarding</a></li>
      </ul>
    </div>

    <div class="footer-social">
      <h3>Follow Us</h3>
      <ul>
        <li>
          <a href="#" class="social-link">
            <svg class="social-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
            </svg>
            <span>@HappyPaws</span>
          </a>
        </li>
        <li>
          <a href="#" class="social-link">
            <svg class="social-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
              <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg>
            <span>@HappyPawsOfficial</span>
          </a>
        </li>
        <li>
          <a href="#" class="social-link">
            <svg class="social-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
            </svg>
            <span>@HappyPaws_</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="footer-legal">
    <p>
      <a href="#" class="hover-underline">Privacy Policy</a> |
      <a href="#" class="hover-underline">Terms of Service</a> |
      <a href="#" class="hover-underline">Cookie Policy</a>
    </p>
    <p>© 2024 Happy Paws. All Rights Reserved.</p>
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