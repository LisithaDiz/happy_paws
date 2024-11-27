<?php

class PharmSearch
{
    use Controller;

    public function index()
    {
        // Initialize with default pharmacies
        $pharmacies = [
            [
                'name' => 'HealthCare Pharmacy',
                'location' => 'Colombo',
                'rating' => 4.5,
                'image' => 'default-pharmacy.jpg',
                'description' => 'A trusted pharmacy providing quality medicines and healthcare products.',
                'experience' => '10 years',
                'opening_hours' => '8:00 AM - 10:00 PM',
                'contact' => '+94 77 123 4567',
                'services' => 'Prescription Medicines, OTC Drugs, Healthcare Products, Home Delivery'
            ],
            [
                'name' => 'MediCare Plus',
                'location' => 'Kandy',
                'rating' => 4.8,
                'image' => 'default-pharmacy.jpg',
                'description' => 'Your neighborhood pharmacy with 24/7 service.',
                'experience' => '15 years',
                'opening_hours' => '24/7',
                'contact' => '+94 77 234 5678',
                'services' => 'Emergency Services, Pet Medicines, Medical Supplies, Consultation'
            ],
            [
                'name' => 'Union Pharmacy',
                'location' => 'Galle',
                'rating' => 4.3,
                'image' => 'default-pharmacy.jpg',
                'description' => 'Specialized in pet medications and veterinary supplies.',
                'experience' => '8 years',
                'opening_hours' => '9:00 AM - 9:00 PM',
                'contact' => '+94 77 345 6789',
                'services' => 'Pet Medications, Veterinary Supplies, Health Consultations'
            ],
            [
                'name' => 'PetMed Pharmacy',
                'location' => 'Negombo',
                'rating' => 4.6,
                'image' => 'default-pharmacy.jpg',
                'description' => 'Dedicated to providing quality pet healthcare products.',
                'experience' => '12 years',
                'opening_hours' => '8:30 AM - 8:30 PM',
                'contact' => '+94 77 456 7890',
                'services' => 'Pet Medicines, Grooming Products, Pet Supplements'
            ],
            [
                'name' => 'City Pharmacy',
                'location' => 'Matara',
                'rating' => 4.4,
                'image' => 'default-pharmacy.jpg',
                'description' => 'Complete pet healthcare solution provider.',
                'experience' => '7 years',
                'opening_hours' => '8:00 AM - 10:00 PM',
                'contact' => '+94 77 567 8901',
                'services' => 'Pet Medicines, Healthcare Products, Emergency Services'
            ]
        ];

        // Handle search functionality
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['search'])) {
                $name = strtolower(trim($_POST['name'] ?? ''));
                $location = strtolower(trim($_POST['location'] ?? ''));

                // Filter results based on search criteria
                $pharmacies = array_filter($pharmacies, function($pharmacy) use ($name, $location) {
                    $nameMatch = empty($name) || str_contains(strtolower($pharmacy['name']), $name);
                    $locationMatch = empty($location) || str_contains(strtolower($pharmacy['location']), $location);
                    return $nameMatch && $locationMatch;
                });
            }
        }

        // Load the view with data
        $this->view('pharmsearch', [
            'pharmacies' => $pharmacies
        ]);
    }
}