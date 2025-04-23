<?php

class CareCenterAvailabilityModel
{
    use Model;

    protected $table = 'care_center_unavailable_dates';

    protected $allowedColumns = [
        'date_id',
        'care_center_id',
        'unavailable_date',
        'created_at'
    ];

    public function insertUnavailableDate($data)
    {
        return $this->insert($data);
    }

    public function deleteUnavailableDate($date, $care_center_id)
    {
        $query = "DELETE FROM $this->table WHERE unavailable_date = :date AND care_center_id = :care_center_id";
        return $this->query($query, ['date' => $date, 'care_center_id' => $care_center_id]);
    }

    public function getUnavailableDates($care_center_id)
    {
        $query = "SELECT unavailable_date FROM $this->table WHERE care_center_id = :care_center_id";
        $result = $this->query($query, ['care_center_id' => $care_center_id]);
        
        if (is_array($result) && !empty($result)) {
            return array_column($result, 'unavailable_date');
        }
        return [];
    }

    public function getAllUnavailableDates()
    {
        $order_column = 'date_id';
        $query = "SELECT 
                ua.date_id,
                ua.care_center_id,
                ua.unavailable_date,
                ua.created_at,
                cc.name as care_center_name
            FROM 
                $this->table AS ua
            JOIN 
                pet_care_center AS cc 
            ON 
                ua.care_center_id = cc.care_center_id
            ORDER BY 
                $order_column $this->order_type";

        return $this->query($query);
    }

    public function getUnavailableDatesByCenter($center_id)
    {
        $query = "SELECT 
                ua.date_id,
                ua.unavailable_date,
                ua.created_at,
                cc.name as care_center_name
            FROM 
                $this->table AS ua
            JOIN 
                pet_care_center AS cc 
            ON 
                ua.care_center_id = cc.care_center_id
            WHERE 
                ua.care_center_id = :center_id";

        $params = ['center_id' => $center_id];
        return $this->query($query, $params);
    }
} 