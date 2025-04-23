document.addEventListener('DOMContentLoaded', function() {
    // Hamburger menu
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    
    hamburger?.addEventListener('click', function() {
        navMenu.classList.toggle('active');
    });

    // User dropdown
    const userDropdownBtn = document.getElementById('userDropdownBtn');
    const userDropdown = document.getElementById('userDropdown');
    
    // Toggle dropdown on click
    userDropdownBtn?.addEventListener('click', function(e) {
        e.stopPropagation();
        userDropdown.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!userDropdownBtn?.contains(e.target)) {
            userDropdown?.classList.remove('show');
        }
    });

    // Close dropdown when clicking a link inside it
    userDropdown?.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            userDropdown.classList.remove('show');
        }
    });

    // Handle mobile menu
    if (window.innerWidth <= 768) {
        const userProfile = document.querySelector('.user-profile');
        userProfile?.addEventListener('click', function(e) {
            if (e.target.closest('.user-icon')) {
                e.preventDefault();
                this.classList.toggle('active');
                userDropdown.style.display = this.classList.contains('active') ? 'block' : 'none';
            }
        });
    }
}); 