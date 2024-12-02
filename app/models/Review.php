<?php

class Review {
    use Model;

    protected $table = 'sitter_reviews';
    protected $allowedColumns = [
        'owner_id',
        'sitter_id',
        'rating',
        'comment'
    ];

    public function __construct()
    {
        $this->order_column = 'review_id';
    }

    // Get all reviews for a specific sitter
    public function getSitterReviews($sitter_id)
    {
        $query = "SELECT sr.*, 
                  CONCAT(po.f_name, ' ', po.l_name) as owner_name,
                  sr.review_id,
                  sr.created_at,
                  sr.rating,
                  sr.comment,
                  sr.owner_id
                  FROM sitter_reviews sr
                  LEFT JOIN pet_owner po ON sr.owner_id = po.owner_id
                  WHERE sr.sitter_id = :sitter_id
                  ORDER BY sr.created_at DESC";
        
        error_log("Executing review query: " . $query);
        error_log("Sitter ID: " . $sitter_id);
        
        $result = $this->query_($query, ['sitter_id' => $sitter_id]);
        error_log("Review query result count: " . count($result));
        
        return $result;
    }

    // Get sitter's name
    public function getSitterName($sitter_id)
    {
        $query = "SELECT CONCAT(f_name, ' ', l_name) as name 
                  FROM pet_sitter 
                  WHERE sitter_id = :sitter_id";
        
        error_log("Executing sitter name query for ID: " . $sitter_id);
        $result = $this->query_($query, ['sitter_id' => $sitter_id]);
        
        if (!empty($result)) {
            error_log("Found sitter name: " . $result[0]->name);
            return $result[0]->name;
        }
        
        error_log("No sitter found for ID: " . $sitter_id);
        return null;
    }

    // Get a single review with owner details
    public function getReview($review_id)
    {
        $query = "SELECT * FROM sitter_reviews WHERE review_id = :review_id";
        $result = $this->query_($query, ['review_id' => $review_id]);
        
        return $result ? $result[0] : false;
    }

    // Check if user has already reviewed this sitter
    public function hasUserReviewed($owner_id, $sitter_id)
    {
        return $this->first([
            'owner_id' => $owner_id,
            'sitter_id' => $sitter_id
        ]);
    }

    public function update($review_id, $data)
    {
        error_log("Updating review ID: " . $review_id);
        error_log("Update data: " . print_r($data, true));

        $query = "UPDATE sitter_reviews SET 
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
        
        $query = "DELETE FROM sitter_reviews WHERE review_id = :review_id";
        return $this->query($query, ['review_id' => $review_id]);
    }
}