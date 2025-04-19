<?php
        

class CareCenter
{        

    use Controller;

    public function allBookings()
    {
        // Fetch all bookings for display
        $medicineModel = new MedicineModel();
        $medicines = $medicineModel->getAllMedicines();

        // Pass data to the view
        include '../app/views/manageMedicine.php';
    }

    // public function addBooking()
    // {   
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $data = [
    //             'med_name' => $_POST['med_name'],
    //             'med_description' => $_POST['med_description'],
    //         ];
    //         print_r($data);

    //         $medicineModel = new MedicineModel();
    //         $medicineModel->insertMedicine($data);

    //         redirect('/adminManageMedicine');
    //     }
    // }

    // public function updateBooking()
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

    // public function deleteBooking()
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


