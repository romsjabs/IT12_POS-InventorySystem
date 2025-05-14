


/* autofocus fields both new and edit modal */
document.addEventListener('DOMContentLoaded', () => {
    ['new-modal', 'edit-modal'].forEach(modalId => {
        const modalEl = document.getElementById(modalId);
        if (!modalEl) return;
        modalEl.addEventListener('shown.bs.modal', () => {
            const inputId = modalId === 'new-modal'
                ? 'add-product-name'
                : 'edit-product-name';
            const inputEl = document.getElementById(inputId);
            if (inputEl) inputEl.focus();
        });
    });
});



/* show input field if other category is selected */
document.addEventListener('DOMContentLoaded', () => {
    const setups = [
      { selId: 'add-product-category',  otherId: 'add-product-category-other' },
      { selId: 'edit-product-category', otherId: 'edit-product-category-other' }
    ];
  
    setups.forEach(({ selId, otherId }) => {
      const sel   = document.getElementById(selId);
      const other = document.getElementById(otherId);
      if (!sel || !other) return;
  
      // hide other by default, ensure names correct
      other.style.display = 'none';
      sel.name   = 'product_category';
      other.name = 'product_category_other';
  
      sel.addEventListener('change', () => {
        if (sel.value === 'other') {
          other.style.display = '';
          other.focus();
          // swap names
          other.name = 'product_category';
          sel.removeAttribute('name');
        } else {
          other.style.display = 'none';
          other.value = '';
          // swap back
          sel.name   = 'product_category';
          other.removeAttribute('name');
        }
      });
    });
});



/* upload image add and edit product */
document.addEventListener('DOMContentLoaded', function () {
    const setupImageUpload = (prefix) => {
        const fileInput = document.getElementById(`${prefix}-product-image`);
        const previewImage = document.getElementById(`${prefix}-product-image-preview`);
        const uploadBtn = document.getElementById(`${prefix}-product-image-upload`);
        const enlargeBtn = previewImage.parentElement.querySelector('.enlarge-image');

        if (uploadBtn && fileInput && previewImage) {
            uploadBtn.addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewImage.style.objectFit = 'cover';
                    };
                    reader.readAsDataURL(file);
                }

                trackChanges && trackChanges();
            });
        }

        if (enlargeBtn && previewImage) {
            enlargeBtn.addEventListener('click', () => {
                const imageSrc = previewImage.src;
                if (imageSrc) {
                    window.open(imageSrc, '_blank');
                }
            });
        }
    };

    // Initialize for both modals
    setupImageUpload('add');
    setupImageUpload('edit');
});



/* input price */

// Reusable function for formatting money inputs
function setupMoneyInput(inputElement) {
    let rawDigits = '';

    inputElement.addEventListener('input', function (e) {
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

    inputElement.addEventListener('keydown', function (e) {
        const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'];
        if (e.key.match(/[0-9]/) || allowedKeys.includes(e.key)) return;
        e.preventDefault();
    });

    // Optional: Set initial display format
    inputElement.value = '₱ 0.00';
}

// Setup for multiple fields
const moneyInputAdd = document.getElementById('add-product-price');
const moneyInputEdit = document.getElementById('edit-product-price');

// Apply formatter to each
if (moneyInputAdd) setupMoneyInput(moneyInputAdd);
if (moneyInputEdit) setupMoneyInput(moneyInputEdit);



/* edit modal data fetch */

document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-product');
    const editForm = document.getElementById('editProductForm');

    const productNameInput = document.getElementById('edit-product-name');
    const productCategoryInput = document.getElementById('edit-product-category');
    const productPriceInput = document.getElementById('edit-product-price');
    const productStockInput = document.getElementById('edit-product-stock');
    const productImagePreview = document.getElementById('edit-product-image-preview');
    const productImageInput = document.getElementById('edit-product-image');
    const productIdInput = document.getElementById('edit-product-id');
    const saveBtn = editForm.querySelector('button[type="submit"]'); // ✅ Save button reference

    let originalData = {}; // ✅ Store original data to compare changes

    // ✅ Track changes and enable/disable save button
    window.trackChanges = () => {
        const currentData = {
            name: productNameInput.value,
            category: productCategoryInput.value,
            price: productPriceInput.value,
            stock: productStockInput.value,
            image: productImageInput.files.length > 0
        };

        const hasChanged = Object.keys(currentData).some(key => {
            if (key === 'imageChanged') return currentData.image;
            return currentData[key] !== originalData[key];
        });

        saveBtn.disabled = !hasChanged;
        saveBtn.classList.toggle('disabled', !hasChanged);
    };

    // ✅ Attach listeners to track input changes
    [productNameInput, productCategoryInput, productPriceInput, productStockInput].forEach(input => {
        input.addEventListener('input', trackChanges);
    });

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Get data attributes from the clicked button
            const productId = button.getAttribute('data-id');
            const productCode = button.getAttribute('data-productid');
            const productName = button.getAttribute('data-name');
            const productCategory = button.getAttribute('data-category');
            const productPrice = button.getAttribute('data-price');
            const productStock = button.getAttribute('data-stock');
            const productImage = button.getAttribute('data-image');

            // Populate the modal fields with the product data
            productIdInput.value = productCode;
            productNameInput.value = productName;
            productCategoryInput.value = productCategory;
            productPriceInput.value = productPrice;
            productStockInput.value = productStock;

            // ✅ Store original data for comparison
            originalData = {
                name: productName,
                category: productCategory,
                price: productPrice,
                stock: productStock
            };

            // ✅ Reset file input so change detection works
            productImageInput.value = '';

            // ✅ Reset save button state
            saveBtn.disabled = true;
            saveBtn.classList.add('disabled');

            // Update the image preview
            productImagePreview.src = productImage || '/path/to/default/image.png';

            // Update the form action dynamically
            editForm.action = `/dashboard/products/${productId}/update`;
            console.log('Form action set to:', editForm.action);
        });
    });
});



/* edit product */

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



/* delete product */

document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-product');
    const deleteModal = document.getElementById('deleteModal');
    const deleteProductName = document.getElementById('delete-product-name');
    const deleteProductForm = document.getElementById('deleteProductForm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');

            // Update the modal content
            deleteProductName.textContent = productName;

            // Update the form action dynamically
            deleteProductForm.action = `/dashboard/products/${productId}/delete`;
        });
    });
});