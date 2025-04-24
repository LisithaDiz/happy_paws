<?php

require_once '../app/core/Model.php';
require_once '../app/core/Database.php';

class SitterAppointments
{
    use Model;

    protected $table = 'sitter_appointments';

    protected $allowedColumns = [
        'appointment_id',
        'pet_id',
        'appointment_status',
        'sitter_id',
        'day_of_appointment'
    ];

    public function insert($data)
    {
        // Log the incoming data
        error_log("SitterAppointments::insert - Received data: " . print_r($data, true));
        
        // Only allow allowed columns
        $data = array_intersect_key($data, array_flip($this->allowedColumns));
        error_log("SitterAppointments::insert - Filtered data: " . print_r($data, true));

        $keys = array_keys($data);
        $columns = implode(',', $keys);
        $placeholders = implode(',', array_map(fn($k) => ':' . $k, $keys));

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        error_log("SitterAppointments::insert - Generated query: " . $query);
        error_log("SitterAppointments::insert - Query parameters: " . print_r($data, true));

        try {
            $result = $this->query($query, $data);
            if ($result === false) {
                error_log("SitterAppointments::insert - Query failed");
                return false;
            }
            error_log("SitterAppointments::insert - Query successful");
            return true;
        } catch (Exception $e) {
            error_log("SitterAppointments::insert - Exception: " . $e->getMessage());
            return false;
        }
    }

    public function getSitterAppointments($sitter_id)
    {
        $query = "SELECT sa.*, p.pet_name, p.pet_type, p.breed, p.age, p.gender, p.color,
                        ps.sitter_id, ps.user_id, ps.f_name, ps.l_name, ps.age, ps.gender,
                        ps.district, ps.city, ps.street, ps.contact_no, ps.years_exp
                 FROM $this->table sa 
                 JOIN pets p ON sa.pet_id = p.pet_id
                 JOIN pet_sitter ps ON sa.sitter_id = ps.sitter_id 
                 WHERE sa.sitter_id = :sitter_id 
                 ORDER BY sa.day_of_appointment ASC";
        
        return $this->query($query, ['sitter_id' => $sitter_id]);
    }

    public function getUserAppointments($user_id)
    {
        $query = "SELECT sa.*, 
                        p.pet_name, p.pet_type, p.breed, p.age, p.gender, p.color,
                        ps.sitter_id, ps.user_id, ps.f_name, ps.l_name, ps.age, ps.gender,
                        ps.district, ps.city, ps.street, ps.contact_no, ps.years_exp
                 FROM {$this->table} sa 
                 JOIN pets p ON sa.pet_id = p.pet_id 
                 JOIN pet_sitter ps ON sa.sitter_id = ps.sitter_id 
                 WHERE p.owner_id = :user_id 
                 ORDER BY sa.day_of_appointment DESC";

        $params = [':user_id' => $user_id];
        return $this->query($query, $params);
    }

    public function getAppointmentById($id)
    {
        $query = "SELECT sa.*, p.pet_name, p.pet_type, p.breed, p.age, p.gender, p.color, p.owner_id as user_id 
                 FROM {$this->table} sa 
                 JOIN pets p ON sa.pet_id = p.pet_id 
                 WHERE sa.appointment_id = :id";
        $params = [':id' => $id];
        $result = $this->query($query, $params);
        return !empty($result) ? $result[0] : null;
    }

    public function deleteAppointment($id)
    {
        $query = "DELETE FROM {$this->table} WHERE appointment_id = :id";
        $params = [':id' => $id];
        $result = $this->query($query, $params);
        
        return $result !== false;
    }

    public function updateAppointmentStatus($appointment_id, $status)
    {
        $query = "UPDATE {$this->table} SET appointment_status = :status WHERE appointment_id = :appointment_id";
        $params = [
            ':status' => $status,
            ':appointment_id' => $appointment_id
        ];
        
        $result = $this->query($query, $params);
        return $result !== false;
        
    }
}
