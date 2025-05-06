document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const saveButton = document.getElementById('save-details');
    const inputs = form.querySelectorAll('input, textarea');
    const initialValues = {};

    // Store initial values
    inputs.forEach(input => {
        initialValues[input.name] = input.value;
    });

    function checkForChanges() {
        let changed = false;
        inputs.forEach(input => {
            if (input.value !== initialValues[input.name]) {
                changed = true;
            }
        });
        saveButton.disabled = !changed;
    }

    inputs.forEach(input => {
        input.addEventListener('input', checkForChanges);
    });
});
