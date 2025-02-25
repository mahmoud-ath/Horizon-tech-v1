@include('layouts.Officiel-header')
<link rel="stylesheet" href="{{ asset('css/accueil/home-page.css') }}">
<!-- Main Section -->
<section class="main">
    <div class="img">
        <img src="{{ asset('images/Object.png') }}" style="flex: 1; background-repeat: no-repeat; background-size: 80%; background-position: center; height: 100%;" />
    </div>
    <div class="content">
        <h1>Welcome to Tech Horizon</h1>
        <p>Exploring the future of technology and innovation.</p>
        <a href="/register">
            <button>Join us</button>
        </a>
    </div>
</section>

<!-- Magazine Section -->
<section class="mg">
    <h2>Our Magazine Editions</h2>
    <section class="magazine-section">
        @foreach($issues as $issue)
        <div class="magazine-card">
            <div class="card-image">
                <img src="{{ asset('admin_numbers/' . $issue->imagepath) }}" alt="{{ $issue->name }}" style="background-size: cover; height: 300px;" />
            </div>
            <div class="card-content">
                <p>{{ $issue->name }}</p>
                <a href="{{ url('numbers/' . $issue->id) }}">
                    <button>Read more</button>
                </a>
            </div>
        </div>
        @endforeach
    </section>
</section>
<script src="{{ asset('js/search.js') }}"></script>

@include('layouts.Officiel-footer')

</body>

</html>
