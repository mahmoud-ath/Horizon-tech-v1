@include('layouts.userheader')
<link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}" />
<section id="dashboard" class="active">

    <div class="content-container">
        <!-- Recommended Articles Section (Left) -->
        <div id="recommended-articles">
            <h2>Recommended Articles</h2>
            <div id="articles-list">
                @if (isset($recommendedArticles) && count($recommendedArticles) > 0)
                    @foreach ($recommendedArticles as $article)
                        <div class="recommended-article">
                            <a style="text-decoration: none;" href="{{ url('/themes/' . $article->theme_id . '/articles/' . $article->id) }}">
                                <h3 style="">{{ $article->title }}</h3>
                            </a>
                            <p><strong>Themes:</strong>
                                @if ($article->theme)
                                    <a style="    text-decoration: none; color:var(--button-color)" href="{{ url('/themes/' . $article->theme_id) }}">
                                        {{ $article->theme->name }}
                                    </a>
                                @else
                                    Aucun thème
                                @endif
                            </p>
                            <p><strong>Status:</strong> {{ $article->status }}</p>
                            <p><strong>Date:</strong> {{ $article->updated_at->format('d-m-Y') }}</p>
                            <a href="{{ url('/themes/' . $article->theme_id . '/articles/' . $article->id) }}">
                                <img src="{{ asset($article->imagepath) }}" alt="{{ $article->title }}">
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>No recommended items at this time. subscribe to a new theme first </p>
                @endif
            </div>
        </div>
        <!-- Magazine Issues Section (Right) -->
        <div>

            <div id="magazine-issues">
                <h2>Magazine Issues</h2>
                <div id="issues-list">
                    @if (isset($magazineIssues) && count($magazineIssues) > 0)
                        @foreach ($magazineIssues as $issue)
                            <div class="magazine-issue">
                                <h3>{{ $issue->name }}</h3>
                                <img src="{{ asset('admin_numbers/' . $issue->imagepath) }}" alt="{{ $issue->name }}"
                                    style="background-size: cover; height: 300px;" />
                                <a href="{{ url('numbers/' . $issue->id) }}">
                                    <button>Read more</button>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p>No issue of the magazine available at the moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<script>
    function performSearch() {
        const query = document.getElementById('search-input').value;
        alert('Searching for: ' + query);
        // Add your search logic here
    }
</script>
</body>

</html>
