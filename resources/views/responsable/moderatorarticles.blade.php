@include('layouts.moderatorheader')
<link rel="stylesheet" href="{{ asset('css/moderator/articles.css') }}">
<!-- Manage Articles Section -->
<section id="articles">
    <h1>Manage Articles</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="articles-table">
        <h2>All Articles</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Theme</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="articles-list">
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->theme->name }}</td>
                        <td>{{ $article->status }}</td>
                        <td>
                            <a href="{{ route('moderator.articles.show', $article->id) }}" class="view-btn" data-id="{{ $article->id }}">View</a>
                            <form action="{{ route('moderator.articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" data-id="{{ $article->id }}">Delete</button>
                            </form>
                            <form action="{{ route('moderator.articles.publish', $article->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="publish-btn" data-id="{{ $article->id }}">Publish</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<script src="{{ asset('js/moderator/articles.js') }}"></script>
</body>
</html>
