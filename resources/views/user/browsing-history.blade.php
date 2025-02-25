@include('layouts.userheader')
<link rel="stylesheet" href="{{ asset('css/user/history.css') }}">
<section id="browsing-history">
    <h1>Browsing History</h1>

    <div class="filters">

        <label for="filter-themes">Filter by Theme:</label>
        <select id="filter-themes">
            <option value="all">All themes</option>
            @foreach($themes as $theme)
                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
            @endforeach
        </select>

        <label for="filter-date">Filter by Date:</label>
        <select id="filter-date">
            <option value="all">All Dates</option>
            <option value="today">today</option>
            <option value="yesterday">yesterday</option>
            <option value="last-week">last-week</option>
            <option value="last-month">last-month</option>
        </select>
    </div>

    <table class="history-table">
        <thead>
            <tr>
                <th>Article Title</th>
                <th>Themes</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="history-list">
            @if(isset($history) && count($history) > 0)
                @foreach($history as $entry)
                    <tr data-theme="{{ $entry->article->theme ? $entry->article->theme->id : 'none' }}" data-date="{{ $entry->accessed_at->format('Y-m-d') }}">
                        <td>{{ $entry->article->title }}</td>
                        <td>{{ $entry->article->theme ? $entry->article->theme->name : 'Aucun thème' }}</td>
                        <td>{{ $entry->article->status }}</td>
                        <td>{{ $entry->accessed_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No browsing history available at this time.</td>
                </tr>
            @endif
        </tbody>
    </table>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterThemes = document.getElementById('filter-themes');
        const filterDate = document.getElementById('filter-date');
        const historyTableBody = document.getElementById('history-list');
        const historyRows = historyTableBody.getElementsByTagName('tr');

        filterThemes.addEventListener('change', filterHistory);
        filterDate.addEventListener('change', filterHistory);

        function filterHistory() {
            const selectedTheme = filterThemes.value;
            const selectedDate = filterDate.value;

            for (let row of historyRows) {
                const theme = row.getAttribute('data-theme');
                const date = row.getAttribute('data-date');

                const matchesTheme = (selectedTheme === 'all' || selectedTheme === theme);
                const matchesDate = (selectedDate === 'all' || selectedDate === date);

                row.style.display = (matchesTheme && matchesDate) ? '' : 'none';
            }
        }

        // Update the filter display text on page load
        updateFilterDisplay();

        function updateFilterDisplay() {
            const urlParams = new URLSearchParams(window.location.search);
            const themeId = urlParams.get('theme');
            const dateFilter = urlParams.get('date');

            if (themeId && themeId !== "all") {
                filterThemes.value = themeId;
            } else {
                filterThemes.value = "all";
            }

            if (dateFilter && dateFilter !== "all") {
                filterDate.value = dateFilter;
            } else {
                filterDate.value = "all";
            }
        }
    });
</script>
</body>
</html>
