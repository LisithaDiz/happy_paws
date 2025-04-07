<?php

class Reviews3
{
    use Controller;

    private Review3 $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review3();
    }

    private function checkLogin()
    {
        if (!isset($_SESSION['user_role'])) {
            redirect('login');
        }
    }

    public function index($pharmacy_id = null)
    {
        error_log("Received pharmacy_id: " . $pharmacy_id);

        $data = [
            'pharmacy_name' => '',
            'has_reviewed' => false,
            'reviews' => [],
            'pharmacy_id' => $pharmacy_id
        ];

        if (!$pharmacy_id) {
            error_log("No pharmacy_id provided");
            $data['error'] = "Please provide a Pharmacy ID";
            return $this->view('reviews3', $data);
        }

        $pharmacy_name = $this->reviewModel->getPharmacyName($pharmacy_id);
        error_log("Pharmacy name retrieved: " . ($pharmacy_name ?? 'null'));
        
        if (!$pharmacy_name) {
            $data['error'] = "Pharmacy not found";
            return $this->view('reviews3', $data);
        }
        $data['pharmacy_name'] = $pharmacy_name;

        $reviews = $this->reviewModel->getPharmacyReviews($pharmacy_id);
        error_log("Reviews retrieved: " . count($reviews));
        $data['reviews'] = $reviews;

        if (isset($_SESSION['owner_id'])) {
            $data['has_reviewed'] = $this->reviewModel->hasUserReviewed($_SESSION['owner_id'], $pharmacy_id);
        }

        $this->view('reviews3', $data);
    }

    public function add()
    {
        error_log("Add method called in Reviews3 controller");
        
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data received: " . print_r($_POST, true));
            
            if (empty($_POST['pharmacy_id']) || empty($_POST['rating']) || empty($_POST['comment'])) {
                error_log("Missing required fields");
                redirect("reviews3/index/{$_POST['pharmacy_id']}");
                return;
            }

            $data = [
                'owner_id' => $_SESSION['owner_id'],
                'pharmacy_id' => $_POST['pharmacy_id'],
                'rating' => (int)$_POST['rating'],
                'comment' => trim($_POST['comment'])
            ];

            error_log("Attempting to insert review with data: " . print_r($data, true));
            $result = $this->reviewModel->insert($data);
            error_log("Insert result: " . ($result ? "success" : "failure"));

            redirect("reviews3/index/{$data['pharmacy_id']}");
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
                redirect("reviews3/index/{$review->pharmacy_id}");
                return;
            } else {
                error_log("Update failed");
            }
        }

        $data = [
            'review' => $review,
            'is_editing' => true,
            'pharmacy_name' => $this->reviewModel->getPharmacyName($review->pharmacy_id)
        ];

        $this->view('reviews3', $data);
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

        $pharmacy_id = $review->pharmacy_id;
        
        if ($this->reviewModel->delete($review_id)) {
            error_log("Review deleted successfully");
            redirect("reviews3/index/" . $pharmacy_id);
        } else {
            error_log("Delete failed");
            redirect("reviews3/index/" . $pharmacy_id);
        }
    }
}
