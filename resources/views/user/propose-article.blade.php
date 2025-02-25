<!-- propose-article.blade.php -->
@include('layouts.userheader')
<link rel="stylesheet" href="{{ asset('css/user/proposeArticle.css') }}">

<div id="notification" class="notification">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<section id="propose-article">
    <h1>Propose an Article</h1>
    <form id="article-form" method="POST" action="{{ route('submit-article') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="article-title">Article Title</label>
            <input type="text" id="article-title" name="title" placeholder="Article Title" required>
        </div>

        <div class="form-group">
            <label for="article-themes">Article Theme</label>
            <select id="article-themes" name="theme" required>
                @foreach($themes as $theme)
                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="article-cover">Cover Image</label>
            <input type="file" id="article-cover" name="cover_image" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="article-description">Article Description</label>
            <textarea id="article-description" name="content" rows="4" placeholder="Your article content" required></textarea>
        </div>

        <button type="submit" id="submit-article-btn">Submit Article</button>
    </form>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="{{ asset('js/user/userProposal.js') }}"></script>
</body>
</html>