// Modal functionality
function showDeclineModal(orderId) {
    const modal = document.getElementById('declineModal');
    const declineOrderId = document.getElementById('decline-order-id');
    
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        modal.classList.add('show');
    });
    declineOrderId.value = orderId;
    
    // Prevent body scrolling when modal is open
    document.body.style.overflow = 'hidden';
}

function closeDeclineModal() {
    const modal = document.getElementById('declineModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        // Re-enable body scrolling
        document.body.style.overflow = 'auto';
    }, 300);
}

function acceptOrder(orderId) {
    console.log('Accept Order function called with ID:', orderId);
    if (confirm('Are you sure you want to accept this order?')) {
        console.log('Sending request to:', `${ROOT}/orders/updateStatus?order_id=${orderId}&action=accept`);
        fetch(`${ROOT}/orders/updateStatus?order_id=${orderId}&action=accept`, {
            method: 'GET'
        })
        .then(response => {
            console.log('Response received:', response);
            return response.text();
        })
        .then(() => {
            alert('Order has been accepted successfully!');
            location.reload(); // Reload the page to show updated status
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to accept order. Please try again.');
        });
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('declineModal');
    if (event.target === modal) {
        closeDeclineModal();
    }
}

// Close modal when clicking X button
document.querySelector('.close').addEventListener('click', function() {
    closeDeclineModal();
});

// Prevent modal from closing when clicking inside modal content
document.querySelector('.modal-content').addEventListener('click', function(event) {
    event.stopPropagation();
});

// Close modal with escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDeclineModal();
    }
});

// Handle decline form submission
document.querySelector('#declineModal form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(`${ROOT}/orders/updateStatus`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(() => {
        alert('Order has been declined successfully!');
        closeDeclineModal();
        location.reload(); // Reload the page to show updated status
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to decline order. Please try again.');
    });
});