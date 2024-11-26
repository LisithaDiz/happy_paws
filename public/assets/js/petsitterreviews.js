// public/js/reviews.js
document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('reviewForm');
    
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/petsitterreviews/submit', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Review submitted successfully!');
                    location.reload();
                } else {
                    alert(data.error || 'Failed to submit review');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the review');
            });
        });
    }
});