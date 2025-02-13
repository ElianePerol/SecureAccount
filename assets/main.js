import FormValidator from './FormValidator.js';
import FormSubmitter from './FormSubmitter.js';

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        const loginValidator = new FormValidator('loginForm');
        const loginSubmitter = new FormSubmitter(loginForm, loginValidator);

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            loginSubmitter.submit();
        });
    }

    const registrationForm = document.getElementById('registrationForm');

    if (registrationForm) {
        const registrationValidator = new FormValidator('registrationForm');
        const registrationSubmitter = new FormSubmitter(registrationForm, registrationValidator);

        registrationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            registrationSubmitter.submit();
        });
    }
});