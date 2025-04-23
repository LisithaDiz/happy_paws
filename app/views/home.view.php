<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <title>Happy Paws - Your All-In-One Pet Care Solution</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

    

</head>
<body>
    <?php include ('components/nav.php'); ?>
    
    <section id="hero">
        
        <div class="hero-content">
            <h1>Happy Paws<br>Simplifying Pet Care</h1>
            <p>The all-in-one platform for pet sitting, veterinary care, and medication management.</p>
            <a href="signup_role" class="signup-button">Sign Up</a>
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
                <h2>Vet Clinics</h2>
                <p>Locate the best vet clinics for your pet's health.</p>
            </div>
        </div>

        <div class="card" onclick="window.location.href='pharmacies.html'">
            <img src="<?=ROOT?>/assets/images/pharmacy_.jpg" alt="Pharmacy">
            <div class="card-content">
                <h2>Pharmacies</h2>
                <p>Find trusted pharmacies for your pet's medication needs.</p>
            </div>
        </div>
 
        <div class="card" onclick="window.location.href='pet_sitters.html'">
            <img src="<?=ROOT?>/assets/images/petsitter_.jpg" alt="Pet Sitters">
            <div class="card-content">
                <h2>Pet Sitters</h2>
                <p>Connect with reliable pet sitters for peace of mind.</p>
            </div>
        </div>
        <div class="card" onclick="window.location.href='pet_care_centers.html'">
            <img src="<?=ROOT?>/assets/images/petcare.jpg" alt="Pet Care Centers">
            <div class="card-content">
                <h2>Pet Care Centers</h2>
                <p>Ensure your pet's well-being with expert care at our trusted pet care center.</p>
            </div>
        </div>
    </section>
    <?php include ('components/footer.php'); ?>
   
    <script src="<?=ROOT?>/assets/js/script.js"></script>
   
</body>
</html>

