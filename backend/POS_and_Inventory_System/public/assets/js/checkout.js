document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('products-search');
    const tableBody = document.getElementById('checkouts-table-body');
    const noResults = document.getElementById('no-results');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();
        let visibleRows = 0;

        tableBody.querySelectorAll('tr.checkout-row').forEach(function (row) {
            // Get all cells except the last one (action buttons)
            const cells = Array.from(row.querySelectorAll('td')).slice(0, -1);
            const rowText = cells.map(td => td.textContent.toLowerCase()).join(' ');
            if (rowText.includes(filter)) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide "No results" row
        if (visibleRows === 0) {
            noResults.style.display = '';
        } else {
            noResults.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-transaction').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var transactionId = this.getAttribute('data-transaction');
            var loading = document.getElementById('transaction-details-loading');
            var content = document.getElementById('transaction-details-content');
            loading.style.display = 'block';
            content.innerHTML = '';
            fetch(`/dashboard/checkouts/transaction/${transactionId}`)
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    if (data.error) {
                        content.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    } else {
                        let itemsHtml = '';
                        data.items.forEach(item => {
                            itemsHtml += `
                                <tr>
                                    <td>${item.product_name}</td>
                                    <td>x${item.quantity}</td>
                                    <td>₱${parseFloat(item.total_price).toFixed(2)}</td>
                                </tr>
                            `;
                        });
                        content.innerHTML = `
                            <p><strong>Transaction ID:</strong> ${data.transaction_id}</p>
                            <p><strong>Date/Time:</strong> ${data.created_at}</p>
                            <p><strong>Cashier:</strong> ${data.cashier}</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end"><strong>Grand Total:</strong></td>
                                        <td><strong>₱${parseFloat(data.grand_total).toFixed(2)}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        `;
                    }
                })
                .catch(() => {
                    loading.style.display = 'none';
                    content.innerHTML = `<div class="alert alert-danger">Failed to load transaction details.</div>`;
                });
        });
    });
});