
// show modal
    function showModal() {
        document.getElementById('themeModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('themeModal').style.display = 'none';
    }
// filter themes
    function filterThemes() {
        const filter = document.getElementById('theme-status-filter').value;
        const rows = document.querySelectorAll('#themes-tbody tr');
        rows.forEach(row => {
            if (filter === 'all' || row.dataset.status === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
