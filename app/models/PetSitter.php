<?php

require_once '../app/core/Model.php';
require_once '../app/core/Database.php';

class PetSitter
{
    use Model;

    protected $table = 'pet_sitter';
    
    public function getAllSitters()
    {
        $query = "SELECT 
                    sitter_id,
                    CONCAT(f_name, ' ', l_name) as name,
                    CONCAT(district, ', ', city) as location,
                    years_exp as experience,
                    contact_no,
                    gender,
                    age
                 FROM $this->table 
                 ORDER BY sitter_id DESC";
        
        return $this->query($query);
    }

    public function searchSitters($name = '', $location = '')
    {
        $params = [];
        $query = "SELECT 
                    sitter_id,
                    CONCAT(f_name, ' ', l_name) as name,
                    CONCAT(district, ', ', city) as location,
                    years_exp as experience,
                    contact_no,
                    gender,
                    age
                 FROM $this->table 
                 WHERE 1=1";

        if (!empty($name)) {
            $query .= " AND (LOWER(f_name) LIKE :name OR LOWER(l_name) LIKE :name)";
            $params['name'] = '%' . strtolower($name) . '%';
        }

        if (!empty($location)) {
            $query .= " AND (LOWER(district) LIKE :location OR LOWER(city) LIKE :location)";
            $params['location'] = '%' . strtolower($location) . '%';
        }

        $query .= " ORDER BY sitter_id DESC";
        
        return $this->query($query, $params);
    }
}