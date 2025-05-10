/* live search product */
const searchInput = document.getElementById('products-search');
const tableRows = document.querySelectorAll('#products-table-body tr');
const noResults = document.getElementById('no-results');

searchInput.addEventListener("input", function() {
    const filter = searchInput.value.toLowerCase();
    let visibleCount = 0;

    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isMatch = text.includes(filter);
        row.style.display = isMatch ? "" : "none";
        if (isMatch) visibleCount++;
    });

    noResults.style.display = visibleCount === 0 ? "" : "none";
})