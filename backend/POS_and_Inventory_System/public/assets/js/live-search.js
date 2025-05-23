document.addEventListener('DOMContentLoaded', function () {
    // Helper: get searchable text from row (exclude action columns)
    function getSearchableText(row) {
        return Array.from(row.cells)
            .filter(cell => !cell.classList.contains('action-column'))
            .map(cell => cell.textContent.toLowerCase())
            .join(' ');
    }

    // Generic live search function
    function setupLiveSearch(searchId, tableBodyId, noResultsId) {
        const searchInput = document.getElementById(searchId);
        const tableBody = document.getElementById(tableBodyId);
        const noResultsRow = document.getElementById(noResultsId);

        if (searchInput && tableBody) {
            searchInput.addEventListener('input', function () {
                const filter = searchInput.value.toLowerCase();
                let visible = 0;
                tableBody.querySelectorAll('tr').forEach(row => {
                    if (row.id === noResultsId) return;
                    const text = getSearchableText(row);
                    const match = text.includes(filter);
                    row.style.display = match ? '' : 'none';
                    if (match) visible++;
                });
                if (noResultsRow) {
                    noResultsRow.style.display = visible === 0 ? '' : 'none';
                }
            });
        }
    }

    // Setup live search for each table
    setupLiveSearch('products-search', 'products-table-body', 'products-no-results');
    setupLiveSearch('checkouts-search', 'checkouts-table-body', 'checkouts-no-results');
    setupLiveSearch('users-search', 'users-table-body', 'users-no-results');
    setupLiveSearch('sales-search', 'sales-table-body', 'sales-no-results');
});