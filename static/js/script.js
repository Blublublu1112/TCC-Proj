// Basic JavaScript for form validation and interactions

// Confirm delete action
document.addEventListener('DOMContentLoaded', function() {
    const deleteLinks = document.querySelectorAll('.delete');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this leave application?')) {
                e.preventDefault();
            }
        });
    });
});

// Basic form validation for dates
function validateDates() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (startDate && endDate) {
        startDate.addEventListener('change', function() {
            if (endDate.value && startDate.value > endDate.value) {
                alert('Start date cannot be after end date');
                startDate.value = '';
            }
        });
        
        endDate.addEventListener('change', function() {
            if (startDate.value && endDate.value < startDate.value) {
                alert('End date cannot be before start date');
                endDate.value = '';
            }
        });
    }
}

// Run validation on page load
validateDates();