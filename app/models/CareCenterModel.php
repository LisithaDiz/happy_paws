<?php 

class CareCenterModel
{
	
	use Model;

	protected $table = 'pet_care_center';

	protected $allowedColumns = [
		'care_center_id',
		'user_id',
		'name',
		'district',
		'city',
		'street',
		'contact_no',
		'certificate',
		'opening_hours',
		'services_offered',
		'about_us',
		'profile_image',
		'cover_image'
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
                care_center_id,
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

    public function updateProfile($data, $id) {
        // Handle file uploads
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
            $profileImage = file_get_contents($_FILES['profile_image']['tmp_name']);
            $data['profile_image'] = $profileImage;
        }
        
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
            $coverImage = file_get_contents($_FILES['cover_image']['tmp_name']);
            $data['cover_image'] = $coverImage;
        }

        // Remove empty values and files from data array
        $data = array_filter($data, function($value) {
            return $value !== null && $value !== '';
        });

        // Use the Model trait's update method
        return $this->update($id, $data, 'care_center_id');
    }

    public function getCareCenterById($centerId)
    {
        $query = "SELECT * FROM $this->table WHERE care_center_id = :care_center_id";
        $result = $this->query($query, ['care_center_id' => $centerId]);
        return $result[0] ?? null;
    }
}
