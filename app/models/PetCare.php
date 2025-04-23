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
    
    public function getReviews($care_center_id)
    {
        $query = "SELECT 
                    r.*, 
                    CONCAT(po.f_name, ' ', po.l_name) as owner_name
                 FROM pet_care_reviews r
                 LEFT JOIN pet_owner po ON r.owner_id = po.owner_id
                 WHERE r.care_center_id = :care_center_id
                 ORDER BY r.created_at DESC";
        
        return $this->query($query, ['care_center_id' => $care_center_id]);
    }
    
    public function getAverageRating($care_center_id)
    {
        $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count
                 FROM pet_care_reviews
                 WHERE care_center_id = :care_center_id";
        
        $result = $this->query($query, ['care_center_id' => $care_center_id]);
        
        if (!empty($result) && isset($result[0]->avg_rating)) {
            return round($result[0]->avg_rating, 1);
        }
        
        return 0;
    }
    
    public function getReviewCount($care_center_id)
    {
        $query = "SELECT COUNT(*) as count
                 FROM pet_care_reviews
                 WHERE care_center_id = :care_center_id";
        
        $result = $this->query($query, ['care_center_id' => $care_center_id]);
        
        if (!empty($result) && isset($result[0]->count)) {
            return $result[0]->count;
        }
        
        return 0;
    }
}