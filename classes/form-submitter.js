class FormSubmitter {
    constructor(form, validatorInstance) {
        this.form = form;
        this.validator = validatorInstance;
    }

    async submit() {
        if (this.validator && this.validator.validateForm()) {
            try {
                const formData = new FormData(this.form);
                const response = await fetch(this.form.action, {
                    method: 'POST',
                    body: formData
                });
    
                console.log('Server response:', await response.clone().text());
    
                const result = await response.json();
                
                console.log('Parsed result:', result);
    
                if (!result.success) {
                    this.handleErrors(result.errors);
                    return false;
                }
    
                this.handleSuccess();
                return true;
    
            } catch (error) {
                console.error('Submission error:', error);
                this.handleError('An error occurred during form submission');
                return false;
            }
        }
        return false;
    }

    handleErrors(errors) {

        const existingErrors = this.form.querySelectorAll('.error-message');
        existingErrors.forEach(error => error.remove());
    
        if (errors && Array.isArray(errors)) {
            errors.forEach(error => {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = error;
                this.form.insertBefore(errorDiv, this.form.firstChild);
            });
        } else if (typeof errors === 'string') {

            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = errors;
            this.form.insertBefore(errorDiv, this.form.firstChild);
        } else {
            console.error("Invalid errors format:", errors);
            this.handleError("Une erreur est survenue lors de la soumission du formulaire.");
        }
    }


    handleSuccess() {
        if (this.form.id === 'registrationForm') {
            window.location.href = 'login.php?registration=success';
        } else if (this.form.id === 'loginForm') {
          window.location.href = 'dashboard.php';
        }
    }

    handleError(message) {
        console.error(message);

        if (this.form) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            this.form.insertBefore(errorDiv, this.form.firstChild);
        }
    }
}

export default FormSubmitter;