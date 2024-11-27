document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    const modal = document.getElementById("requestMedicineModal");
    
    // Get the button that opens the modal
    const btn = document.getElementById("requestMedicineBtn");
    
    // Get the <span> element that closes the modal
    const span = document.querySelector(".close");

    // When the user clicks the button, open the modal 
    if(btn) {
        btn.onclick = function() {
            modal.style.display = "block";
        }
    }

    // When the user clicks on <span> (x), close the modal
    if(span) {
        span.onclick = function() {
            modal.style.display = "none";
        }
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});