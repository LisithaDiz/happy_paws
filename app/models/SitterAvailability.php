<?php

require_once '../app/core/Model.php';
require_once '../app/core/Database.php';

class SitterAvailability
{
    use Model;

    protected $table = 'sitter_availability';
    protected $allowedColumns = [
        'avl_id',
        'sitter_id',
        'day',
        'number_of_slots',
        'price_per_slot'
    ];
    
    public function getSitterAvailability($sitter_id)
    {
        $query = "SELECT day, number_of_slots, price_per_slot
                  FROM $this->table 
                  WHERE sitter_id = :sitter_id
                  ORDER BY day ASC";
                 
        return $this->query($query, ['sitter_id' => $sitter_id]);
    }
}