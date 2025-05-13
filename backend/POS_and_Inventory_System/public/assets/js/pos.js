// --- Real-time clock ---
function updateDateTime() {
    const now = new Date();
    const day = now.toLocaleDateString('en-US', { weekday: 'short' });
    const date = now.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    const time = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

    document.getElementById("current-date").textContent = `${date} (${day})`;
    document.getElementById("current-time").textContent = time;
}
setInterval(updateDateTime, 1000);
updateDateTime();

// --- Fetch Transaction ID ---
function fetchTransactionRef() {
    fetch('/pos/cashier/transaction-id')
        .then(response => response.json())
        .then(data => {
            const refElem = document.getElementById('transaction-ref');
            if (refElem) {
                refElem.textContent = data.transaction_id; // Update the transaction reference
            }
        })
        .catch(error => {
            console.error('Error fetching transaction ID:', error);
        });
}

// Call fetchTransactionRef on page load
document.addEventListener('DOMContentLoaded', fetchTransactionRef);

// --- Calculate and Update Totals ---
function updateTotals() {
    let subtotal = 0;

    // Calculate subtotal
    for (const id in orders) {
        const item = orders[id];
        subtotal += item.price * item.quantity;
    }

    // Update subtotal
    const subtotalElem = document.getElementById('subtotal-value');
    if (subtotalElem) {
        subtotalElem.textContent = `₱ ${subtotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    // Apply discount (if any)
    const discount = 0; // Add logic for discounts if needed
    const discountElem = document.getElementById('discount-value');
    if (discountElem) {
        discountElem.textContent = `₱ ${discount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    // Calculate grand total
    const grandTotal = subtotal - discount;
    const grandTotalElem = document.getElementById('grand-total-value');
    if (grandTotalElem) {
        grandTotalElem.textContent = `₱ ${grandTotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }
}

// --- Filter Products ---
function filterProducts(categoryId) {
    const allProducts = document.querySelectorAll('.items-wrapper .item');

    allProducts.forEach(product => {
        const productCategoryId = product.getAttribute('data-category-id');

        // Show or hide products based on the selected category
        if (categoryId === 'all' || productCategoryId === categoryId) {
            product.style.display = 'block'; // Show the product
        } else {
            product.style.display = 'none'; // Hide the product
        }
    });

    // Highlight the selected category button
    const categoryButtons = document.querySelectorAll('.item-buttons .item-button');
    categoryButtons.forEach(button => button.classList.remove('active'));
    const activeButton = document.querySelector(`.item-button[data-category-id="${categoryId}"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

// --- Orders and Cash Input ---
let orders = {};
let cashInput = "";

// --- UI Update Functions ---
function updateCashScreen() {
    const screen = document.getElementById('cash-screen');
    if (screen) {
        screen.textContent = cashInput
            ? `₱ ${parseFloat(cashInput).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
            : "₱ 0.00";
    }
    // Always hide change tab when editing cash
    const changeTab = document.getElementById('change-tab');
    if (changeTab) changeTab.style.display = "none";
}

// --- Numpad and Keyboard Input ---
function addDigit(digit) {
    if (cashInput.length >= 9) return;
    if (digit === '.' && cashInput.includes('.')) return;
    cashInput += digit;
    updateCashScreen();
}

function clearCashInput() {
    cashInput = "";
    updateCashScreen();
}

document.addEventListener('keydown', function (e) {
    if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') return;
    if (e.key >= '0' && e.key <= '9') {
        addDigit(e.key);
    } else if (e.key === '.' && !cashInput.includes('.')) {
        addDigit('.');
    } else if (e.key === 'Backspace') {
        cashInput = cashInput.slice(0, -1);
        updateCashScreen();
    } else if (e.key === 'Enter') {
        startCheckout();
    }
});

// --- Orders Table Management ---
function addToOrder(productId) {
    if (orders[productId]) {
        alert('Product already in the orders table.');
        return;
    }

    fetch(`/pos/cashier/product/${productId}`)
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch product details.');
            return response.json();
        })
        .then(product => {
            if (product.stock <= 0) {
                alert("Product is not available.");
                return;
            }

            orders[productId] = {
                id: product.id,
                product_id: product.product_id,
                name: product.name,
                price: product.price,
                quantity: 1,
                stock: product.stock
            };

            const tableBody = document.querySelector('#orders-table tbody');
            const row = document.createElement('tr');
            row.setAttribute('data-id', product.id);
            row.innerHTML = `
                <td>${product.product_id}</td>
                <td>${product.name}</td>
                <td>
                    <div class="qty">
                        <button class="qty-btn btn btn-secondary btn-sm" onclick="updateQuantity(${product.id}, -1)">-</button>
                        <span>${orders[product.id].quantity}</span>
                        <button class="qty-btn btn btn-secondary btn-sm" onclick="updateQuantity(${product.id}, 1)">+</button>
                    </div>
                </td>
                <td>₱ ${product.price.toFixed(2)}</td>
                <td>₱ ${(product.price * orders[product.id].quantity).toFixed(2)}</td>
                <td>
                    <button class="delete-btn btn btn-danger btn-sm" onclick="removeFromOrder(${product.id})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);

            updateTotals(); // Update totals after adding a product
        })
        .catch(error => {
            console.error('Error fetching product:', error);
            alert('Failed to fetch product details. Please try again.');
        });
}

function updateQuantity(productId, change) {
    const item = orders[productId];
    if (!item) return;

    const newQuantity = item.quantity + change;
    if (newQuantity > item.stock) {
        alert('You have reached the maximum stock limit.');
        return;
    }
    if (newQuantity < 1) {
        removeFromOrder(productId);
        return;
    }

    item.quantity = newQuantity;

    const row = document.querySelector(`#orders-table tbody tr[data-id="${productId}"]`);
    row.querySelector('.qty span').textContent = item.quantity;
    row.querySelector('td:nth-child(5)').textContent = `₱ ${(item.price * item.quantity).toFixed(2)}`;

    updateTotals(); // Update totals after changing quantity
}

function removeFromOrder(productId) {
    delete orders[productId];
    const row = document.querySelector(`#orders-table tbody tr[data-id="${productId}"]`);
    if (row) row.remove();

    updateTotals(); // Update totals after removing a product
}

// --- Sync Orders to Backend Cart ---
async function syncOrdersToCart() {
    // Clear backend cart first to avoid duplicate/old items
    await fetch('/pos/cashier/clear-cart', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    // Now sync current orders
    for (const id in orders) {
        const item = orders[id];
        await fetch('/pos/cashier/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                id: item.id,
                quantity: item.quantity
            })
        });
    }
}

let transactionComplete = false; // Add this at the top of your file or before startCheckout

async function startCheckout() {
    if (transactionComplete) {
        transactionComplete = false;
        orders = {};
        document.querySelector('#orders-table tbody').innerHTML = '';
        cashInput = "";
        updateCashScreen();
        updateTotals();
        // Restore grand total label and value
        const grandLabel = document.getElementById('grand-label');
        if (grandLabel) grandLabel.textContent = "Grand Total:";
        const grandTotalElem = document.getElementById('grand-total-value');
        if (grandTotalElem) grandTotalElem.textContent = "₱ 0.00";
        // Hide the change tab
        const changeTab = document.getElementById('change-tab');
        if (changeTab) changeTab.style.display = "none";
        fetchTransactionRef();
        return;
    }

    if (Object.keys(orders).length === 0) {
        alert('Cart is empty.');
        return;
    }

    let cash = parseFloat(cashInput);
    if (isNaN(cash) || cash <= 0) {
        alert("Please enter a valid cash amount.");
        return;
    }

    await syncOrdersToCart();

    fetch('/pos/cashier/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ cash: cash })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Only swap the grand total label and value to show change
            const grandLabel = document.getElementById('grand-label');
            if (grandLabel) grandLabel.textContent = "Change:";
            const grandTotalElem = document.getElementById('grand-total-value');
            if (grandTotalElem) grandTotalElem.textContent = `₱ ${parseFloat(data.change).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            // Do NOT show the old change tab anymore
            transactionComplete = true;
        } else if (data.error) {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error('Checkout error:', error);
        alert('Checkout failed.');
    });
}