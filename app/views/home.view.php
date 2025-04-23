<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <title>Happy Paws - Your All-In-One Pet Care Solution</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include ('components/nav.php'); ?>
    
    <section id="hero">
        <div class="hero-content">
            <h1><i class="fas fa-paw"></i> Happy Paws<br>Simplifying Pet Care</h1>
            <p><i class="fas fa-heart"></i> The all-in-one platform for pet sitting, veterinary care, and medication management.</p>
            <a href="signup_role" class="signup-button"><i class="fas fa-user-plus"></i> Sign Up</a>

            <div class="hero-stats">
                <div class="stat-item">
                    <i class="fas fa-paw"></i>
                    <h3>10,000+</h3>
                    <p>Happy Pets</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-md"></i>
                    <h3>500+</h3>
                    <p>Veterinarians</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-home"></i>
                    <h3>200+</h3>
                    <p>Care Centers</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-nurse"></i>
                    <h3>1500+</h3>
                    <p>Pet Sitters</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-pills"></i>
                    <h3>100+</h3>
                    <p>Pharmacies</p>
                </div>
        </div>
    </section>
    <section id="services">
        <div class="card" onclick="window.location.href='vet_clinics.html'">
            <img src="<?=ROOT?>/assets/images/vet_.jpg" alt="Vet Clinics">
            <video class="card-video" muted>
                <source src="<?=ROOT?>/assets/videos/vet_clinics.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="card-content">
                <i class="fas fa-clinic-medical"></i>
                <h2>Vet Clinics</h2>
                <p>Locate the best vet clinics for your pet's health.</p>
            </div>
        </div>

        <div class="card" onclick="window.location.href='pharmacies.html'">
            <img src="<?=ROOT?>/assets/images/pharmacy_.jpg" alt="Pharmacy">
            <div class="card-content">
                <i class="fas fa-pills"></i>
                <h2>Pharmacies</h2>
                <p>Find trusted pharmacies for your pet's medication needs.</p>
            </div>
        </div>
 
        <div class="card" onclick="window.location.href='pet_sitters.html'">
            <img src="<?=ROOT?>/assets/images/petsitter_.jpg" alt="Pet Sitters">
            <div class="card-content">
                <i class="fas fa-user-nurse"></i>
                <h2>Pet Sitters</h2>
                <p>Connect with reliable pet sitters for peace of mind.</p>
            </div>
        </div>
        <div class="card" onclick="window.location.href='pet_care_centers.html'">
            <img src="<?=ROOT?>/assets/images/petcare.jpg" alt="Pet Care Centers">
            <div class="card-content">
                <i class="fas fa-home"></i>
                <h2>Pet Care Centers</h2>
                <p>Ensure your pet's well-being with expert care at our trusted pet care center.</p>
            </div>
        </div>
    </section>

    <section id="features">
        <div class="section-header">
            <h2>Why Choose Us</h2>
            <p>We provide the best care for your furry friends</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-clock"></i>
                <h3>24/7 Support</h3>
                <p>Round-the-clock assistance for all your pet care needs</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Verified Professionals</h3>
                <p>All our service providers are thoroughly vetted</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Easy Location</h3>
                <p>Find the nearest services with our smart location system</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Easy Booking</h3>
                <p>Simple and quick appointment scheduling</p>
            </div>
        </div>
    </section>

    <?php include ('components/footer.php'); ?>
   
    <script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>

