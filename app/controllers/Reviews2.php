<?php

class Reviews2
{
    use Controller;

    private Review2 $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review2();
    }

    private function checkLogin()
    {
        if (!isset($_SESSION['user_role'])) {
            redirect('login');
        }
    }

    public function index($vet_id = null)
    {
        error_log("Received vet_id: " . $vet_id);

        $data = [
            'vet_name' => '',
            'has_reviewed' => false,
            'reviews' => [],
            'vet_id' => $vet_id
        ];

        if (!$vet_id) {
            error_log("No vet_id provided");
            $data['error'] = "Please provide a veterinarian ID";
            return $this->view('reviews2', $data);
        }

        $vet_name = $this->reviewModel->getVetName($vet_id);
        error_log("Veterinarian name retrieved: " . ($vet_name ?? 'null'));
        
        if (!$vet_name) {
            $data['error'] = "Veterinarian not found";
            return $this->view('reviews2', $data);
        }
        $data['vet_name'] = $vet_name;

        $reviews = $this->reviewModel->getVetReviews($vet_id);
        error_log("Reviews retrieved: " . count($reviews));
        $data['reviews'] = $reviews;

        if (isset($_SESSION['owner_id'])) {
            $data['has_reviewed'] = $this->reviewModel->hasUserReviewed($_SESSION['owner_id'], $vet_id);
        }

        $this->view('reviews2', $data);
    }

    public function add()
    {
        error_log("Add method called in Reviews2 controller");
        
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data received: " . print_r($_POST, true));
            
            if (empty($_POST['vet_id']) || empty($_POST['rating']) || empty($_POST['comment'])) {
                error_log("Missing required fields");
                redirect("reviews2/index/{$_POST['vet_id']}");
                return;
            }

            $data = [
                'owner_id' => $_SESSION['owner_id'],
                'vet_id' => $_POST['vet_id'],
                'rating' => (int)$_POST['rating'],
                'comment' => trim($_POST['comment'])
            ];

            error_log("Attempting to insert review with data: " . print_r($data, true));
            $result = $this->reviewModel->insert($data);
            error_log("Insert result: " . ($result ? "success" : "failure"));

            redirect("reviews2/index/{$data['vet_id']}");
        }
    }

    public function edit($review_id)
    {
        $this->checkLogin();
        
        error_log("Edit method called for review_id: " . $review_id);
        $review = $this->reviewModel->getReview($review_id);

        if (!$review || $review->owner_id != $_SESSION['owner_id']) {
            redirect('home');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("Processing POST request for edit");
            $data = [
                'rating' => $_POST['rating'],
                'comment' => trim($_POST['comment'])
            ];

            error_log("Update data: " . print_r($data, true));
            
            if ($this->reviewModel->update($review_id, $data)) {
                error_log("Update successful");
                redirect("reviews2/index/{$review->vet_id}");
                return;
            } else {
                error_log("Update failed");
            }
        }

        $data = [
            'review' => $review,
            'is_editing' => true,
            'vet_name' => $this->reviewModel->getVetName($review->vet_id)
        ];

        $this->view('reviews2', $data);
    }

    public function delete($review_id)
    {
        $this->checkLogin();
        
        error_log("Delete method called for review_id: " . $review_id);
        $review = $this->reviewModel->getReview($review_id);

        if (!$review) {
            error_log("Review not found");
            redirect('home');
            return;
        }

        if ($review->owner_id != $_SESSION['owner_id']) {
            error_log("Unauthorized delete attempt");
            redirect('home');
            return;
        }

        $vet_id = $review->vet_id;
        
        if ($this->reviewModel->delete($review_id)) {
            error_log("Review deleted successfully");
            redirect("reviews2/index/" . $vet_id);
        } else {
            error_log("Delete failed");
            redirect("reviews2/index/" . $vet_id);
        }
    }
}
