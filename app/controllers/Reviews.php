<?php

class Reviews
{
    use Controller;

    private Review $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review();
    }

    private function checkLogin()
    {
        if (!isset($_SESSION['user_role'])) {
            redirect('login');
        }
    }

    public function index($sitter_id = null)
    {
        error_log("Received sitter_id: " . $sitter_id);

        $data = [
            'sitter_name' => '',
            'has_reviewed' => false,
            'reviews' => [],
            'sitter_id' => $sitter_id
        ];

        if (!$sitter_id) {
            error_log("No sitter_id provided");
            $data['error'] = "Please provide a sitter ID";
            return $this->view('reviews', $data);
        }

        $sitter_name = $this->reviewModel->getSitterName($sitter_id);
        error_log("Sitter name retrieved: " . ($sitter_name ?? 'null'));
        
        if (!$sitter_name) {
            $data['error'] = "Sitter not found";
            return $this->view('reviews', $data);
        }
        $data['sitter_name'] = $sitter_name;

        $reviews = $this->reviewModel->getSitterReviews($sitter_id);
        error_log("Reviews retrieved: " . count($reviews));
        $data['reviews'] = $reviews;

        if (isset($_SESSION['owner_id'])) {
            $data['has_reviewed'] = $this->reviewModel->hasUserReviewed($_SESSION['owner_id'], $sitter_id);
        }

        $this->view('reviews', $data);
    }

    public function add()
    {
        error_log("Add method called in Reviews controller");
        
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data received: " . print_r($_POST, true));
            
            if (empty($_POST['sitter_id']) || empty($_POST['rating']) || empty($_POST['comment'])) {
                error_log("Missing required fields");
                redirect("reviews/index/{$_POST['sitter_id']}");
                return;
            }

            $data = [
                'owner_id' => $_SESSION['owner_id'],
                'sitter_id' => $_POST['sitter_id'],
                'rating' => (int)$_POST['rating'],
                'comment' => trim($_POST['comment'])
            ];

            error_log("Attempting to insert review with data: " . print_r($data, true));
            $result = $this->reviewModel->insert($data);
            error_log("Insert result: " . ($result ? "success" : "failure"));

            redirect("reviews/index/{$data['sitter_id']}");
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
                redirect("reviews/index/{$review->sitter_id}");
                return;
            } else {
                error_log("Update failed");
            }
        }

        $data = [
            'review' => $review,
            'is_editing' => true,
            'sitter_name' => $this->reviewModel->getSitterName($review->sitter_id)
        ];

        $this->view('reviews', $data);
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

        $sitter_id = $review->sitter_id;
        
        if ($this->reviewModel->delete($review_id)) {
            error_log("Review deleted successfully");
            redirect("reviews/index/" . $sitter_id);
        } else {
            error_log("Delete failed");
            redirect("reviews/index/" . $sitter_id);
        }
    }
}
