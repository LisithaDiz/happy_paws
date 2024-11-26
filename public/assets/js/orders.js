// Modal functionality
const modal = document.getElementById('declineModal');
const closeBtn = document.getElementsByClassName('close')[0];

function showDeclineModal(orderId) {
    modal.style.display = 'block';
    document.getElementById('decline-order-id').value = orderId;
}

function closeDeclineModal() {
    modal.style.display = 'none';
}

function acceptOrder(orderId) {
    if (confirm('Are you sure you want to accept this order?')) {
        // In a real application, this would make an AJAX call to the server
        window.location.href = `${ROOT}/orders/updateStatus?order_id=${orderId}&action=accept`;
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == modal) {
        closeDeclineModal();
    }
}

// Close modal with escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDeclineModal();
    }
});