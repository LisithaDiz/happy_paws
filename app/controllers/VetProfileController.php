<?php
class VetProfileController
{

    public function profile() {
        // Assuming the model fetches the vet data, e.g., from the database
        $vetData = $this->Vet->getVetData(); // Replace with actual data fetching method

        // Pass the data to the view
        $this->view('vetprofile.view.php', ['vetData' => $vetData]);
    }
}
?>

