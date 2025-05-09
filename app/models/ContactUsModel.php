<?php 

class ContactUsModel
{
	
	use Model;

	protected $table = 'contact_us';


	protected $allowedColumns = [
	        'id',
            'user_id',
            'name',
            'email',
            'subject',
            'message'
	];


    public function addContactUs($data)
    {
        return $this->insert($data);
    }

    public function getAllContactUsInfo()
    {
        $order_column = 'id';
        $query = "select * from $this->table order by $order_column $this->order_type";
		return $this->query($query);
    }

	
}