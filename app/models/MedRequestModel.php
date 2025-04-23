<?php 

class MedRequestModel
{
	
	use Model;

	protected $table = 'medicine_request';

	protected $allowedColumns = [

	        'med_request_id',
            'medicine_name',
            'note',
            'status'
	];

	
    public function getAllMedReq()
    {
        $this->order_column = "med_request_id";
        return $this->where(['status' => 1], [], 'med_request_id');
    }


}