<?php

require_once '../app/core/Model.php';

class Review4
{
    use Model;

    protected $table = 'pet_care_reviews'; 
    protected $allowedColumns = [
        'owner_id',
        'care_center_id',
        'rating',
        'comment'
    ];

    public function __construct()
    {
        $this->order_column = 'review_id';
    }

    // Get all reviews for a specific veterinarian
    public function getCareReviews($care_center_id)
    {
        $query = "SELECT pr.*, 
                  CONCAT(po.f_name, ' ', po.l_name) as owner_name,
                  pr.review_id,
                  pr.created_at,
                  pr.rating,
                  pr.comment,
                  pr.owner_id
                  FROM pet_care_reviews pr
                  LEFT JOIN pet_owner po ON pr.owner_id = po.owner_id
                  WHERE pr.care_center_id = :care_center_id
                  ORDER BY pr.created_at DESC";
        
        error_log("Executing review query: " . $query);
        error_log("Care_center ID: " . $care_center_id);
        
        $result = $this->query_($query, ['care_center_id' => $care_center_id]);
        error_log("Review query result count: " . count($result));
        
        return $result;
    }

    // Get veterinarian's name
    public function getCareName($care_center_id)
    {
        $query = "SELECT name 
                  FROM pet_care_center 
                  WHERE care_center_id = :care_center_id";
        
        error_log("Executing pharmacy name query for ID: " . $care_center_id);
        $result = $this->query_($query, ['care_center_id' => $care_center_id]);
        
        if (!empty($result)) {
            error_log("Found care_center name: " . $result[0]->name);
            return $result[0]->name;
        }
        
        error_log("No care_center found for ID: " . $care_center_id);
        return null;
    }

    // Get a single review with owner details
    public function getReview($review_id)
    {
        $query = "SELECT * FROM pet_care_reviews WHERE review_id = :review_id";
        $result = $this->query_($query, ['review_id' => $review_id]);
        
        return $result ? $result[0] : false;
    }

    // Check if user has already reviewed this veterinarian
    public function hasUserReviewed($owner_id, $care_center_id)
    {
        return $this->first([
            'owner_id' => $owner_id,
            'care_center_id' => $care_center_id
        ]);
    }

    public function update($review_id, $data)
    {
        error_log("Updating review ID: " . $review_id);
        error_log("Update data: " . print_r($data, true));

        $query = "UPDATE pet_care_reviews SET 
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
        
        $query = "DELETE FROM pet_care_reviews WHERE review_id = :review_id";
        return $this->query($query, ['review_id' => $review_id]);
    }
} 