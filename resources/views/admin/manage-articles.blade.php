@include('layouts.adminheader')
<link rel="stylesheet" href="{{ asset('css/admin/articles.css') }}">
<!-- Manage Articles Section -->
<section id="manage-articles">
    <h2>Manage Articles</h2>
    <div class="articles-controls">
        <label for="themeFilter">Filter by Theme:</label>
        <select id="themeFilter">
            <option value="all">All Themes</option>
            @foreach ($themes as $theme)
            <option value="{{ $theme->id }}">{{ $theme->name }}</option>
            @endforeach
        </select>

        <label for="statusFilter">Filter by Status:</label>
        <select id="statusFilter">
            <option value="all">All Statuses</option>
            <option value="published">Published</option>
            <option value="pending">Pending</option>
        </select>
    </div>
    <!-- Modal for selecting an issue -->
    <div id="issueModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Select an Issue</h2>
            <select id="issueSelect">
                @foreach ($issues as $issue)
                <option value="{{ $issue->id }}">{{ $issue->name }}</option>
                @endforeach
            </select>
            <button id="assignIssueBtn">Assign</button>
        </div>
    </div>

    <table class="articles-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Theme</th>
                <th>Published Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="articlesTableBody">
            @foreach ($articles as $article)
            <tr data-id="{{ $article->id }}" data-theme="{{ $article->theme->id }}" data-status="{{ $article->status }}">
                <td>{{ $article->title }}</td>
                <td>{{ $article->theme->name }}</td>
                <td>{{ $article->published_date }}</td>
                <td class="status">{{ $article->status }}</td>
                <td class="actions">
                    <a href="{{ route('articles.show', $article->id) }}" class="view-btn" data-id="{{ $article->id }}">View</a>
                    <button class="switch-status-btn" data-id="{{ $article->id }}">
                        {{ $article->status === 'published' ? 'Deactivate' : 'Activate' }}
                    </button>
                    <button class="remove-btn" data-id="{{ $article->id }}">Remove</button>
                    <button class="assign-issue-btn" data-id="{{ $article->id }}">Assign to Issue</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<


    <!-- Hidden forms for actions -->
    <form id="switch-status-form" method="POST" action="">
        @csrf
        <input type="hidden" name="article_id" id="switch-status-article-id">
    </form>

    <form id="remove-form" method="POST" action="">
        @csrf
        <input type="hidden" name="article_id" id="remove-article-id">

    </form>
    <form id="assign-issue-form" method="POST" action="{{ route('articles.assignIssue') }}">
        @csrf
        <input type="hidden" name="article_id" id="assign-issue-article-id">
        <input type="hidden" name="issue_id" id="assign-issue-id">
    </form>
    <!-- Ensure CSRF token is included -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="{{ asset('js/admin/manage-article.js') }}"></script>

    </body>

    </html>