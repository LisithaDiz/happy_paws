<?php

class Reviews4
{
    use Controller;

    private Review4 $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review4();
    }

    private function checkLogin()
    {
        if (!isset($_SESSION['user_role'])) {
            redirect('login');
        }
    }

    public function index($care_center_id = null)
    {
        error_log("Received care_center_id: " . $care_center_id);

        $data = [
            'care_center_name' => '',
            'has_reviewed' => false,
            'reviews' => [],
            'care_center_id' => $care_center_id
        ];

        if (!$care_center_id) {
            error_log("No care_center_id provided");
            $data['error'] = "Please provide a care_center ID";
            return $this->view('reviews4', $data);
        }

        $care_center_name = $this->reviewModel->getCareName($care_center_id);
        error_log("care_center name retrieved: " . ($care_center_name ?? 'null'));
        
        if (!$care_center_name) {
            $data['error'] = "care_center not found";
            return $this->view('reviews4', $data);
        }
        $data['care_center_name'] = $care_center_name;

        $reviews = $this->reviewModel->getCareReviews($care_center_id);
        error_log("Reviews retrieved: " . count($reviews));
        $data['reviews'] = $reviews;

        if (isset($_SESSION['owner_id'])) {
            $data['has_reviewed'] = $this->reviewModel->hasUserReviewed($_SESSION['owner_id'], $care_center_id);
        }

        $this->view('reviews4', $data);
    }

    public function add()
    {
        error_log("Add method called in Reviews4 controller");
        
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data received: " . print_r($_POST, true));
            
            if (empty($_POST['care_center_id']) || empty($_POST['rating']) || empty($_POST['comment'])) {
                error_log("Missing required fields");
                redirect("reviews4/index/{$_POST['care_center_id']}");
                return;
            }

            $data = [
                'owner_id' => $_SESSION['owner_id'],
                'care_center_id' => $_POST['care_center_id'],
                'rating' => (int)$_POST['rating'],
                'comment' => trim($_POST['comment'])
            ];

            error_log("Attempting to insert review with data: " . print_r($data, true));
            $result = $this->reviewModel->insert($data);
            error_log("Insert result: " . ($result ? "success" : "failure"));

            redirect("reviews4/index/{$data['care_center_id']}");
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
                redirect("reviews4/index/{$review->care_center_id}");
                return;
            } else {
                error_log("Update failed");
            }
        }

        $data = [
            'review' => $review,
            'is_editing' => true,
            'care_center_name' => $this->reviewModel->getCareName($review->care_center_id)
        ];

        $this->view('reviews4', $data);
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

        $care_center_id = $review->care_center_id;
        
        if ($this->reviewModel->delete($review_id)) {
            error_log("Review deleted successfully");
            redirect("reviews4/index/" . $care_center_id);
        } else {
            error_log("Delete failed");
            redirect("reviews4/index/" . $care_center_id);
        }
    }
}
