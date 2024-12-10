// Show Edit Modal and populate form fields
function showEditModal(staff) {
    // Set values in the form fields
    document.querySelector('#editModal input[name="staff_id"]').value = staff.staff_id;
    document.querySelector('#editModal input[name="name"]').value = staff.name;
    document.querySelector('#editModal input[name="email"]').value = staff.email;
    document.querySelector('#editModal input[name="balance"]').value = staff.balance;

    // Display the modal
    document.getElementById('editModal').style.display = 'block';
}

// Show Delete Modal and populate confirmation message
function confirmDelete(staff_id, staff_name) {
    // Set the message in the delete confirmation modal
    document.getElementById('deleteMessage').textContent = `Are you sure you want to delete ${staff_name}?`;

    // Set the staff ID in the form for deletion
    document.querySelector('#deleteModal input[name="staff_id"]').value = staff_id;

    // Show the delete modal
    document.getElementById('deleteModal').style.display = 'block';
}

// Hide modals
function hideModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modals if clicked outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        hideModal(event.target.id);
    }
}
