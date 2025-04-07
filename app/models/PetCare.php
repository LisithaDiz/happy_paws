<?php

require_once '../app/core/Model.php';
require_once '../app/core/Database.php';

class PetCare
{
    use Model;

    protected $table = 'pet_care_center';
    
    public function getAllCenters()
    {
        $query = "SELECT 
                    care_center_id,
                    name,
                    district,
                    city,
                    street,
                    contact_no
                    
                 FROM $this->table 
                 ORDER BY care_center_id DESC";
        
        return $this->query($query);
    }

    public function searchCenters($name = '', $location = '')
    {
        $params = [];
        $query = "SELECT 
                    care_center_id,
                    name,
                    district,
                    city,
                    street,
                    contact_no
                    
                 FROM $this->table 
                 WHERE 1=1";

        if (!empty($name)) {
            $query .= " AND (LOWER(name) LIKE :name)"; // Assuming you want to search by name
            $params['name'] = '%' . strtolower($name) . '%';
        }

        if (!empty($location)) {
            $query .= " AND (LOWER(district) LIKE :location OR LOWER(city) LIKE :location)";
            $params['location'] = '%' . strtolower($location) . '%';
        }

        $query .= " ORDER BY care_center_id DESC";
        
        return $this->query($query, $params);
    }
}