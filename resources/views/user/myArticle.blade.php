@include('layouts.userheader')
<link rel="stylesheet" href="{{ asset('css/user/myarticle.css') }}">
<section id="my-articles">
    <h1>My Articles</h1>

    @if($articles->isEmpty())
        <p>No articles submitted yet.</p>
    @else
        <table class="my-articles-table">
            <thead>
                <tr>
                    <th>Article Title</th>
                    <th>Themes</th>
                    <th>Status</th>
                    <th>Submission Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>
                        @php
                            $themeNames = \App\Models\Theme::whereIn('id', explode(',', $article->theme_id))->pluck('name')->toArray();
                        @endphp
                        {{ implode(', ', $themeNames) }}
                    </td>
                    <td>
                        <span class="status-badge status-{{ strtolower($article->status) }}">
                            {{ $article->status }}
                        </span>
                    </td>
                    <td>{{ $article->created_at->format('d-m-Y') }}</td>
                    <td class="action">
                        <a href="{{ route('userarticle.show', $article->id) }}" class="btn-view">Voir</a>
                        <button class="edit-article-btn" data-id="{{ $article->id }}" data-title="{{ $article->title }}" data-content="{{ $article->content }}">Edit</button>                    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</section>

<!-- Edit Article Modal -->
<div id="editArticleModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Article</h2>
        <form id="editArticleForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="articleId" name="articleId">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>


<script src="{{ asset('js/user/userArticle.js') }}"></script>

</body>
</html>