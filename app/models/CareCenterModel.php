<?php 

class CareCenterModel
{
	
	use Model;

	protected $table = 'pet_care_center';

	protected $allowedColumns = [

	        'user_id',
            'name',
            'district',
            'city',
            'street',
            'contact_no',
            'certificate'
	];

    public function getAllInfo() {
            $order_column = 'care_center_id';
            
            $query = "SELECT 
                    cc.care_center_id,
                    cc.user_id,
                    cc.name,
                    cc.certificate,
                    cc.district,
                    cc.city,
                    cc.street,
                    cc.contact_no,
                    cc.opening_hours,
                    cc.services_offered,
                    cc.about_us,
                    u.username,
                    u.email,
                    u.created_at,
                    u.active_status
                FROM 
                    $this->table AS cc
                JOIN 
                    user AS u 
                ON 
                    cc.user_id = u.user_id
                ORDER BY 
                    $order_column $this->order_type";
    
            return $this->query($query);
    }
	
        

    public function getCareCenterInfo($center_id) {
        $query = "SELECT 
                cc.care_center_id,
                cc.user_id AS care_center_user_id,
                cc.name,
                cc.district,
                cc.city,
                cc.street,
                cc.contact_no,
                cc.opening_hours,
                cc.services_offered,
                cc.about_us,
                cc.profile_image,
                cc.cover_image,
                u.email
            FROM 
                $this->table AS cc
            JOIN 
                user AS u 
            ON 
                cc.user_id = u.user_id
            WHERE 
                cc.care_center_id = :center_id";

        $params = ['center_id' => $center_id];
        return $this->query($query, $params);
    }
    public function getSearchInfo() {
        $query = "SELECT  
                name,
                district,
                city,
                contact_no,
                services_offered,
                profile_image
     
            FROM 
                $this->table";
        var_dump($query);

        return $this->query($query);
    }
}
