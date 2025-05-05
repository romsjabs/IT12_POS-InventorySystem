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

    // Pad with leading zeros
    while (rawDigits.length < 3) {
        rawDigits = '0' + rawDigits;
    }

    const len = rawDigits.length;
    const cents = rawDigits.slice(len - 2);
    const whole = rawDigits.slice(0, len - 2);

    // Format with commas
    const formattedWhole = parseInt(whole, 10).toLocaleString();
    e.target.value = `₱ ${formattedWhole}.${cents}`;
    });

    // Optional: prevent typing non-numeric chars
    moneyInput.addEventListener('keydown', function (e) {
    const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'];
    if (e.key.match(/[0-9]/) || allowedKeys.includes(e.key)) return;
    e.preventDefault();
    });
