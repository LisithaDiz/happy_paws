<?php 

class MedicineModel
{
	
	use Model;

	protected $table = 'medicine';
   
	protected $allowedColumns = [

			'med_id',
            'med_name',
            'med_description'
        
	];

    public function getAllMedicines()
    {
        $order_column = 'med_id';
        $query = "select * from $this->table order by $order_column $this->order_type";
		return $this->query($query);
        
    }

    public function insertMedicine($data)
    {
        $this->insert($data);
    
    }

    public function updateMedicine($id, $data,$id_column)
    {
        $this->update($id,$data,'med_id');
    }

    public function deleteMedicine($id)
    {
        $this->delete($id,'med_id');
        
    }
    
	
}