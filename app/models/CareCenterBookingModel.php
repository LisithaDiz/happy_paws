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
            'start_date',	
            'end_date',	
            'status',
            'created_at',
            'updated_at'
	];

    public function insertBooking($data)
    {
        $this->insert($data);
    
    }

    // public function updateBooking($id, $data,$id_column)
    // {
    //     $this->update($id,$data,'booking_id');
    // }

    // public function deleteBooking($id)
    // {
    //     $this->delete($id,'booking_id');
        
    // }
    
	
}