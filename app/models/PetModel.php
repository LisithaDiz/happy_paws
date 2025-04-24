<?php

class PetModel
{
    use Model;

    protected $table = 'pets';

    protected $allowedColumns = [
        'pet_id',
        'pet_owner_id',
        'pet_name',
        'pet_type',
        'breed',
        'age',
        'color',
        'weight',
        'date_of_birth',
        'vaccinations',
        'profile_image'
    ];

    public function getPetById($petId)
    {
        $query = "SELECT * FROM $this->table WHERE pet_id = :pet_id";
        $result = $this->query($query, ['pet_id' => $petId]);
        return $result[0] ?? null;
    }
} 