// --- State ---
let isCartEmpty = true;

// --- Cart Fetch & Render ---
function fetchCustomerCart() {
    return fetch('/pos/customer/current-cart')
        .then(response => response.json())
        .then(cart => {
            const tbody = document.querySelector('.products-list tbody');
            if (tbody) {
                tbody.innerHTML = '';
                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    tbody.innerHTML += `
                        <tr>
                            <td>${item.product_id}</td>
                            <td>
                                <span>
                                    <img src="${item.image}" alt="Product Image" style="object-fit: cover;" width="40" height="40">
                                </span>
                                <span>${item.name}</span>
                            </td>
                            <td>x ${item.quantity}</td>
                            <td>₱ ${parseFloat(item.price).toFixed(2)}</td>
                            <td>₱ ${itemTotal.toFixed(2)}</td>
                        </tr>
                    `;
                });
                isCartEmpty = cart.length === 0;
                return isCartEmpty;
            }
            isCartEmpty = true;
            return true;
        });
}

// --- Product View ---
function updateProductView() {
    fetch('/pos/customer/update-product-view')
        .then(response => response.json())
        .then(cart => {
            const currentItem = document.getElementById('customer-product-details');
            const welcomeCustomer = document.getElementById('welcome-customer');
            currentItem.innerHTML = '';
            if (cart.length > 0) {
                if (welcomeCustomer) welcomeCustomer.classList.add('d-none');
                if (currentItem) currentItem.classList.remove('d-none');
                const item = cart[cart.length - 1];
                const itemTotal = item.price * item.quantity;
                currentItem.innerHTML = `
                    <div class="item-container1">
                        <span>
                            <h3>${item.name}</h3>
                            <h4>${item.product_id}</h4>
                        </span>
                        <div class="item-price">
                            <span class="sub-item-price">
                                <h3>₱ ${parseFloat(item.price).toFixed(2)}</h3>
                                <h4>x ${item.quantity}</h4>
                            </span>
                            <span class="total-item-price">
                                <h2>₱ ${itemTotal.toFixed(2)}</h2>
                            </span>
                        </div>
                    </div>
                    <div class="item-container2">
                        <img id="current-product-image2" src="${item.image}" alt="Product Image" width="150">
                    </div>
                `;
            } else {
                if (welcomeCustomer) welcomeCustomer.classList.remove('d-none');
                if (currentItem) currentItem.classList.add('d-none');
            }
        });
}

// --- Checkout Details ---
function fetchCheckoutDetails() {
    fetch('/pos/customer/current-amount')
        .then(response => response.json())
        .then(data => {
            const checkout1 = document.getElementById('checkout1');
            if (checkout1) {
                checkout1.innerHTML = `
                    <div class="subtotal">
                        <span><h4>Subtotal:</h4></span>
                        <span class="amount"><h4>₱ ${parseFloat(data.subtotal).toFixed(2)}</h4></span>
                    </div>
                    <div class="discount">
                        <span><h4>Discount:</h4></span>
                        <span class="amount"><h4>₱ ${parseFloat(data.discount).toFixed(2)}</h4></span>
                    </div>
                    <div class="total">
                        <span><h2>Total:</h2></span>
                        <span class="amount"><h2>₱ ${parseFloat(data.total).toFixed(2)}</h2></span>
                    </div>
                `;
            }
        });
}

// --- Change Details & Checkout Visibility ---
function updateCheckoutVisibility() {
    const checkout1 = document.getElementById('checkout1');
    const checkout2 = document.getElementById('checkout2');

    if (isCartEmpty) {
        if (checkout1) checkout1.classList.add('d-none');
        if (checkout2) checkout2.classList.add('d-none');
        return;
    }

    // Always show checkout1 by default
    if (checkout1) checkout1.classList.remove('d-none');
    if (checkout2) checkout2.classList.add('d-none');

    // Check if transaction is complete (show_change)
    fetch('/pos/customer/change-amount')
        .then(response => response.json())
        .then(data => {
            if (data.show_change) {
                if (checkout1) checkout1.classList.add('d-none');
                if (checkout2) {
                    checkout2.classList.remove('d-none');
                    checkout2.classList.add('d-block');
                    checkout2.innerHTML = `
                        <div class="amount-given">
                            <span><h5>Amount Given:</h5></span>
                            <span class="amount"><h5>₱ ${parseFloat(data.amount_given).toFixed(2)}</h5></span>
                        </div>
                        <div class="change">
                            <span><h3>Change:</h3></span>
                            <span class="amount"><h3>₱ ${parseFloat(data.change).toFixed(2)}</h3></span>
                        </div>
                    `;
                }
            }
        });
}

// --- Main Loop ---
setInterval(() => {
    fetchCustomerCart().then(() => {
        updateProductView();
        fetchCheckoutDetails();
        updateCheckoutVisibility();
    });
}, 1000);

// --- Initial State ---
fetchCustomerCart().then(() => {
    updateProductView();
    fetchCheckoutDetails();
    updateCheckoutVisibility();
});