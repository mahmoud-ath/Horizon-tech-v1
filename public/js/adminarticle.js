document.addEventListener("DOMContentLoaded", function () {

    // Cache DOM elements
    const themeFilter = document.getElementById('themeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const articlesTableBody = document.getElementById('articlesTableBody');
    const articleRows = articlesTableBody.getElementsByTagName('tr');
    
    // Event listeners for filters
    themeFilter.addEventListener('change', filterArticles);
    statusFilter.addEventListener('change', filterArticles);

    // Filter articles based on theme and status
    function filterArticles() {
        const selectedTheme = themeFilter.value;
        const selectedStatus = statusFilter.value;

        for (let row of articleRows) {
            const theme = row.getAttribute('data-theme');
            const status = row.getAttribute('data-status');

            const matchesTheme = (selectedTheme === 'all' || selectedTheme === theme);
            const matchesStatus = (selectedStatus === 'all' || selectedStatus === status);

            // Show or hide the row based on filter criteria
            row.style.display = (matchesTheme && matchesStatus) ? '' : 'none';
        }
    }

    // Update article status (Activate/Deactivate)
    function updateArticleStatus(articleId, newStatus) {
        fetch('/articles/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id: articleId, status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`tr[data-id='${articleId}']`);
                updateRowStatus(row, newStatus);
            } else {
                alert("Error while updating.");
            }
        });
    }

    // Remove article and update table
    function removeArticle(articleId) {
        if (!confirm("Are you sure you want to remove this article?")) return;

        fetch('/articles/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id: articleId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`tr[data-id='${articleId}']`);
                row.remove();
            } else {
                alert("Erreur lors de la suppression.");
            }
        });
    }

    // Helper function to update row status
    function updateRowStatus(row, newStatus) {
        row.querySelector(".status").textContent = newStatus;
        row.querySelector(".activate-btn").classList.toggle("hidden", newStatus === "Published");
        row.querySelector(".deactivate-btn").classList.toggle("hidden", newStatus === "Pending");
    }

    // Event listeners for action buttons (Activate, Deactivate, Remove)
    function addActionListeners() {
        document.querySelectorAll(".activate-btn").forEach(button => {
            button.addEventListener("click", () => updateArticleStatus(button.dataset.id, "Published"));
        });

        document.querySelectorAll(".deactivate-btn").forEach(button => {
            button.addEventListener("click", () => updateArticleStatus(button.dataset.id, "Pending"));
        });

        document.querySelectorAll(".remove-btn").forEach(button => {
            button.addEventListener("click", () => removeArticle(button.dataset.id));
        });
    }

    // Initialize action listeners
    addActionListeners();

});
