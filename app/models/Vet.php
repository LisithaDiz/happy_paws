<?php

/**
 * Vet class
 */
class Vet
{
    use Model;

    protected $table = 'veterinary_surgeons'; // Update this to the appropriate table name for vets

    protected $allowedColumns = [
        'name',
        'location',
        'rating',
    ];

    // Hardcoded sample data, replace with database fetch if connected
    private $vetsData = [
        ["name" => "Dr. Smith", "location" => "New York", "rating" => 5],
        ["name" => "Dr. Williams", "location" => "Los Angeles", "rating" => 4],
        ["name" => "Dr. Taylor", "location" => "Chicago", "rating" => 5],
        // Add more as needed
    ];

    /**
     * Search for vets based on name and location
     *
     * @param string $name
     * @param string $location
     * @return array Filtered results
     */
    public function searchVets($name = '', $location = '')
    {
        // Filter vets data by name and location
        $results = array_filter($this->vetsData, function ($vet) use ($name, $location) {
            $matchesName = empty($name) || stripos($vet['name'], $name) !== false;
            $matchesLocation = empty($location) || stripos($vet['location'], $location) !== false;
            return $matchesName && $matchesLocation;
        });

        return $results;
    }

    /**
     * Validate user input data
     */
    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['name'])) {
            $this->errors['name'] = "Name is required";
        }

        if (empty($data['location'])) {
            $this->errors['location'] = "Location is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
