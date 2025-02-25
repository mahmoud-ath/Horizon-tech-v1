document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const suggestions = document.getElementById('suggestions');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value;
        if (query.length > 2) {
            fetchSuggestions(query);
        } else {
            suggestions.style.display = 'none';
        }
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('suggestion-item')) {
            const id = event.target.getAttribute('data-id');
            const themeId = event.target.getAttribute('data-theme-id');
            window.location.href = `/themes/${themeId}/articles/${id}`;
        }
    });

    async function fetchSuggestions(query) {
        try {
            const response = await fetch(`/search/suggestions?query=${query}`);
            const data = await response.json();
            displaySuggestions(data);
        } catch (error) {
            console.error('Error fetching suggestions:', error);
        }
    }

    function displaySuggestions(data) {
        suggestions.innerHTML = '';
        if (data.length > 0) {
            data.forEach(function(item) {
                const div = document.createElement('div');
                div.classList.add('suggestion-item');
                div.setAttribute('data-id', item.id);
                div.setAttribute('data-theme-id', item.theme_id);
                div.textContent = item.title;
                suggestions.appendChild(div);
            });
            suggestions.style.display = 'block';
        } else {
            suggestions.style.display = 'none';
        }
    }
});
