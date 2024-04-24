const form = document.getElementById('registrationFormGmail');

form.addEventListener('submit', function(event) {
    event.preventDefault();
    validateForm();
});

function validateForm() {
    const firstName = document.getElementById('firstName');
    const lastName = document.getElementById('lastName');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    const firstNameError = document.getElementById('firstNameError');
    const lastNameError = document.getElementById('lastNameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    if (firstName.value.trim() === '') {
        showError(firstNameError, 'First name is required');
    }
    else if (!isValidName(firstName.value.trim())) {
        showError(firstNameError, 'First name can only contain letters');
    }
     else {
        hideError(firstNameError);
    }


    if (lastName.value.trim() === '') {
        showError(lastNameError, 'Last name is required');
    }
    else if (!isValidName(lastName.value.trim())) {
        showError(lastNameError, 'Last name can only contain letters');
    }
     else {
        hideError(lastNameError);
    }

    if (email.value.trim() === '') {
        showError(emailError, 'Email is required');
    } else if (!isValidEmail(email.value.trim())) {
        showError(emailError, 'Invalid email address');
    } else {
        hideError(emailError);
    }

    if (password.value.trim().length < 6) {
        showError(passwordError, 'Password must be at least 6 characters long');
    } else {
        hideError(passwordError);
    }

    // If all validations pass, form submission can proceed
    if (!firstNameError.textContent && !lastNameError.textContent && !emailError.textContent && !passwordError.textContent) {
        alert('Registration successful!');
        form.reset();
        window.location.href = 'https://www.gmail.com';
    }
}

function isValidName(name) {
    const nameRegex = /^[a-zA-Z]+$/;
    return nameRegex.test(name);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showError(element, message) {
    element.textContent = message;
    element.style.display = 'block';
}

function hideError(element) {
    element.textContent = '';
    element.style.display = 'none';
}
