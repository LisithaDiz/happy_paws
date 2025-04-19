<?php
        
class PetOwnerController
{        

    use Controller;


    public function addBookings()
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cage_id' => $_POST['cage_id'],
                'pet_id' => $_POST['pet_id'],
                'start_date' => $_POST['checkin_date'],
                'end_date' => $_POST['checkout_date'],
                'care_center_id' => $_POST['carecenter_id'],
                'owner_id' => $_SESSION['owner_id'],
                'special_req' => $_POST['specialRequests'],

            ];
            print_r($data);

            $bookingModel = new CareCenterBookingModel();
            $bookingModel->insertBooking($data);

            // redirect('/CareCenterProfile');
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


