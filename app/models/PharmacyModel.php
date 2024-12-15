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

	

	
}