class FormValidator {
    constructor(formId) {
        this.form = document.getElementById(formId);
        if (!this.form) {
            console.error(`Form with ID '${formId}' not found!`);
            return;
        }
        this.errors = new Map();
    
        this.validateForm = this.validateForm.bind(this);
        this.resetErrors = this.resetErrors.bind(this);
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

export default FormValidator;