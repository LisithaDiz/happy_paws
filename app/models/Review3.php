<?php

require_once '../app/core/Model.php';

class Review3
{
    use Model;

    protected $table = 'pharmacy_reviews'; 
    protected $allowedColumns = [
        'owner_id',
        'pharmacy_id',
        'rating',
        'comment'
    ];

    public function __construct()
    {
        $this->order_column = 'review_id';
    }

    // Get all reviews for a specific veterinarian
    public function getPharmacyReviews($pharmacy_id)
    {
        $query = "SELECT pr.*, 
                  CONCAT(po.f_name, ' ', po.l_name) as owner_name,
                  pr.review_id,
                  pr.created_at,
                  pr.rating,
                  pr.comment,
                  pr.owner_id
                  FROM pharmacy_reviews pr
                  LEFT JOIN pet_owner po ON pr.owner_id = po.owner_id
                  WHERE pr.pharmacy_id = :pharmacy_id
                  ORDER BY pr.created_at DESC";
        
        error_log("Executing review query: " . $query);
        error_log("Pharmacy ID: " . $pharmacy_id);
        
        $result = $this->query_($query, ['pharmacy_id' => $pharmacy_id]);
        error_log("Review query result count: " . count($result));
        
        return $result;
    }

    // Get veterinarian's name
    public function getPharmacyName($pharmacy_id)
    {
        $query = "SELECT name 
                  FROM pharmacy 
                  WHERE pharmacy_id = :pharmacy_id";
        
        error_log("Executing pharmacy name query for ID: " . $pharmacy_id);
        $result = $this->query_($query, ['pharmacy_id' => $pharmacy_id]);
        
        if (!empty($result)) {
            error_log("Found Pharmacy name: " . $result[0]->name);
            return $result[0]->name;
        }
        
        error_log("No Pharmacy found for ID: " . $pharmacy_id);
        return null;
    }

    // Get a single review with owner details
    public function getReview($review_id)
    {
        $query = "SELECT * FROM pharmacy_reviews WHERE review_id = :review_id";
        $result = $this->query_($query, ['review_id' => $review_id]);
        
        return $result ? $result[0] : false;
    }

    // Check if user has already reviewed this veterinarian
    public function hasUserReviewed($owner_id, $pharmacy_id)
    {
        return $this->first([
            'owner_id' => $owner_id,
            'pharmacy_id' => $pharmacy_id
        ]);
    }

    public function update($review_id, $data)
    {
        error_log("Updating review ID: " . $review_id);
        error_log("Update data: " . print_r($data, true));

        $query = "UPDATE pharmacy_reviews SET 
                  rating = :rating,
                  comment = :comment 
                  WHERE review_id = :review_id";

        $params = [
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'review_id' => $review_id
        ];

        return $this->query($query, $params);
    }

    public function delete($review_id)
    {
        error_log("Deleting review ID: " . $review_id);
        
        $query = "DELETE FROM pharmacy_reviews WHERE review_id = :review_id";
        return $this->query($query, ['review_id' => $review_id]);
    }
} 