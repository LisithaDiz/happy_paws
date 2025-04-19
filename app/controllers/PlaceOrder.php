<?php

class PlaceOrder
{
    use Controller, Database; // Ensure Database is included

    public function index($pharmacy_id = null)
    {
        // Check if user is logged in
        if (!isset($_SESSION['owner_id'])) {
            header("Location: " . ROOT . "/login");
            exit();
        }

        // Get required data for the form
        $data = [];

        // Get pharmacy if ID is provided
        if ($pharmacy_id) {
            $pharmacy = new PharmacyModel();
            $selectedPharmacy = $pharmacy->getPharmacyById($pharmacy_id);
            
            // Debug log
            error_log("Selected Pharmacy Data: " . print_r($selectedPharmacy, true));
            
            if (!$selectedPharmacy) {
                $_SESSION['error'] = "Pharmacy not found";
                header("Location: " . ROOT . "/pharmsearch");
                exit();
            }
            $data['selectedPharmacy'] = $selectedPharmacy;

            // Fetch all medicines
            $query = "SELECT * FROM medicine"; // Fetch all medicines
            $data['medicines'] = $this->query($query);
        } else {
            // Redirect if no pharmacy ID is provided
            header("Location: " . ROOT . "/pharmsearch");
            exit();
        }

        // Get pets for the current owner
        $pet = new Pet();
        $data['pets'] = $pet->getPetsByOwner($_SESSION['owner_id']);

        // Get prescriptions for the selected pet if provided
        if (!empty($_GET['pet_id'])) {
            $prescription = new PrescriptionModel();
            $data['prescriptions'] = $prescription->getPetPrescriptions($_GET['pet_id']);
            
            // If this is an AJAX request for prescriptions, return JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['prescriptions' => $data['prescriptions']]);
                exit();
            }
        }

        // Debug: Log all data being passed to the view
        error_log("Data being passed to view: " . print_r($data, true));

        // Add error message if no pets found
        if (empty($data['pets'])) {
            $_SESSION['error'] = "No pets found. Please add a pet first.";
        }

        $this->view('petownerplaceorder', $data);
    }

    public function viewPrescription($prescription_id)
    {
        if (!isset($_SESSION['owner_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Please log in to view prescription']);
            exit();
        }

        $prescription = new PrescriptionModel();
        $prescriptionDetails = $prescription->getPrescriptionDetails($prescription_id);

        if (!$prescriptionDetails) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Prescription not found']);
            exit();
        }

        // Check if the prescription belongs to the logged-in user
        if ($prescriptionDetails->owner_id != $_SESSION['owner_id']) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'You do not have permission to view this prescription']);
            exit();
        }

        $data = [
            'prescription' => $prescriptionDetails,
            'medicines' => $prescription->getPrescriptionMedicines($prescription_id)
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function create($pharmacy_id = null)
    {
        header('Content-Type: application/json');
        error_log("PlaceOrder::create called with pharmacy_id: " . $pharmacy_id);
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST data received: " . print_r($_POST, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => "Invalid request method"]);
            exit();
        }

        try {
            // Check if user is logged in
            if (!isset($_SESSION['owner_id'])) {
                throw new Exception("Please log in to place an order");
            }

            // Validate pharmacy_id
            if (!$pharmacy_id) {
                throw new Exception("Pharmacy ID is required");
            }

            // Validate required fields
            if (empty($_POST['pet_id'])) {
                throw new Exception("Please select a pet");
            }

            if (empty($_POST['medicines']) || empty($_POST['quantities'])) {
                throw new Exception("Please select medicines and quantities");
            }

            // Prepare order data
            $orderData = [
                'owner_id' => $_SESSION['owner_id'],
                'pharmacy_id' => $pharmacy_id,
                'pet_id' => $_POST['pet_id'],
                'total_price' => $_POST['total_price'],
                'notes' => $_POST['notes'] ?? null,
                'prescription_id' => $_POST['prescription_id'] ?? null,
                'medicines' => []
            ];

            // Debug log the prepared order data
            error_log("Prepared order data: " . print_r($orderData, true));

            // Prepare medicines data
            foreach ($_POST['medicines'] as $index => $med_id) {
                if (!empty($med_id) && isset($_POST['quantities'][$index]) && $_POST['quantities'][$index] > 0) {
                    $orderData['medicines'][] = [
                        'med_id' => $med_id,
                        'quantity' => $_POST['quantities'][$index]
                    ];
                }
            }

            if (empty($orderData['medicines'])) {
                throw new Exception("At least one medicine with quantity is required");
            }

            // Create order
            $order = new Order();
            $result = $order->createOrder($orderData);

            // Debug log the result
            error_log("Order creation result: " . print_r($result, true));

            if ($result['success']) {
                echo json_encode([
                    'success' => true,
                    'message' => "Thank you for your order! The pharmacy will process it shortly.",
                    'order_id' => $result['order_id']
                ]);
            } else {
                throw new Exception($result['message'] ?? "Failed to create order");
            }

        } catch (Exception $e) {
            error_log("Error in PlaceOrder::create: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit();
    }

    public function getPrescriptions()
    {
        if (!Auth::logged_in()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Please log in to view prescriptions']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            try {
                if (!isset($_GET['pet_id'])) {
                    throw new Exception("Pet ID is required");
                }

                $pet_id = $_GET['pet_id'];
                $prescription = new PrescriptionModel();
                $prescriptions = $prescription->getPetPrescriptions($pet_id);
                
                if ($prescriptions === false) {
                    throw new Exception("Failed to fetch prescriptions");
                }
                
                header('Content-Type: application/json');
                echo json_encode(['prescriptions' => $prescriptions]);
                exit;
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
        
        // If not an AJAX request, redirect
        $this->redirect('petowner/placeorder');
    }
}