<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="assests/happy-paws-logo.png">
    <title>Happy Paws - Your All-In-One Pet Care Solution</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="components/nav.css">
    <link rel="stylesheet" href="components/footer.css">

    

</head>
<body>
    <?php include ('components/nav.php'); ?>
    

    <section id="hero">
        
        <div class="hero-content">
            <h1>Happy Paws: Simplifying Pet Care</h1>
            <p>The all-in-one platform for pet sitting, veterinary care, and medication management.</p>
            <a href="signup_role.php" class="signup-button">Sign Up</a>
        </div>
    </section>
    <section id="services">

        <div class="card" onclick="window.location.href='vet_clinics.html'">
            <img src="./assests/vet_.jpg" alt="Vet Clinics">
            <div class="card-content">
                <h2>Vet Clinics</h2>
                <p>Locate the best vet clinics for your pet's health.</p>
            </div>
        </div>

        <div class="card" onclick="window.location.href='pharmacies.html'">
            <img src="./assests/pharmacy_.jpg" alt="Pharmacy">
            <div class="card-content">
                <h2>Pharmacies</h2>
                <p>Find trusted pharmacies for your pet's medication needs.</p>
            </div>
        </div>
 
        <div class="card" onclick="window.location.href='pet_sitters.html'">
            <img src="./assests/petsitter_.jpg" alt="Pet Sitters">
            <div class="card-content">
                <h2>Pet Sitters</h2>
                <p>Connect with reliable pet sitters for peace of mind.</p>
            </div>
        </div>
        <div class="card" onclick="window.location.href='pet_care_centers.html'">
            <img src="./assests/petcare.jpg" alt="Pet Care Centers">
            <div class="card-content">
                <h2>Pet Care Centers</h2>
                <p>Ensure your pet's well-being with expert care at our trusted pet care center.</p>
            </div>
        </div>
    </section>
    <?php include ('components/footer.php'); ?>
   
    <script src="script.js"></script>
</body>
</html>
