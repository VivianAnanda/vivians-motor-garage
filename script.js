// Client-side validation and form handling for User Panel

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('appointmentForm');
    const dateInput = document.getElementById('appointment_date');
    const mechanicSelect = document.getElementById('mechanic_id');
    const availabilityInfo = document.getElementById('availability_info');
    const messageDiv = document.getElementById('message');

    // Load mechanics list on page load
    loadMechanicsList();

    // Real-time validation for name
    document.getElementById('client_name').addEventListener('blur', function() {
        validateName();
    });

    // Real-time validation for phone
    document.getElementById('client_phone').addEventListener('blur', function() {
        validatePhone();
    });

    // Real-time validation for car engine number
    document.getElementById('car_engine_number').addEventListener('blur', function() {
        validateEngineNumber();
    });

    // Real-time validation for license number
    document.getElementById('car_license_number').addEventListener('blur', function() {
        validateLicense();
    });

    // Check availability when date or mechanic changes
    dateInput.addEventListener('change', function() {
        checkAvailability();
        updateMechanicsListAvailability();
    });

    mechanicSelect.addEventListener('change', function() {
        checkAvailability();
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearErrors();
        
        // Validate all fields
        let isValid = true;
        
        if (!validateName()) isValid = false;
        if (!validatePhone()) isValid = false;
        if (!validateEngineNumber()) isValid = false;
        if (!validateLicense()) isValid = false;
        if (!validateAddress()) isValid = false;
        if (!validateDate()) isValid = false;
        if (!validateMechanic()) isValid = false;
        
        if (isValid) {
            submitForm();
        } else {
            showMessage('Please correct the errors before submitting.', 'error');
        }
    });

    // Validation functions
    function validateName() {
        const nameInput = document.getElementById('client_name');
        const nameError = document.getElementById('name_error');
        const name = nameInput.value.trim();
        
        if (name === '') {
            nameError.textContent = 'Name is required.';
            nameInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        if (!/^[a-zA-Z\s]+$/.test(name)) {
            nameError.textContent = 'Name should contain only letters and spaces.';
            nameInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        if (name.length < 3) {
            nameError.textContent = 'Name should be at least 3 characters long.';
            nameInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        nameError.textContent = '';
        nameInput.style.borderColor = '#28a745';
        return true;
    }

    function validatePhone() {
        const phoneInput = document.getElementById('client_phone');
        const phoneError = document.getElementById('phone_error');
        const phone = phoneInput.value.trim();
        
        if (phone === '') {
            phoneError.textContent = 'Phone number is required.';
            phoneInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        if (!/^[0-9]{10,15}$/.test(phone)) {
            phoneError.textContent = 'Phone number should contain only digits (10-15 digits).';
            phoneInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        phoneError.textContent = '';
        phoneInput.style.borderColor = '#28a745';
        return true;
    }

    function validateEngineNumber() {
        const engineInput = document.getElementById('car_engine_number');
        const engineError = document.getElementById('engine_error');
        const engine = engineInput.value.trim();
        
        if (engine === '') {
            engineError.textContent = 'Car engine number is required.';
            engineInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        if (!/^[a-zA-Z0-9]+$/.test(engine)) {
            engineError.textContent = 'Engine number should be alphanumeric.';
            engineInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        if (engine.length < 5) {
            engineError.textContent = 'Engine number should be at least 5 characters long.';
            engineInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        engineError.textContent = '';
        engineInput.style.borderColor = '#28a745';
        return true;
    }

    function validateLicense() {
        const licenseInput = document.getElementById('car_license_number');
        const licenseError = document.getElementById('license_error');
        const license = licenseInput.value.trim();
        
        if (license === '') {
            licenseError.textContent = 'Car license number is required.';
            licenseInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        if (license.length < 5) {
            licenseError.textContent = 'License number should be at least 5 characters long.';
            licenseInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        licenseError.textContent = '';
        licenseInput.style.borderColor = '#28a745';
        return true;
    }

    function validateAddress() {
        const addressInput = document.getElementById('client_address');
        const addressError = document.getElementById('address_error');
        const address = addressInput.value.trim();
        
        if (address === '') {
            addressError.textContent = 'Address is required.';
            addressInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        if (address.length < 10) {
            addressError.textContent = 'Please provide a complete address (at least 10 characters).';
            addressInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        addressError.textContent = '';
        addressInput.style.borderColor = '#28a745';
        return true;
    }

    function validateDate() {
        const dateInput = document.getElementById('appointment_date');
        const dateError = document.getElementById('date_error');
        const date = dateInput.value;
        
        if (date === '') {
            dateError.textContent = 'Appointment date is required.';
            dateInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        const today = new Date().toISOString().split('T')[0];
        if (date < today) {
            dateError.textContent = 'Appointment date cannot be in the past.';
            dateInput.style.borderColor = '#e74c3c';
            return false;
        }
        
        dateError.textContent = '';
        dateInput.style.borderColor = '#28a745';
        return true;
    }

    function validateMechanic() {
        const mechanicSelect = document.getElementById('mechanic_id');
        const mechanicError = document.getElementById('mechanic_error');
        
        if (mechanicSelect.value === '') {
            mechanicError.textContent = 'Please select a mechanic.';
            mechanicSelect.style.borderColor = '#e74c3c';
            return false;
        }
        
        mechanicError.textContent = '';
        mechanicSelect.style.borderColor = '#28a745';
        return true;
    }

    function clearErrors() {
        const errors = document.querySelectorAll('.error');
        errors.forEach(error => error.textContent = '');
        
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.style.borderColor = '#e0e0e0');
    }

    // Check mechanic availability
    function checkAvailability() {
        const mechanicId = mechanicSelect.value;
        const date = dateInput.value;
        
        if (mechanicId && date) {
            fetch(`get_availability.php?mechanic_id=${mechanicId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayAvailability(data);
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            availabilityInfo.innerHTML = '';
        }
    }

    function displayAvailability(data) {
        if (data.available_slots > 0) {
            availabilityInfo.className = 'info-box success';
            availabilityInfo.innerHTML = `
                ✓ ${data.mechanic} has ${data.available_slots} slot(s) available on this date.
            `;
        } else {
            availabilityInfo.className = 'info-box error';
            availabilityInfo.innerHTML = `
                ✗ ${data.mechanic} is fully booked on this date. Please select another mechanic or date.
            `;
        }
    }

    // Load and display mechanics list
    function loadMechanicsList() {
        const today = new Date().toISOString().split('T')[0];
        updateMechanicsListAvailability(today);
    }

    function updateMechanicsListAvailability(date = null) {
        const selectedDate = date || dateInput.value || new Date().toISOString().split('T')[0];
        
        fetch(`get_availability.php?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayMechanicsList(data.mechanics);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function displayMechanicsList(mechanics) {
        const mechanicsList = document.getElementById('mechanics_list');
        if (!mechanicsList) return;
        
        mechanicsList.innerHTML = '';
        
        mechanics.forEach(mechanic => {
            const card = document.createElement('div');
            card.className = 'mechanic-card';
            
            const availClass = mechanic.available_slots > 0 ? 'available' : 'full';
            const availText = mechanic.available_slots > 0 
                ? `${mechanic.available_slots} slots available` 
                : 'Fully booked';
            
            card.innerHTML = `
                <h4>${mechanic.mechanic_name}</h4>
                <p>${mechanic.specialization}</p>
                <p class="availability ${availClass}">${availText}</p>
            `;
            
            mechanicsList.appendChild(card);
        });
    }

    // Submit form via AJAX
    function submitForm() {
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = 'Booking... <span class="spinner"></span>';
        submitBtn.disabled = true;
        
        const formData = new FormData(form);
        
        fetch('submit_appointment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
                form.reset();
                clearErrors();
                availabilityInfo.innerHTML = '';
                loadMechanicsList();
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            showMessage('An error occurred. Please try again.', 'error');
            console.error('Error:', error);
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    function showMessage(message, type) {
        messageDiv.className = type;
        messageDiv.innerHTML = message;
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
});
