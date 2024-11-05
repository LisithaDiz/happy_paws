<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="assests/happy-paws-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="components/nav.css">
    <link rel="stylesheet" href="components/footer.css">

</head>
<body>
   

    <?php include ('components/nav.php'); ?>

    
    <div class="about-container">
        <h1>About Us</h1>
        <p>Welcome to Happy Paws! We are dedicated to providing exceptional care for your beloved pets. Our platform offers a variety of services to ensure your pets receive the best care possible. Learn more about what we offer below.</p>
        <div class="service-section">
            <div class="service-description">
                <h2>Pet Sitter</h2>
                <p>Our pet sitters provide reliable and loving care for your pets while you're away. They ensure your pets are well-fed, exercised, and given the attention they deserve.</p>
            </div>
            <div class="service-image">
                <img src="assests/petsitter.jpg" alt="Pet Sitter">
            </div>
        </div>

        <div class="service-section">
            <div class="service-description">
                <h2>Pet Care Center</h2>
                <p>Our pet care centers offer a safe and comfortable environment for your pets. We provide boarding, grooming, and various other services to keep your pets healthy and happy.</p>
            </div>
            <div class="service-image">
                <img src="assests/petcare.jpg" alt="Pet Care Center">
            </div>
        </div>

        <div class="service-section">
            <div class="service-description">
                <h2>Veterinarian Services</h2>
                <p>Our certified veterinarians are dedicated to providing the best medical care for your pets. We are here to keep your pets healthy.</p>
            </div>
            <div class="service-image">
                <img src="assests/vet.webp" alt="Veterinarian">
            </div>
        </div>

        <div class="service-section">
            <div class="service-description">
                <h2>Pharmacy</h2>
                <p>Our pet pharmacy offers a wide range of medications and supplements to meet your pet's health needs. We ensure that you have easy access to the medicines prescribed by our vets.</p>
            </div>
            <div class="service-image">
                <img src="assests/pharmacy.jpg" alt="Pharmacy">
            </div>
        </div>
    </div>
    <?php include ('components/footer.php'); ?>
    
</body>
</html>

