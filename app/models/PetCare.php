<?php

class PetCare
{
    use Model;

    protected $table = 'pet_care_center'; // Assuming this is your table name

    public function getPetCareCenters()
    {
        return $this->findAll(); // Fetch all pet care centers
    }

    public function searchPetCareCenters($name, $location)
    {
        // Adjusting the search to use the correct fields
        return $this->where(['name' => $name, 'district' => $location]);
    }
}
