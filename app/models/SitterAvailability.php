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
    
    // Initialize the model and set specific properties
    public function __construct()
    {
        // Override the default order column from the Model trait
        $this->order_column = "day";
    }
    
    /**
     * Get all availability records for a specific sitter
     * 
     * @param int $sitter_id The ID of the pet sitter
     * @return array Array of availability records
     */
    public function getSitterAvailability($sitter_id)
    {
        $query = "SELECT day, number_of_slots, price_per_slot
                  FROM $this->table 
                  WHERE sitter_id = :sitter_id
                  ORDER BY day ASC";
                 
        return $this->query($query, ['sitter_id' => $sitter_id]);
    }
    
    /**
     * Check if a sitter has availability on a specific date
     * 
     * @param int $sitter_id The ID of the pet sitter
     * @param string $date The date to check in YYYY-MM-DD format
     * @return object|bool The availability record or false if none exists
     */
    public function checkDateAvailability($sitter_id, $date)
    {
        return $this->first([
            'sitter_id' => $sitter_id,
            'day' => $date
        ]);
    }
    
    /**
     * Get all available dates for a sitter within a date range
     * 
     * @param int $sitter_id The ID of the pet sitter
     * @param string $start_date Start date in YYYY-MM-DD format
     * @param string $end_date End date in YYYY-MM-DD format
     * @return array Array of availability records
     */
    public function getAvailabilityInRange($sitter_id, $start_date, $end_date)
    {
        $query = "SELECT * FROM $this->table 
                  WHERE sitter_id = :sitter_id 
                  AND day BETWEEN :start_date AND :end_date
                  ORDER BY day ASC";
                  
        return $this->query($query, [
            'sitter_id' => $sitter_id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }
    
    /**
     * Delete availability for a specific date
     * 
     * @param int $sitter_id The ID of the pet sitter
     * @param string $date The date to delete in YYYY-MM-DD format
     * @return bool True if deleted successfully, false otherwise
     */
    public function deleteAvailability($sitter_id, $date)
    {
        $record = $this->first([
            'sitter_id' => $sitter_id,
            'day' => $date
        ]);
        
        if ($record) {
            return $this->delete($record->avl_id, 'avl_id');
        }
        
        return false;
    }
}