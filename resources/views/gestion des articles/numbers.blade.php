@include('layouts.Officiel-header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="{{ asset('css/gestion/anounces.css') }}">
<main>
    <h2>Announcements of Published Issue Articles</h2>
    <p class="inf">Discover the latest articles published on Tech Horizons</p>
    <!-- numbers.blade.php -->
    <section id="articles">
        @foreach ($articles as $article)
        <div class="article-item">
            <div class="article-container">
                <div class="article-content">
                    <h3 class="article-title"><a href="{{ url('numbers/' . $issue->id . '/' . $article->id) }}">{{ $article->title }}</a></h3>
                    <p class="article-meta">Publié le {{ \Carbon\Carbon::parse($article->published_date)->format('d/m/Y') }} | Par {{ $article->user->name }}</p>
                    <p>{{ Str::limit($article->content, 150) }}</p>
                    <p>Vues : {{ $article->views }}</p>
                    <a href="{{ url('numbers/' . $issue->id . '/' . $article->id)}}" class="read-more">read-more</a>
                    <button class="share-btn article-content"
                            data-url="{{ url('numbers/' . $issue->id . '/' . $article->id) }}"
                            onclick="openShareModal(this)">
                        <i class="fas fa-share"></i> Share
                    </button>
                </div>
                <div class="article-image">
                    <a href="{{ url('numbers/' . $issue->id . '/' . $article->id) }}">
                        <img src="{{ asset($article->imagepath) }}" alt="Image de l'article" class="article-image">
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </section>


</main>
@include('layouts.Officiel-footer')
<script src="{{ asset('js/themes.js') }}"></script>
<!-- Add this right after your opening <body> tag -->
    <div id="shareModal" class="share-modal">
        <div class="share-modal-content">
            <span class="close-modal">&times;</span>
            <h3>Share Article</h3>
            <div class="share-url-container">
                <input type="text" id="shareUrl" readonly>
                <button onclick="copyShareUrl()" class="copy-btn">
                    <i class="fas fa-copy"></i> Copy
                </button>
            </div>
            <div class="social-share-buttons">
                <button onclick="shareToSocial('facebook')" class="facebook">
                    <i class="fab fa-facebook"></i> Facebook
                </button>
                <button onclick="shareToSocial('twitter')" class="twitter">
                    <i class="fab fa-twitter"></i> Twitter
                </button>
                <button onclick="shareToSocial('linkedin')" class="linkedin">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </button>
                <button onclick="shareToSocial('whatsapp')" class="whatsapp">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </button>
            </div>
        </div>
    </div>
    
    <!-- Replace your existing script with this -->
    <script>
    let currentShareUrl = '';
    
    function openShareModal(button) {
        const modal = document.getElementById('shareModal');
        const shareUrlInput = document.getElementById('shareUrl');
        currentShareUrl = button.getAttribute('data-url');
        shareUrlInput.value = currentShareUrl;
        modal.style.display = 'block';
    }
    
    function copyShareUrl() {
        const shareUrlInput = document.getElementById('shareUrl');
        shareUrlInput.select();
        document.execCommand('copy');
    
        showMessage('Link copied to clipboard!');
    }
    
    function shareToSocial(platform) {
        const url = encodeURIComponent(currentShareUrl);
        let shareUrl = '';
    
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${url}`;
                break;
        }
    
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
    
    function showMessage(text) {
        const message = document.createElement('div');
        message.textContent = text;
        message.className = 'toast-message';
        document.body.appendChild(message);
    
        setTimeout(() => message.remove(), 2000);
    }
    
    // Close modal when clicking the close button or outside the modal
    document.querySelector('.close-modal').onclick = function() {
        document.getElementById('shareModal').style.display = 'none';
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('shareModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>
    
    </body>
    
    </html>
    
</body>

</html>