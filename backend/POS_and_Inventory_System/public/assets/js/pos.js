// real-time clock
function updateDateTime() {
    const now = new Date();

    const day = now.toLocaleDateString('en-US', { weekday: 'short' }); // "Wed"
    const date = now.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }); // "April 9, 2025"
    const time = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true }); // "12:00 PM"

    document.getElementById("current-date").textContent = `${date} (${day})`;
    document.getElementById("current-time").textContent = time;
  }

  setInterval(updateDateTime, 1000);
  updateDateTime();

// orders
let orders = {};

// Add product to orders table
function addToOrder(productId) {
    if (orders[productId]) {
        alert('Product already in the orders table.');
        return;
    }

    // Fetch product details via AJAX
    fetch(`/pos/cashier/product/${productId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch product details.');
            }
            return response.json();
        })
        .then(product => {
            console.log('Fetched product:', product); // Debugging log

            if (product.stock <= 0) {
                alert("Gi-ingna'g dili available. Samok!");
                return;
            }

            orders[productId] = {
                id: product.id,
                sku: product.sku,
                name: product.name,
                price: product.price,
                quantity: 1,
                stock: product.stock
            };

            const tableBody = document.querySelector('#orders-table tbody');
            const row = document.createElement('tr');
            row.setAttribute('data-id', product.id);
            row.innerHTML = `
                <td>${product.sku}</td>
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
        })
        .catch(error => {
            console.error('Error fetching product:', error);
            alert('Failed to fetch product details. Please try again.');
        });
}

// Update quantity
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
}

// Remove product from orders table
function removeFromOrder(productId) {
    delete orders[productId];

    const row = document.querySelector(`#orders-table tbody tr[data-id="${productId}"]`);
    row.remove();
}