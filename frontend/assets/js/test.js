const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("#tableBody tr");
    const noResults = document.getElementById("noResults");

    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      let visibleCount = 0;

      tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isMatch = text.includes(filter);
        row.style.display = isMatch ? "" : "none";
        if (isMatch) visibleCount++;
      });

      noResults.style.display = visibleCount === 0 ? "" : "none";
    });