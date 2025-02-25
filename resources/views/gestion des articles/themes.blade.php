@include('layouts.Officiel-header')
<link rel="stylesheet" href="{{ asset('css/gestion/themes.css') }}">
<main>
    <section class="theme-container">
        <h2>Explore our themes</h2>
        <div class="themes-card">
            @foreach($themes as $theme)

            <div class="theme-card">
                <a href="{{ url('themes/' . $theme->id) }}" class="theme-card-link">
                    <img src="{{asset( 'admin_themes/'. $theme->imagepath) }}" alt="{{ $theme->name }}">

                    <h3>{{ $theme->name }}</h3>
                    <p>{{ $theme->description }}</p>
                    <p class="article-count">Published articles: <span id="ai-count">{{ $theme->articles_count }}</span></p>
                    <p class="theme-score"> <span id="ai-score"></span></p>
                </a>
                <button class="subscribe-btn" id="subscribe-{{ $theme->id }}" onclick="toggleSubscription('{{ $theme->id }}')">
                    @if($theme->isSubscribed) Unsubscribe @else Subscribe @endif
                </button>
            </div>


            @endforeach
        </div>
    </section>
</main>

<script src="{{ asset('js/themes.js') }}"></script>

@include('layouts.Officiel-footer')



</body>

</html>
