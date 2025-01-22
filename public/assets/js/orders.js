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
    if (confirm('Are you sure you want to accept this order?')) {
        // In a real application, this would make an AJAX call to the server
        window.location.href = `${ROOT}/orders/updateStatus?order_id=${orderId}&action=accept`;
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