<?php
        
class PetOwnerController
{        

    use Controller;


    public function addBookings()
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate cage_id
            if (!isset($_POST['cage_id']) || empty($_POST['cage_id'])) {
                $_SESSION['message'] = 'Invalid cage selection. Please try again.';
                $_SESSION['message_type'] = 'error';
                redirect('/carecenterprofile');
                return;
            }

            $data = [
                'cage_id' => $_POST['cage_id'],
                'pet_id' => $_POST['pet_id'],
                'start_date' => $_POST['checkin_date'],
                'end_date' => $_POST['checkout_date'],
                'care_center_id' => $_POST['carecenter_id'],
                'owner_id' => $_SESSION['owner_id'],
                'special_req' => $_POST['specialRequests'] ?? 'None',
                'status' => 'Pending'
            ];

            $bookingModel = new CareCenterBookingModel();
            $result = $bookingModel->insertBooking($data);

            if ($result) {
                $_SESSION['message'] = 'Booking created successfully!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to create booking. Please try again.';
                $_SESSION['message_type'] = 'error';
            }

            redirect('/petownerbookings');
        }
    }

    // public function updateMedicine()
    // {
        
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = $_POST['med_id'];
    //         // show($id);
    //         $data = [
    //             'med_name' => $_POST['med_name'],
    //             'med_description' => $_POST['med_description'],
    //         ];

    //         var_dump($data);
    //         $medicineModel = new MedicineModel();
    //         $medicineModel->updateMedicine($id, $data ,$id);

    //         redirect('/adminManageMedicine');

    //     }
    // }

    // public function deleteMedicine()
    // {
    //     // echo "in admin s delete fuction";
    //     if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
    //         $id = $_POST['med_id'];

    //         $medicineModel = new MedicineModel();
    //         $medicineModel->deleteMedicine($id);

    //         redirect('adminManageMedicine');
    //     }
    // }
}


