<!-- article.blade.php -->
@include('layouts.Officiel-header')
<link rel="stylesheet" href="{{ asset('css/gestion/article.css') }}">

<meta name="article-id" content="{{ $article->id }}">
<meta name="theme-id" content="{{ $article->theme_id ?? 'null' }}">
<meta name="issue-id" content="{{ $issueId ?? 'null' }}">

<main class="article-page">
    <section class="article-header">
        <h1 class="article-title">{{ $article->title }}</h1>
        <p class="article-meta">Published on {{ $article->created_at->format('d/m/Y') }} | By {{ $article->user->name }}</p>
    </section>

    <section class="article-content">
        <div class="image-container">
            <img src="{{ asset($article->imagepath) }}" alt="Article Image" class="article-image">
        </div>
        <p id="article-body">{{ $article->content }}</p>
    </section>

    <section class="article-rating">
        <h3>Rate this article</h3>
        <div class="stars-container">
            @for ($i = 1; $i <= 5; $i++)
                <span class="star {{ $article->userRating && $article->userRating->rating >= $i ? 'selected' : '' }}"
                      data-value="{{ $i }}">★</span>
            @endfor
        </div>
    </section>

    <section class="article-comments">
        <h2>Comments</h2>
        <div id="comments-section">
            @foreach($comments as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
        </div>
        <form id="comment-form">
            <textarea id="comment-text" placeholder="Add your comment..."></textarea>
            <button type="submit" class="btn">Publish</button>
        </form>
    </section>
</main>

@include('layouts.Officiel-footer')
<script src="{{ asset('js/article.js') }}"></script>
</body>
</html>
