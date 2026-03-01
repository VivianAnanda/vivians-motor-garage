// Admin Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const messageDiv = document.getElementById('admin_message');

    // Edit form submission
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        updateAppointment();
    });

    // Check availability when date or mechanic changes in edit form
    document.getElementById('edit_date').addEventListener('change', checkEditAvailability);
    document.getElementById('edit_mechanic').addEventListener('change', checkEditAvailability);
});

// Open edit modal
function editAppointment(appointmentId) {
    // Fetch appointment details
    fetch(`get_appointment.php?id=${appointmentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateEditForm(data.appointment);
                document.getElementById('editModal').style.display = 'block';
            } else {
                showAdminMessage(data.message, 'error');
            }
        })
        .catch(error => {
            showAdminMessage('Error loading appointment details.', 'error');
            console.error('Error:', error);
        });
}

// Populate edit form with appointment data
function populateEditForm(appointment) {
    document.getElementById('edit_appointment_id').value = appointment.appointment_id;
    document.getElementById('edit_client_name').value = appointment.client_name;
    document.getElementById('edit_phone').value = appointment.client_phone;
    document.getElementById('edit_date').value = appointment.appointment_date;
    document.getElementById('edit_mechanic').value = appointment.mechanic_id;
    document.getElementById('edit_status').value = appointment.status;
    
    // Check availability for the current selection
    checkEditAvailability();
}

// Check availability in edit form
function checkEditAvailability() {
    const mechanicId = document.getElementById('edit_mechanic').value;
    const date = document.getElementById('edit_date').value;
    const appointmentId = document.getElementById('edit_appointment_id').value;
    const availabilityInfo = document.getElementById('edit_availability_info');
    
    if (mechanicId && date) {
        fetch(`get_availability.php?mechanic_id=${mechanicId}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Note: The current appointment doesn't count against availability
                    // This will be handled server-side
                    if (data.available_slots > 0 || data.available_slots === 0) {
                        const slotsText = data.available_slots > 0 
                            ? `${data.available_slots} slot(s) available` 
                            : 'Fully booked (update may still work if changing from same date/mechanic)';
                        
                        availabilityInfo.className = data.available_slots > 0 
                            ? 'info-box success' 
                            : 'info-box warning';
                        availabilityInfo.innerHTML = `${data.mechanic} - ${slotsText}`;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        availabilityInfo.innerHTML = '';
    }
}

// Update appointment
function updateAppointment() {
    const formData = new FormData(document.getElementById('editForm'));
    
    fetch('update_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAdminMessage(data.message, 'success');
            closeEditModal();
            updateTableRow(data.appointment);
        } else {
            showAdminMessage(data.message, 'error');
        }
    })
    .catch(error => {
        showAdminMessage('Error updating appointment.', 'error');
        console.error('Error:', error);
    });
}

// Update table row without page reload
function updateTableRow(appointment) {
    const row = document.getElementById('row_' + appointment.appointment_id);
    if (row) {
        const cells = row.cells;
        
        // Update date
        cells[4].innerHTML = `<span class="date-display">${formatDate(appointment.appointment_date)}</span>`;
        
        // Update mechanic
        cells[5].textContent = appointment.mechanic_name;
        
        // Update status
        cells[6].innerHTML = `<span class="status-badge status-${appointment.status}">${ucfirst(appointment.status)}</span>`;
    }
}

// Delete/Cancel appointment
function deleteAppointment(appointmentId) {
    if (!confirm('Are you sure you want to cancel this appointment?')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('appointment_id', appointmentId);
    
    fetch('delete_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAdminMessage(data.message, 'success');
            
            // Update the row to show cancelled status
            const row = document.getElementById('row_' + appointmentId);
            if (row) {
                const statusCell = row.cells[6];
                statusCell.innerHTML = '<span class="status-badge status-cancelled">Cancelled</span>';
                
                // Optionally fade out the row
                row.style.opacity = '0.5';
            }
        } else {
            showAdminMessage(data.message, 'error');
        }
    })
    .catch(error => {
        showAdminMessage('Error cancelling appointment.', 'error');
        console.error('Error:', error);
    });
}

// Close edit modal
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('edit_availability_info').innerHTML = '';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}

// Show admin message
function showAdminMessage(message, type) {
    const messageDiv = document.getElementById('admin_message');
    messageDiv.className = type;
    messageDiv.textContent = message;
    messageDiv.style.display = 'block';
    
    // Scroll to message
    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    
    // Auto-hide success messages after 5 seconds
    if (type === 'success') {
        setTimeout(() => {
            messageDiv.style.display = 'none';
        }, 5000);
    }
}

// Helper functions
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// Filter/Search functionality (optional enhancement)
function filterTable() {
    const input = document.getElementById('searchInput');
    if (!input) return;
    
    const filter = input.value.toUpperCase();
    const table = document.querySelector('.appointments-table');
    const tr = table.getElementsByTagName('tr');
    
    for (let i = 1; i < tr.length; i++) {
        let txtValue = tr[i].textContent || tr[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = '';
        } else {
            tr[i].style.display = 'none';
        }
    }
}
