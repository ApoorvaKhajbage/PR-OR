const form = document.getElementById('registrationForm');

const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const email = document.getElementById('email');
const password = document.getElementById('password');

const firstNameError = document.getElementById('firstNameError');
const lastNameError = document.getElementById('lastNameError');
const emailError = document.getElementById('emailError');
const passwordError = document.getElementById('passwordError');

firstName.addEventListener('input', validateFirstName);
lastName.addEventListener('input', validateLastName);
email.addEventListener('input', validateEmail);
password.addEventListener('input', validatePassword);

function validateFirstName() {
    if (!isValidName(firstName.value.trim())) {
        firstNameError.textContent = 'First name can only contain letters';
    } else {
        firstNameError.textContent = '';
    }
}

function validateLastName() {
    if (!isValidName(lastName.value.trim())) {
        lastNameError.textContent = 'Last name can only contain letters';
    } else {
        lastNameError.textContent = '';
    }
}

function validateEmail() {
    if (!isValidEmail(email.value.trim())) {
        emailError.textContent = 'Invalid email address';
    } else {
        emailError.textContent = '';
    }
}

function validatePassword() {
    if (password.value.trim().length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters long';
    } else {
        passwordError.textContent = '';
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

form.addEventListener('submit', function(event) {
    event.preventDefault();
    validateForm();
});

function validateForm() {
    validateFirstName();
    validateLastName();
    validateEmail();
    validatePassword();

    if (!firstNameError.textContent && !lastNameError.textContent && !emailError.textContent && !passwordError.textContent) {
        alert('Registration successful!');
        const firstNameValue = firstName.value.trim();
        localStorage.setItem('firstName', firstNameValue);
        form.reset();
        // Redirect to welcome page or do other processing
        window.location.href ="welcome.html"
    }
}
