<?php 

class MedicineModel
{
	
	use Model;

	protected $table = 'medicine';
   
	protected $allowedColumns = [

			'med_id',
            'med_name',
            'med_description',
            'price'
        
	];

    public function getAllMedicines()
    {
        $query = "SELECT * FROM medicine";
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