<?php
        

class Pets
{        

    use Controller;

    private $pet;

    public function __construct() {
        $this->pet = new pet();
    }

	// public function getPetsByOwnerAndType($ownerId, $type) {


        // $stmt = $this->db->prepare("SELECT pet_id AS id, pet_name AS name, pet_type AS type 
        //                             FROM pets 
        //                             WHERE owner_id = ? AND pet_type = ?");
        // $stmt->execute([$ownerId, $type]);
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
	
		public function getAllPets() {

			// return $this->pet->getPetsByOwnerAndType($type);
			$owner_id =$_SESSION['owner_id'];
			$pets = $this->pet->findAllByOwnerId($owner_id);
    		header('Content-Type: application/json');
    		echo json_encode($pets);
		}

}


