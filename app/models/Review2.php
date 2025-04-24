<?php

require_once '../app/core/Model.php';

class Review2
{
    use Model;

    protected $table = 'vet_reviews'; // Assuming you have a table for veterinarian reviews
    protected $allowedColumns = [
        'owner_id',
        'vet_id',
        'rating',
        'comment'
    ];

    public function __construct()
    {
        $this->order_column = 'review_id';
    }

    // Get all reviews for a specific veterinarian
    public function getVetReviews($vet_id)
    {
        $query = "SELECT vr.*, 
                  CONCAT(po.f_name, ' ', po.l_name) as owner_name,
                  vr.review_id,
                  vr.created_at,
                  vr.rating,
                  vr.comment,
                  vr.owner_id
                  FROM vet_reviews vr
                  LEFT JOIN pet_owner po ON vr.owner_id = po.owner_id
                  WHERE vr.vet_id = :vet_id
                  ORDER BY vr.created_at DESC";
        
        error_log("Executing review query: " . $query);
        error_log("Veterinarian ID: " . $vet_id);
        
        $result = $this->query_($query, ['vet_id' => $vet_id]);
        error_log("Review query result count: " . count($result));
        
        return $result;
    }

    // Get veterinarian's name
    public function getVetName($vet_id)
    {
        $query = "SELECT CONCAT(f_name, ' ', l_name) as name 
                  FROM veterinary_surgeon 
                  WHERE vet_id = :vet_id";
        
        error_log("Executing veterinarian name query for ID: " . $vet_id);
        $result = $this->query_($query, ['vet_id' => $vet_id]);
        
        if (!empty($result)) {
            error_log("Found veterinarian name: " . $result[0]->name);
            return $result[0]->name;
        }
        
        error_log("No veterinarian found for ID: " . $vet_id);
        return null;
    }

    // Get a single review with owner details
    public function getReview($review_id)
    {
        $query = "SELECT * FROM vet_reviews WHERE review_id = :review_id";
        $result = $this->query_($query, ['review_id' => $review_id]);
        
        return $result ? $result[0] : false;
    }

    // Check if user has already reviewed this veterinarian
    public function hasUserReviewed($owner_id, $vet_id)
    {
        return $this->first([
            'owner_id' => $owner_id,
            'vet_id' => $vet_id
        ]);
    }

    public function update($review_id, $data)
    {
        error_log("Updating review ID: " . $review_id);
        error_log("Update data: " . print_r($data, true));

        $query = "UPDATE vet_reviews SET 
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
        
        $query = "DELETE FROM vet_reviews WHERE review_id = :review_id";
        return $this->query($query, ['review_id' => $review_id]);
    }
} 
