<?php 

class CareCenterBookingModel
{
	
	use Model;

	protected $table = 'care_center_bookings';
   
	protected $allowedColumns = [
            'booking_id',
            'care_center_id',	
            'pet_id',
            'owner_id',
            'cage_id',
            'booking_date',	
            'status',
            'created_at',
            'updated_at',
            'special_req',
        
	];

    public function insertBooking($data)
    {
        return $this->insert($data);
    }

    public function getBookingsByDate($care_center_id, $date)
    {
        $query = "SELECT 
                    b.booking_id,
                    b.booking_date,
                    b.status,
                    b.special_req as special_requirements,
                    p.pet_name as pet_name,
                    po.f_name as owner_name,
                    c.cage_name
                FROM 
                    $this->table b
                JOIN 
                    pets p ON b.pet_id = p.pet_id
                JOIN 
                    pet_owner po ON b.owner_id = po.owner_id
                JOIN 
                    cages c ON b.cage_id = c.cage_id
                WHERE 
                    b.care_center_id = :care_center_id
                    AND DATE(b.booking_date) = DATE(:date)
                ORDER BY 
                    b.booking_date ASC";

        $params = [
            'care_center_id' => $care_center_id,
            'date' => $date
        ];

        return $this->query($query, $params);
    }

    public function getBookingsByPetOwner($petOwnerId)
    {
        $query = "SELECT 
                    b.*,
                    c.cage_name
                FROM 
                    $this->table b
                JOIN 
                    cages c ON b.cage_id = c.cage_id
                WHERE 
                    b.owner_id = :owner_id 
                ORDER BY 
                    b.created_at DESC";
        return $this->query($query, ['owner_id' => $petOwnerId]);
    }

    public function getBookingById($bookingId)
    {
        $query = "SELECT * FROM $this->table WHERE booking_id = :booking_id";
        $result = $this->query($query, ['booking_id' => $bookingId]);
        return $result[0] ?? null;
    }

    public function cancelBooking($bookingId)
    {
        $query = "UPDATE $this->table SET status = 'Cancelled' WHERE booking_id = :booking_id";
        return $this->query($query, ['booking_id' => $bookingId]);
    }

    public function getBookingsByDateRange($care_center_id, $cage_id, $start_date, $end_date)
    {
        $query = "SELECT 
                    b.booking_id,
                    b.booking_date,
                    b.status,
                    b.special_req as special_requirements,
                    p.pet_name as pet_name,
                    po.f_name as owner_name,
                    b.cage_id
                FROM 
                    $this->table b
                JOIN 
                    pets p ON b.pet_id = p.pet_id
                JOIN 
                    pet_owner po ON b.owner_id = po.owner_id
                JOIN 
                    cages c ON b.cage_id = c.cage_id
                WHERE 
                    b.care_center_id = :care_center_id
                    AND b.cage_id = :cage_id
                    AND DATE(b.booking_date) BETWEEN DATE(:start_date) AND DATE(:end_date)
                ORDER BY 
                    b.booking_date ASC";

        $params = [
            'care_center_id' => $care_center_id,
            'cage_id' => $cage_id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return $this->query($query, $params);
    }

    public function getAllBookingsByCareCenter($care_center_id)
    {
        $query = "SELECT 
                    b.booking_id,
                    b.booking_date,
                    b.status,
                    b.special_req as special_requirements,
                    p.pet_name as pet_name,
                    po.f_name as owner_name,
                    c.cage_name,
                    b.owner_id
                FROM 
                    $this->table b
                JOIN 
                    pets p ON b.pet_id = p.pet_id
                JOIN 
                    pet_owner po ON b.owner_id = po.owner_id
                JOIN 
                    cages c ON b.cage_id = c.cage_id
                WHERE 
                    b.care_center_id = :care_center_id
                ORDER BY 
                    b.booking_date DESC";

        $params = [
            'care_center_id' => $care_center_id
        ];

        return $this->query($query, $params);
    }

    public function getBookingsByDates($care_center_id, $start_date, $end_date)
    {
        $query = "SELECT 
                    b.booking_id,
                    b.booking_date,
                    b.status,
                    b.special_req as special_requirements,
                    p.pet_name as pet_name,
                    po.f_name as owner_name,
                    b.cage_id
                FROM 
                    $this->table b
                JOIN 
                    pets p ON b.pet_id = p.pet_id
                JOIN 
                    pet_owner po ON b.owner_id = po.owner_id
                JOIN 
                    cages c ON b.cage_id = c.cage_id
                WHERE 
                    b.care_center_id = :care_center_id
                    AND DATE(b.booking_date) BETWEEN DATE(:start_date) AND DATE(:end_date)
                ORDER BY 
                    b.booking_date ASC";

        $params = [
            'care_center_id' => $care_center_id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return $this->query($query, $params);
    }
    
    public function insertMultipleBookings($bookings)
    {
        $success = true;
        
        foreach ($bookings as $booking) {
            // Ensure all required fields are present
            if (!isset($booking['care_center_id']) || 
                !isset($booking['pet_id']) || 
                !isset($booking['owner_id']) || 
                !isset($booking['cage_id']) || 
                !isset($booking['booking_date'])) {
                $success = false;
                break;
            }
            
            // Add default values if not set
            $booking['status'] = $booking['status'] ?? 'Pending';
            $booking['created_at'] = $booking['created_at'] ?? date('Y-m-d H:i:s');
            $booking['special_req'] = $booking['special_req'] ?? '';
            
            // Use the Model trait's insert method
            $result = $this->insert($booking);
            if (!$result) {
                $success = false;
                break;
            }
        }
        
        return $success;
    }
}