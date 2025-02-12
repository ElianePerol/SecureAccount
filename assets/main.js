class FormValidator {
    constructor(formId) {
        this.form = document.getElementById(formId);
        if (!this.form) {
            console.error(`Form with ID '${formId}' not found!`);
            return; // Or handle the error as needed
        }
        this.errors = new Map();

        this.validateForm = this.validateForm.bind(this);
        this.resetErrors = this.resetErrors.bind(this);

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (this.validateForm()) {
                this.form.submit(); // Only submit if validation passes
            }
        });
    }

    validateForm() {
        this.resetErrors();
        let isValid = true;

        if (this.form.id === 'loginForm') {
            isValid = this.validateUsernameOrEmail() && this.validateLoginPassword(); // Specific login validation
        } else if (this.form.id === 'registrationForm') {
            isValid = this.validateUsername() && this.validateEmail() && this.validateRegistrationPassword() && this.validatePasswordConfirmation(); // Specific registration validation
        }

        this.displayErrors();
        return isValid;
    }


    validateUsernameOrEmail() {
        const usernameOrEmail = this.form.querySelector('#usernameOrEmail').value;
        if (!usernameOrEmail) { // Check if empty
            this.errors.set('usernameOrEmail', 'Username or Email is required');
            return false;
        }
        return true; // You might want to add more validation here (e.g., email format)
    }


    validateLoginPassword() {
        const password = this.form.querySelector('#password').value;
        if (!password) {
            this.errors.set('password', 'Password is required');
            return false;
        }
        return true;
    }

    validateUsername() {
        const username = this.form.querySelector('#username').value;
        if (username.length < 3) {
            this.errors.set('username', 'Username must be at least 3 characters');
            return false;
        }
        return true;
    }

    validateEmail() {
        const email = this.form.querySelector('#email').value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            this.errors.set('email', 'Please enter a valid email address');
            return false;
        }
        return true;
    }

    validateRegistrationPassword() {
        const password = this.form.querySelector('#password').value;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.@$!%*?&])[A-Za-z\d.@$!%*?&]{12,}$/;
        if (!passwordRegex.test(password)) {
            this.errors.set('password', 'Password must be at least 12 characters, with uppercase, lowercase, a number and a special character');
            return false;
        }
        return true;
    }

    validatePasswordConfirmation() {
        const password = this.form.querySelector('#password').value;
        const confirmPassword = this.form.querySelector('#confirmPassword').value;
        if (password !== confirmPassword) {
            this.errors.set('confirmPassword', 'Passwords do not match');
            return false;
        }
        return true;
    }

    resetErrors() {
        this.errors.clear();
        const errorElements = this.form.querySelectorAll('.error');
        errorElements.forEach(element => {
            element.style.display = 'none';
            element.textContent = '';
        });
    }

    displayErrors() {
        this.errors.forEach((message, field) => {
            const errorElement = this.form.querySelector(`#${field}Error`);
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        });
    }
}


class FormSubmitter {
    constructor(form, validatorInstance) {
        this.form = form;
        this.validator = validatorInstance;
    }

    async submit() {
        if (this.validator && this.validator.validateForm()) { // Check validator and validate
            try {
                const formData = new FormData(this.form);
                const response = await fetch(this.form.action, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (!result.success) {
                    this.handleErrors(result.errors);
                    return false; // Very important: Return false to prevent further submission
                }

                this.handleSuccess();
                return true;

            } catch (error) {
                this.handleError('An error occurred during form submission');
                return false; // Prevent submission on error
            }
        }
        return false; // Return false if initial validation fails
    }


    handleErrors(errors) {
        if (errors && Array.isArray(errors)) {
            errors.forEach(error => {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = error;
                this.form.insertBefore(errorDiv, this.form.firstChild);
            });
        } else {
            console.error("Invalid errors format:", errors);
            this.handleError("An error occurred during form submission.");
        }
    }


    handleSuccess() {
        if (this.form.id === 'registrationForm') {
            window.location.href = 'login.php?registration=success';
        } else if (this.form.id === 'loginForm') {
          window.location.href = 'dashboard.php'; // Or wherever you redirect after login
        }
    }

    handleError(message) {
        console.error(message);
        // Display a generic error message to the user if needed.
        if (this.form) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            this.form.insertBefore(errorDiv, this.form.firstChild);
        }
    }
}


document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm'); // Get the login form element

    if (loginForm) { // Check if the login form exists
        const loginValidator = new FormValidator('loginForm');
        const loginSubmitter = new FormSubmitter(loginForm, loginValidator);

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            loginSubmitter.submit();
        });
    }

    const registrationForm = document.getElementById('registrationForm'); // Get the registration form

    if (registrationForm) { // Check if the registration form exists
        const registrationValidator = new FormValidator('registrationForm');
        const registrationSubmitter = new FormSubmitter(registrationForm, registrationValidator);

        registrationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            registrationSubmitter.submit();
        });
    }
});