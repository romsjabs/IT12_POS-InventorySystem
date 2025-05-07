/* upload product image */

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('real-product-image');
    const previewImage = document.getElementById('product-image');
    const uploadBtn = document.getElementById('product-image-upload');
    const enlargeImage = document.querySelector('.enlarge-image');

    uploadBtn.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    enlargeImage.addEventListener('click', () => {
        const imageSrc = previewImage.src;
        if (imageSrc) {
            window.open(imageSrc);
        }
    })
})

/* input price */

const moneyInput = document.getElementById('money');
let rawDigits = '';

moneyInput.addEventListener('input', function (e) {
    const numbersOnly = e.target.value.replace(/\D/g, '');
    rawDigits = numbersOnly;

    if (rawDigits.length === 0) {
        e.target.value = '₱ 0.00';
        return;
    }

    while (rawDigits.length < 3) {
        rawDigits = '0' + rawDigits;
    }

    const len = rawDigits.length;
    const cents = rawDigits.slice(len - 2);
    const whole = rawDigits.slice(0, len - 2);
    const formattedWhole = parseInt(whole, 10).toLocaleString();

    e.target.value = `₱ ${formattedWhole}.${cents}`;
});

moneyInput.addEventListener('keydown', function (e) {
    const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'];
    if (e.key.match(/[0-9]/) || allowedKeys.includes(e.key)) return;
    e.preventDefault();
});

/* fetch data for edit product */
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-product'); // All edit buttons
    const editForm = document.getElementById('edit-product-form'); // Edit form
    const modalError = document.getElementById('edit-modal-error'); // Error alert box
    const errorList = document.getElementById('edit-modal-error-list'); // Error list

    editButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const productId = button.getAttribute('data-id');
            const url = `/dashboard/products/${productId}`; // Adjust as per your route structure

            try {
                // Fetch product data
                const response = await fetch(url);
                const product = await response.json();

                if (response.ok) {
                    // Populate modal fields
                    editForm.action = `/dashboard/products/${product.id}`; // Form action for update
                    document.getElementById('edit-product-name').value = product.product_name;
                    document.getElementById('edit-product-id').value = product.product_sku_id;
                    document.getElementById('edit-product-category').value = product.product_category;
                    document.getElementById('edit-product-price').value = product.product_price;
                    document.getElementById('edit-product-stock').value = product.product_stock;
                    document.getElementById('edit-product-image').src = product.product_image_url || '{{ asset("assets/img/product_image.png") }}';
                } else {
                    throw new Error('Failed to fetch product data.');
                }
            } catch (error) {
                // Display error message
                modalError.classList.remove('d-none');
                errorList.innerHTML = `<li>${error.message}</li>`;
            }
        });
    });
});

/* edit and delete product */

document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.getElementById('editButton'); // Edit button
    const cancelButton = document.getElementById('cancelButton'); // Cancel button
    const actionColumns = document.querySelectorAll('.action-column'); // All action columns
    const actionButtons = document.querySelectorAll('.action-buttons'); // All action buttons

    // Initially hide all action buttons and the action column
    actionColumns.forEach(column => column.classList.add('d-none'));
    actionButtons.forEach(buttonGroup => buttonGroup.classList.add('d-none'));

    // Add click event to the Edit button
    editButton.addEventListener('click', () => {
        // Show action columns and buttons
        actionColumns.forEach(column => column.classList.remove('d-none'));
        actionButtons.forEach(buttonGroup => buttonGroup.classList.remove('d-none'));

        // Hide Edit button and show Cancel button
        editButton.classList.add('d-none');
        cancelButton.classList.remove('d-none');
    });

    // Add click event to the Cancel button
    cancelButton.addEventListener('click', () => {
        // Hide action columns and buttons
        actionColumns.forEach(column => column.classList.add('d-none'));
        actionButtons.forEach(buttonGroup => buttonGroup.classList.add('d-none'));

        // Show Edit button and hide Cancel button
        editButton.classList.remove('d-none');
        cancelButton.classList.add('d-none');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-product'); // Select all edit buttons
    const actionButtons = document.querySelectorAll('.action-buttons'); // Select all action buttons

    // Hide all action buttons initially
    actionButtons.forEach(buttonGroup => {
        buttonGroup.classList.add('d-none');
    });

    // Add click event to each edit button
    editButtons.forEach((editButton, index) => {
        editButton.addEventListener('click', function () {
            // Toggle action buttons for the corresponding row
            const actionButtonGroup = actionButtons[index];
            actionButtonGroup.classList.toggle('d-none');
        });
    });
});