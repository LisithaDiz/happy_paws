<?php

require_once '../app/core/Model.php';
require_once '../app/core/Database.php';

/**
 * Vet class
 */
class Vet
{
    use Model;

    protected $table = 'veterinary_surgeon';

    public function getAllVets()
    {
        $query = "SELECT 
                    vet_id,
                    CONCAT(f_name, ' ', l_name) as name,
                    CONCAT(district, ', ', city) as location,
                    street,
                    years_exp as experience,
                    contact_no
                 FROM $this->table 
                 ORDER BY name ASC";
        
        return $this->query($query);
    }

    public function searchVets($name = '', $location = '')
    {
        $params = [];
        $query = "SELECT 
                    vet_id,
                    CONCAT(f_name, ' ', l_name) as name,
                    CONCAT(district, ', ', city) as location,
                    street,
                    years_exp as experience,
                    contact_no
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

        $query .= " ORDER BY name ASC";
        
        return $this->query($query, $params);
    }

    public function getAverageRating($vet_id) {
        $query = "SELECT AVG(rating) as avg_rating 
                  FROM vet_reviews 
                  WHERE vet_id = :vet_id";
        
        $result = $this->query($query, ['vet_id' => $vet_id]);
        
        if ($result && isset($result[0]->avg_rating)) {
            return round($result[0]->avg_rating, 1); // Round to 1 decimal place
        }
        
        return 0; // Default rating if no reviews
    }
}
