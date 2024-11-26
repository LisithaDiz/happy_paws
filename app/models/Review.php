<?php
require_once '../app/core/Model.php';
require_once '../app/core/Database.php';

class Review
{
    use Model;

    protected $table = 'sitter_reviews';
    protected $allowedColumns = [
        'owner_id',
        'sitter_id',
        'rating',
        'comment'
    ];

    // Get all reviews for a specific sitter
    public function getSitterReviews($sitter_id)
    {
        $query = "SELECT r.*, 
                 CONCAT(po.f_name, ' ', po.l_name) as owner_name,
                 r.id,  -- Make sure to include the review ID
                 r.created_at,
                 r.rating,
                 r.comment,
                 r.owner_id
                 FROM $this->table r 
                 JOIN pet_owner po ON r.owner_id = po.owner_id 
                 WHERE r.sitter_id = :sitter_id 
                 ORDER BY r.created_at DESC";
        
        return $this->query($query, ['sitter_id' => $sitter_id]);
    }

    // Get sitter's name
    public function getSitterName($sitter_id)
    {
        $query = "SELECT CONCAT(f_name, ' ', l_name) as sitter_name 
                 FROM pet_sitter 
                 WHERE sitter_id = :sitter_id";
        
        $result = $this->query($query, ['sitter_id' => $sitter_id]);
        return $result ? $result[0]->sitter_name : 'Pet Sitter';
    }

    // Get a single review with owner details
    public function getReview($id)
    {
        $query = "SELECT r.*, 
                 CONCAT(po.f_name, ' ', po.l_name) as owner_name 
                 FROM $this->table r 
                 JOIN pet_owner po ON r.owner_id = po.owner_id 
                 WHERE r.id = :id";
        
        $result = $this->query($query, ['id' => $id]);
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

    public function update($id, $data)
    {
        $params = [];
        $setClause = [];
        
        foreach($data as $key => $value) {
            if(in_array($key, $this->allowedColumns)) {
                $setClause[] = "$key = :$key";
                $params[$key] = $value;
            }
        }
        
        $params['id'] = $id;
        
        $query = "UPDATE $this->table SET " . implode(', ', $setClause) . " WHERE id = :id";
        
        return $this->query($query, $params);
    }
}