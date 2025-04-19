<?php 

require_once '../app/core/Model.php';
require_once '../app/core/Database.php';

class PharmacyModel
{
	
	use Model;

	protected $table = 'pharmacy';

        public function getPharmacy()
        {
                $query = "SELECT
                            pharmacy_id,
                            name,
                            CONCAT(district, ', ', city) as location,
                            contact_no
                         FROM $this->table
                         ORDER BY pharmacy_id DESC";
                
                return $this->query($query);

        }

        public function searchPharmacy($name = '', $location = '')
       {
                $params = [];
                $query = "SELECT
                            pharmacy_id,
                            name,
                            CONCAT(district, ', ', city) as location,
                            contact_no
                         
                 FROM $this->table 
                 WHERE 1=1";

        if (!empty($name)) {
           $query .= " AND LOWER(name) LIKE :name";
           $params['name'] = '%' . strtolower($name) . '%';
        }
    

        if (!empty($location)) {
            $query .= " AND (LOWER(district) LIKE :location OR LOWER(city) LIKE :location)";
            $params['location'] = '%' . strtolower($location) . '%';
        }

        $query .= " ORDER BY pharmacy_id DESC";
        
        return $this->query($query, $params);
    }

	public function getAverageRating($pharmacy_id) {
        $query = "SELECT AVG(rating) as avg_rating 
                  FROM pharmacy_reviews 
                  WHERE pharmacy_id = :pharmacy_id";
        
        $result = $this->query($query, ['pharmacy_id' => $pharmacy_id]);
        
        if ($result && isset($result[0]->avg_rating)) {
            return round($result[0]->avg_rating, 1); // Round to 1 decimal place
        }
        
        return 0; // Default rating if no reviews
    }

    public function getAllPharmacies()
    {
        try {
            $query = "SELECT * FROM pharmacy WHERE status = 'active' ORDER BY pharmacy_name";
            return $this->query($query);
        } catch (Exception $e) {
            error_log("Error in getAllPharmacies: " . $e->getMessage());
            return [];
        }
    }

    public function getPharmacyById($pharmacy_id)
    {
        try {
            $query = "SELECT * FROM pharmacy WHERE pharmacy_id = :pharmacy_id LIMIT 1";
            $result = $this->query($query, [':pharmacy_id' => $pharmacy_id]);
            return $result ? $result[0] : null;
        } catch (Exception $e) {
            error_log("Error in getPharmacyById: " . $e->getMessage());
            return null;
        }
    }

	
}