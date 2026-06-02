document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.js-validate-form');

    forms.forEach((form) => {
        const messageBox = form.querySelector('.js-form-message');

        form.addEventListener('submit', (event) => {
            const requiredFields = form.querySelectorAll('[required]');
            const missingFields = [];

            requiredFields.forEach((field) => {
                const value = String(field.value || '').trim();
                const label = field.dataset.label || field.getAttribute('name') || 'Pole';

                if (value === '') {
                    missingFields.push(label);
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (missingFields.length > 0) {
                event.preventDefault();

                if (messageBox) {
                    messageBox.className = 'form-message js-form-message is-error';
                    messageBox.textContent = 'Uzupełnij wymagane pola: ' + missingFields.join(', ') + '.';
                }

                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });
    });
});
