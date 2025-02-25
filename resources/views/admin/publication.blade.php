@include('layouts.adminheader')
<link rel="stylesheet" href="{{ asset('css/admin/create-article.css') }}">
<!-- Create Article Section -->
<section id="publication">
    <h2>Create Article</h2>
    <form id="create-article-form" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="article-title">Title:</label>
            <input type="text" id="article-title" name="title" placeholder="Enter the article title" required />
        </div>
        <div class="form-group">
            <label for="article-theme">Theme:</label>
            <select id="article-theme" name="theme" required>
                @foreach ($themes as $theme)
                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="article-status">Status:</label>
            <select id="article-status" name="status" required>
                <option value="Published">Published</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        <div class="form-group">
            <label for="article-cover">Cover Image:</label>
            <input type="file" id="article-cover" name="cover_image" accept="image/*" required />
        </div>
        <div class="form-group">
            <label for="article-content">Content:</label>
            <textarea id="article-content" name="content" placeholder="Enter the article content" rows="6" required></textarea>
        </div>
        <button type="submit" id="create-article-btn">Create Article</button>
    </form>
</section>

<script src="{{ asset('js/admin/create-article.js') }}"></script>

</body>
</html>