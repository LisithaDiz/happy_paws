<?php

class Reviews
{
    use Controller;
    private $reviewModel;

    public function __construct()
    {
        $this->reviewModel = $this->loadModel('Review');
    }

    private function checkLogin()
    {
        $_SESSION['owner_id'] = 1;
        return true;
    }

    public function index($sitter_id = 2)
    {
        $this->checkLogin();
        
        if($sitter_id === null) {
            $data['error'] = "Please provide a sitter ID";
            $this->view('reviews', $data);
            return;
        }

        $reviews = $this->reviewModel->getSitterReviews($sitter_id);
        
        $sitter_name = $this->reviewModel->getSitterName($sitter_id);
        
        $owner_id = 1;
        
        $data['reviews'] = $reviews;
        $data['sitter_id'] = $sitter_id;
        $data['owner_id'] = $owner_id;
        $data['has_reviewed'] = $this->reviewModel->hasUserReviewed($owner_id, $sitter_id);
        $data['sitter_name'] = $sitter_name;
        
        $this->view('reviews', $data);
    }

    public function add()
    {
        $this->checkLogin();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'owner_id' => 1,
                'sitter_id' => $_POST['sitter_id'],
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ];
            
            $this->reviewModel->insert($data);
            redirect('reviews/index/' . $_POST['sitter_id']);
        }
    }

    public function edit($id)
    {
        $this->checkLogin();

        // Get the review with owner details
        $review_data = $this->reviewModel->getReview($id);
        
        // Check if review exists and belongs to logged-in owner
        if(!$review_data || $review_data->owner_id != $_SESSION['owner_id']) {
            redirect('home');
            return;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ];
            
            $this->reviewModel->update($id, $data);
            redirect('reviews/index/' . $review_data->sitter_id);
            return;
        }

        // Get sitter name for the heading
        $data['sitter_name'] = $this->reviewModel->getSitterName($review_data->sitter_id);
        $data['review'] = $review_data;
        $data['is_editing'] = true;
        $data['sitter_id'] = $review_data->sitter_id;
        
        $this->view('reviews', $data);
    }

    public function delete($id)
    {
        $this->checkLogin();

        $review_data = $this->reviewModel->first(['id' => $id]);
        
        if($review_data && $review_data->owner_id == 1) {
            $this->reviewModel->delete($id);
        }
        
        redirect('reviews/index/' . $review_data->sitter_id);
    }
}