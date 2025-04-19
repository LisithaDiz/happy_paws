<?php 

class CageModel
{
	
	use Model;

	protected $table = 'cages';

	protected $allowedColumns = [
        'care_center_id',
		'cage_id',
        'cage_name',
		'num_of_cages', 
		'height', 
		'length',
		'width',
		'designed_for', 
		'location', 
		'available_cages',
        'additional_features',
        'cage_img'
	];

	public function getAllCages($id)
    {
        $order_column = 'cage_id';
        $query = "select * from $this->table  where care_center_id = $id order by $order_column $this->order_type";
		return $this->query($query);
        
    }

public function insertCage($data)
{
    // Validate required fields
    $requiredFields = [
        'care_center_id', 'cage_name', 'number_of_cages', 'height', 'length', 'width', 'designed_for', 'location', 'additional_features','available_cages'
    ];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Build the query
    $query = "
        INSERT INTO cages (care_center_id, cage_id, cage_name, number_of_cages, height, length, width, designed_for, location, additional_features, available_cages)
        SELECT :care_center_id, COALESCE(MAX(cage_id), 0) + 1, :cage_name, :number_of_cages, :height, :length, :width, :designed_for, :location, :additional_features, :available_cages
        FROM cages
        WHERE care_center_id = :care_center_id

    ";

    $params = [
        ':care_center_id' => $data['care_center_id'],
        ':cage_name' => $data['cage_name'],
        ':number_of_cages' => $data['number_of_cages'],
        ':height' => $data['height'],
        ':length' => $data['length'],
        ':width' => $data['width'],
        ':designed_for' => $data['designed_for'],
        ':location' => $data['location'],
        ':additional_features' => $data['additional_features'],
        ':available_cages' => $data['available_cages'],
    ];

    // Execute the query
    try {
        return $this->query($query, $params);
    } catch (PDOException $e) {
        // Handle duplicate entry error
        if ($e->getCode() === '23000') { // SQLSTATE[23000]: Integrity constraint violation
            throw new Exception("Duplicate entry: A cage with the same care_center_id and cage_id already exists.");
        }
        throw $e; // Re-throw other errors
    }
}


    public function updateCage($id, $data,$id_column)
    {
        $this->update($id,$data,'cage_id');
    }

    public function deleteCage($id)
    {
        $this->delete($id,'cage_id');
        
    }
}

