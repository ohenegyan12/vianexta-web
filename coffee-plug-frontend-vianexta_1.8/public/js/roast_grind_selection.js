// Get all buttons with the hover-button class
const buttons = document.querySelectorAll('.card-icon');

// Create an object to store modal instances
const modalInstances = {};

// Initialize all modals and set up event listeners
buttons.forEach(button => {
    const modalId = button.getAttribute('data-modal-target');
    
    // Check if the data-modal-target attribute exists
    if (modalId) {
        const modalElement = document.getElementById(modalId);
        
        // Check if the modal element exists
        if (modalElement) {
            modalInstances[modalId] = new bootstrap.Modal(modalElement);
            
            // Show modal on hover
            button.addEventListener('mouseenter', () => {
                modalInstances[modalId].show();
            });
            
            // Optional: Hide modal when mouse leaves
            button.addEventListener('mouseleave', () => {
                modalInstances[modalId].hide();
            });
        }
    }
});