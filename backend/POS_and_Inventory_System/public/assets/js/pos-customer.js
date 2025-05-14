function fetchCustomerCart() {
    fetch('/pos/customer/current-cart')
        .then(response => response.json())
        .then(cart => {
            // Update products table
            const tbody = document.querySelector('.products-list tbody');
            tbody.innerHTML = '';
            let subtotal = 0;
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                tbody.innerHTML += `
                    <tr>
                        <td>${item.product_id}</td>
                        <td>
                            <span>
                                <img src="${item.image}" alt="Product Image" style="object-fit: cover;" width="50" height="40">
                            </span>
                            <span>${item.name}</span>
                        </td>
                        <td>x ${item.quantity}</td>
                        <td>₱ ${parseFloat(item.price).toFixed(2)}</td>
                        <td>₱ ${itemTotal.toFixed(2)}</td>
                    </tr>
                `;
            }); 
        });
}
setInterval(fetchCustomerCart, 1000);
fetchCustomerCart();